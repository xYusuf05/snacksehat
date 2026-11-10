# 📋 Rencana Pengujian Sistem (Test Plan Document)
**Nama Sistem**: SnackCheck - Sistem Klasifikasi Snack Sehat Berbasis Decision Tree CART  
**Versi Dokumen**: 1.0  
**Tanggal**: 3 Agustus 2026  
**Metode Pengujian**: *Black-Box Testing* (Pengujian Fungsionalitas)  

---

## 1. Pendahuluan
Dokumen ini berisi rencana pengujian fungsionalitas (*black-box testing*) untuk aplikasi **SnackCheck**. Pengujian dilakukan untuk memastikan seluruh fitur autentikasi, manajemen data snack, proses prediksi Machine Learning (CART), mekanisme *fallback*, dashboard analitik, hingga hak akses pengguna (*Role-Based Access Control*) berjalan sesuai dengan kebutuhan sistem.

---

## 2. Lingkungan Pengujian (Test Environment)
- **Web Backend & UI**: Laravel 11 (PHP 8.2+) di `http://localhost:8000`
- **Machine Learning API**: Python Flask di `http://127.0.0.1:5000`
- **Model ML**: Decision Tree CART (`cart_model.pkl` & `label_encoder.pkl`)
- **Database**: MySQL / SQLite
- **Browser Target**: Google Chrome / Microsoft Edge / Mozilla Firefox

---

## 3. Tabel Rencana Pengujian

| Kelas Uji | Kode Butir Uji | Nama Butir Uji | Aktor | Hasil yang Diharapkan |
| :--- | :--- | :--- | :--- | :--- |
| **1. Autentikasi & Otorisasi** | KU-01 | Registrasi Akun Baru | User Publik | Pengguna berhasil membuat akun baru dengan role default `user` dan dapat melakukan login. |
| | KU-02 | Login Akun Valid | User / Admin | Pengguna/Admin berhasil masuk ke dalam sistem dan diarahkan ke halaman Dashboard sesuai role-nya. |
| | KU-03 | Login Kredensial Salah | User / Admin | Sistem menolak login dan menampilkan pesan kesalahan "Credentials do not match". |
| | KU-04 | Login Akun Nonaktif | User | Sistem menolak akses masuk bagi akun yang telah dinonaktifkan oleh Admin. |
| | KU-05 | Restriksi Akses Admin | User | Sistem menampilkan `403 Forbidden` saat User biasa mencoba mengakses URL `/admin/*`. |
| | KU-06 | Logout Sistem | User / Admin | Sesi pengguna diakhiri dan pengguna dikembalikan ke halaman login. |
| **2. Klasifikasi & Manajemen Snack** | KU-07 | Tambah Snack & Klasifikasi ML (Flask API Online) | User / Admin | Data snack tersimpan, API Flask memprediksi kategori (`Snack Sehat`, `Perlu Perhatian`, atau `Klaim Sehat Diragukan`), serta menghitung nilai *confidence score*. |
| | KU-08 | Tambah Snack saat Flask API Offline | User / Admin | Sistem secara otomatis menggunakan *Fallback Rule-Based* di Laravel untuk menentukan hasil klasifikasi tanpa terjadi error/crash. |
| | KU-09 | Validasi Input Gizi Negatif / Kosong | User / Admin | Sistem menolak form submission dan menampilkan pesan validasi error pada field yang tidak sesuai batas. |
| | KU-10 | Lihat Detail Snack | User / Admin | Menampilkan detail nilai kandungan gizi snack, badge kategori, riwayat pengujian, dan probabilitas persentase ML. |
| | KU-11 | Edit Data Snack | User / Admin | Data gizi snack berhasil diperbarui, sistem melakukan re-klasifikasi ulang, dan menambahkan catatan histori baru. |
| | KU-12 | Hapus Data Snack | User / Admin | Data snack berhasil dihapus dari basis data. User hanya dapat menghapus snack miliknya sendiri, sedangkan Admin dapat menghapus snack siapapun. |
| | KU-13 | Isolasi Data Snack (Data Privacy) | User | User A tidak dapat melihat, mengedit, atau menghapus data snack milik User B. |
| **3. Histori Klasifikasi** | KU-14 | Menampilkan Daftar Histori | User / Admin | User melihat daftar riwayat klasifikasi miliknya sendiri, sedangkan Admin melihat riwayat seluruh pengguna. |
| | KU-15 | Detail Histori Klasifikasi | User / Admin | Menampilkan rincian parameter input gizi saat klasifikasi dilakukan beserta persentase *confidence score*. |
| | KU-16 | Hapus Catatan Histori | User / Admin | Catatan histori yang dipilih berhasil dihapus dari sistem. |
| **4. Dashboard & Analitik** | KU-17 | Visualisasi Donut Chart & Trend 6 Bulan | User / Admin | Donut Chart menampilkan proporsi kategori snack saat ini, dan Line Chart menampilkan tren klasifikasi 6 bulan terakhir. |
| | KU-18 | Indikator Status Flask API | User / Admin | Menampilkan badge hijau (Online/Healthy) jika Flask API aktif, dan badge merah/warning jika Flask API mati. |
| | KU-19 | Widget Statistik Admin | Admin | Dashboard Admin menampilkan total pengguna, total klasifikasi hari ini, serta daftar Top User paling aktif. |
| **5. Manajemen Pengguna (Khusus Admin)** | KU-20 | Menampilkan Daftar Pengguna | Admin | Admin dapat melihat seluruh daftar pengguna beserta role dan status keaktifan akun. |
| | KU-21 | Ubah Role Pengguna | Admin | Role pengguna berhasil diperbarui (misal: dari `user` menjadi `admin` atau sebaliknya). |
| | KU-22 | Toggle Status Akun (Aktif / Nonaktif) | Admin | Status akun pengguna berhasil diubah antara `Aktif` dan `Nonaktif`. |
| **6. Export Data & Laporan** | KU-23 | Export Data Snack ke PDF | User / Admin | Sistem mendownload file PDF berformat Landscape yang berisi tabel ringkasan data snack sesuai filter. |
| | KU-24 | Export Data Snack ke Excel | User / Admin | Sistem mendownload file spreadsheet `.xlsx` berisi seluruh data nutrisi dan hasil klasifikasi snack. |
| **7. Flask ML API (Direct Endpoints)** | KU-25 | Endpoint `GET /health` | System / API Client | Mengembalikan response JSON status `ok` dan daftar kelas kategori ML. |
| | KU-26 | Endpoint `POST /predict` | System / API Client | Mengembalikan JSON hasil klasifikasi, nilai *confidence*, dan metode yang digunakan (`CART Decision Tree` atau `Rule-Based`). |
| | KU-27 | Endpoint `POST /batch-predict` | System / API Client | Menerima array JSON berisi multiple data snack dan mengembalikan array hasil prediksi tiap produk. |

---

## 4. Kesimpulan Pengujian
Rencana pengujian di atas mencakup seluruh kebutuhan fungsionalitas sistem **SnackCheck**. Pengujian dilakukan untuk memastikan keandalan Machine Learning model, ketahanan sistem ketika API eksternal mengalami kendala, serta keamanan hak akses pengguna.
