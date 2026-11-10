<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClassifierService
{
    private string $baseUrl;
    private int    $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.classifier.url', 'http://127.0.0.1:5000');
        $this->timeout = config('services.classifier.timeout', 10);
    }

    /**
     * Kirim data gizi ke Flask API dan dapatkan hasil klasifikasi.
     *
     * @return array{hasil: string, confidence: array, method: string}
     */
    public function predict(float $gula, float $natrium, float $lemak, float $serat): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->acceptJson()
                ->post("{$this->baseUrl}/predict", [
                    'gula'    => $gula,
                    'natrium' => $natrium,
                    'lemak'   => $lemak,
                    'serat'   => $serat,
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Classifier API error response', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            // Fallback rule-based jika API error
            return $this->fallbackClassify($gula, $natrium, $lemak, $serat);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Classifier API tidak dapat dihubungi: ' . $e->getMessage());
            return $this->fallbackClassify($gula, $natrium, $lemak, $serat);
        }
    }

    /**
     * Prediksi banyak snack sekaligus.
     */
    public function batchPredict(array $snacks): array
    {
        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->post("{$this->baseUrl}/batch-predict", $snacks);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            Log::error('Batch predict error: ' . $e->getMessage());
        }

        return ['total' => 0, 'results' => []];
    }

    /**
     * Cek apakah Python API sedang berjalan.
     */
    public function isHealthy(): bool
    {
        try {
            $response = Http::timeout(3)->get("{$this->baseUrl}/health");
            return $response->successful() && ($response->json('status') === 'ok');
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Klasifikasi manual (fallback jika API Python tidak aktif).
     */
    private function fallbackClassify(float $gula, float $natrium, float $lemak, float $serat): array
    {
        if ($gula <= 5 && $lemak <= 3 && $natrium <= 140 && $serat >= 3) {
            $hasil = 'Snack Sehat';
        } elseif (($gula > 10 && $lemak > 8) || $natrium > 300) {
            $hasil = 'Klaim Sehat Diragukan';
        } else {
            $hasil = 'Perlu Perhatian';
        }

        return [
            'hasil'      => $hasil,
            'confidence' => [],
            'method'     => 'Rule-Based (Laravel Fallback)',
        ];
    }
}