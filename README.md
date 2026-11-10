# 🍿 SnackCheck – Sistem Klasifikasi Camilan Sehat

SnackCheck adalah aplikasi berbasis web yang mengklasifikasikan kelayakan/kategori camilan (snack) berdasarkan kandungan nutrisi (Gula, Natrium, Lemak, Serat) menggunakan algoritma **CART (Classification and Regression Trees)** yang terintegrasi antara **Laravel 11** dan **Python Flask API**.

---

## 🏗️ Arsitektur Proyek

Proyek ini terdiri dari dua layanan utama:

```
snackv1/
├── docs/                   # Dokumen pengujian sistem & dokumentasi
│   ├── bab_6_pengujian_sistem.md
│   ├── rencana_pengujian.md
│   └── tabel_pengujian_sistem.md
├── python-api/             # Backend Machine Learning (Flask + scikit-learn)
│   ├── app.py              # Endpoint REST API Klasifikasi CART (Port 5000)
│   ├── train_model.py      # Script pelatihan model CART
│   ├── dataset_final.csv   # Dataset nutrisi camilan
│   ├── cart_model.pkl      # Model CART serialisasi
│   ├── label_encoder.pkl   # Serialisasi label encoder
│   └── requirements.txt    # Dependensi Python
├── snackv1/                # Web Application (Laravel 11)
│   ├── app/                # Controllers, Models, Services
│   ├── resources/views/    # Antarmuka Blade & Tailwind CSS
│   ├── routes/             # Route web
│   └── composer.json       # Dependensi PHP
├── start.bat               # Windows one-click launcher (Laragon)
└── README.md
```

---

## 🛠️ Persyaratan Sistem

- **OS**: Windows (direkomendasikan dengan Laragon) / Linux / macOS
- **PHP**: >= 8.2 (dengan ekstensi: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON)
- **Composer**: >= 2.x
- **Python**: >= 3.10
- **Database**: MySQL / MariaDB

---

## 🚀 Panduan Instalasi & Menjalankan

### Cara Cepat (Windows + Laragon)

1. Pastikan **Laragon** berjalan (Apache/Nginx & MySQL aktif).
2. Buat database baru di MySQL dengan nama `snackv1`.
3. Buka folder `snackv1/` (Laravel):
   ```bash
   cd snackv1
   cp .env.example .env
   composer install
   php artisan key:generate
   php artisan migrate --seed
   ```
4. Buka folder `python-api/`:
   ```bash
   cd ../python-api
   python -m venv venv
   venv\Scripts\activate
   pip install -r requirements.txt
   ```
5. Jalankan aplikasi dengan mengklik dua kali file `start.bat` di root direktori.
   File ini otomatis:
   - Mengaktifkan Flask API di `http://127.0.0.1:5000`
   - Melatih model CART jika belum ada
   - Mengaktifkan Laravel server di `http://localhost:8000`
   - Membuka browser ke aplikasi

---

### Cara Manual

#### 1. Menjalankan Python Flask API
```bash
cd python-api
python -m venv venv
# Windows:
venv\Scripts\activate
# Linux/macOS:
# source venv/bin/activate

pip install -r requirements.txt
python train_model.py    # Melatih model
python app.py            # Berjalan di port 5000
```

#### 2. Menjalankan Laravel
```bash
cd snackv1
composer install
npm install && npm run build # (Opsional jika mengcompile aset)
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve        # Berjalan di port 8000
```

---

## 🔐 Kredensial Default

Setelah menjalankan migrasi dan seeding:
- **Admin**: `admin@snackcheck.com` / `password`
- **User**: `user@snackcheck.com` / `password`

---

## 📡 API Endpoint (Python CART Service)

- `GET /health` – Pengecekan status layanan Flask API.
- `POST /predict` – Melakukan klasifikasi camilan berdasarkan fitur nutrisi:
  ```json
  {
    "gula": 5.0,
    "natrium": 120.0,
    "lemak": 3.5,
    "serat": 2.0
  }
  ```
  **Response:**
  ```json
  {
    "status": "success",
    "prediction": "Camilan Sehat",
    "probabilities": { ... }
  }
  ```

---

## 📄 Lisensi
Proyek ini dibuat untuk keperluan akademik dan penelitian sistem klasifikasi camilan sehat.

