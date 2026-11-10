<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 – Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { min-height: 100vh; display:flex; align-items:center; justify-content:center; background:#f8fafc; }
    </style>
</head>
<body>
    <div class="text-center px-4">
        <div style="font-size:5rem;color:#e2e8f0; line-height:1;">
            <i class="bi bi-shield-x"></i>
        </div>
        <h1 class="fw-800 mt-3" style="font-size:4rem;color:#0f172a;">403</h1>
        <h5 class="fw-600 text-secondary mb-2">Akses Ditolak</h5>
        <p class="text-secondary mb-4">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-3 px-4">
            <i class="bi bi-house me-2"></i>Kembali ke Dashboard
        </a>
    </div>
</body>
</html>