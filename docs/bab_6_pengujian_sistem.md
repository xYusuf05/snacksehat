# BAB VI: PENGUJIAN DAN ANALISIS

## 6.2 Pengujian Sistem
Pengujian sistem merupakan tahap yang sangat krusial dalam siklus pengembangan perangkat lunak untuk memastikan bahwa aplikasi **SnackCheck** yang telah dibangun bebas dari *bug* atau kesalahan logika, serta telah memenuhi seluruh kebutuhan fungsionalitas yang telah dirancang sebelumnya. Pada penelitian ini, pengujian sistem dilakukan menggunakan metode ***Black Box Testing***.

Metode *Black Box Testing* berfokus pada pengujian persyaratan fungsional perangkat lunak tanpa perlu mengetahui struktur kode internal atau alur program di dalamnya. Pengujian dilakukan dengan cara memberikan input tertentu pada sistem, kemudian mengamati dan mengevaluasi respon atau output yang dihasilkan apakah telah sesuai dengan hasil yang diharapkan.

---

### 6.2.1 Rencana Pengujian Fungsional (*Black Box Testing*)
Rencana pengujian fungsional dirancang untuk mencakup seluruh modul dan fitur utama dalam sistem **SnackCheck**, mulai dari sistem autentikasi, manajemen data snack, proses prediksi Machine Learning (CART), mekanisme *fallback*, dashboard analitik, manajemen pengguna (admin), hingga ekport laporan.

Tabel 6.1 berikut menyajikan matriks rencana pengujian fungsionalitas sistem.

**Tabel 6.1 Rencana Pengujian Fungsional (*Black Box Testing*)**

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

### 6.2.2 Hasil Pengujian (*Black Box Testing*)
Berikut merupakan rincian hasil eksekusi pengujian fungsionalitas sistem berdasarkan kasus uji yang terdapat pada Rencana Pengujian. Setiap butir uji diobservasi dan divalidasi antara respon yang terjadi dengan respon yang diharapkan, serta dilengkapi dengan penjelasannya.

---

#### A. MODUL 1: AUTENTIKASI & OTORISASI

##### 1. Kasus Uji KU-01: Registrasi Akun Baru
**Penjelasan Pengujian**:  
Pengujian ini dilakukan untuk memastikan bahwa calon pengguna baru dapat mendaftarkan akun secara mandiri melalui form registrasi di alamat `/register`. Pengujian memeriksa validasi pengisian data serta pembuatannya di basis data dengan role default `user` dan status akun aktif secara otomatis.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-01 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Autentikasi & Otorisasi | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Registrasi Akun Baru | | |
| **Deskripsi Uji** | Menguji proses pendaftaran akun pengguna baru melalui form registrasi | | |
| **Kondisi Awal** | Pengguna belum login dan membuka halaman utama/register | | |
| **Dependensi** | Form Register, Database Users | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Akses URL `/register` | URL `/register` | Halaman formulir registrasi tampil | Halaman tampil sesuai desain | Sukses | - |
| 2 | Isi nama, email, password, dan konfirmasi password valid | `Name: Budi`, `Email: budi@test.com`, `Pass: password123` | Form terisi secara valid | Seluruh field terisi dengan benar | Sukses | - |
| 3 | Klik tombol **Register** | Event Submit Form | Akun tersimpan di DB dengan `role=user` & `is_active=true`, lalu redirect ke Dashboard | Akun berhasil dibuat dan otomatis login ke Dashboard | Sukses | Default role `user` |

**Kondisi Akhir**: Akun pengguna terbuat di database dan session aktif pengguna berada di halaman `/dashboard`.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.1 Tampilan Pengujian Registrasi Akun Baru](path_tangkapan_layar/gambar_6_1_registrasi_akun.png)
> 
> *Gambar 6.1 Tampilan Pengujian Registrasi Akun Baru*

---

##### 2. Kasus Uji KU-02: Login Akun Valid
**Penjelasan Pengujian**:  
Pengujian ini bertujuan untuk menguji proses autentikasi masuk ke dalam aplikasi menggunakan kombinasi email dan password terdaftar, baik untuk akun dengan hak akses `admin` maupun `user`. Pengujian memvalidasi bahwa sistem secara tepat mengarahkan pengguna ke halaman Dashboard yang sesuai dengan role masing-masing.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-02 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Autentikasi & Otorisasi | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Login Akun Valid (Admin & User) | | |
| **Deskripsi Uji** | Menguji autentikasi masuk sistem menggunakan email & password yang terdaftar | | |
| **Kondisi Awal** | Pengguna berada di halaman `/login` | | |
| **Dependensi** | Auth Controller, Database Users | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Input email & password akun terdaftar | `admin@snackcheck.com` / `password` | Input terisi pada form login | Input terisi | Sukses | Pengujian Admin |
| 2 | Klik tombol **Log in** | Event Submit | Berhasil autentikasi & redirect ke Dashboard dengan hak akses Admin | Masuk ke Dashboard Admin | Sukses | Menu Admin tampil |
| 3 | Input email & password akun user | `user@snackcheck.com` / `password` | Input terisi pada form login | Input terisi | Sukses | Pengujian User |
| 4 | Klik tombol **Log in** | Event Submit | Berhasil autentikasi & redirect ke Dashboard dengan hak akses User | Masuk ke Dashboard User | Sukses | Menu Admin tersembunyi |

**Kondisi Akhir**: Pengguna berhasil autentikasi dan diarahkan ke Dashboard sesuai role masing-masing.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.2 Tampilan Pengujian Login Akun Valid](path_tangkapan_layar/gambar_6_2_login_valid.png)
> 
> *Gambar 6.2 Tampilan Pengujian Login Akun Valid*

---

##### 3. Kasus Uji KU-03: Login Kredensial Salah
**Penjelasan Pengujian**:  
Pengujian ini memverifikasi keandalan penanganan kesalahan autentikasi saat pengguna memasukkan kombinasi email atau password yang tidak cocok atau belum terdaftar. Pengujian memastikan bahwa login ditolak dan notifikasi kesalahan ditampilkan dengan jelas.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-03 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Autentikasi & Otorisasi | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Login Kredensial Salah | | |
| **Deskripsi Uji** | Menguji penanganan error saat kombinasi email/password salah | | |
| **Kondisi Awal** | Pengguna berada di halaman `/login` | | |
| **Dependensi** | Auth Controller | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Masukkan email terdaftar tapi password salah | `user@snackcheck.com` / `wrongpass` | Sistem menolak login dan menampilkan pesan validasi error | Sistem menampilkan pesan error kredensial salah | Sukses | Session login gagal |

**Kondisi Akhir**: Pengguna tetap berada di halaman `/login` dengan notifikasi error.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.3 Tampilan Pengujian Login Kredensial Salah](path_tangkapan_layar/gambar_6_3_login_salah.png)
> 
> *Gambar 6.3 Tampilan Pengujian Login Kredensial Salah*

---

##### 4. Kasus Uji KU-04: Login Akun Nonaktif
**Penjelasan Pengujian**:  
Pengujian ini bertujuan untuk memvalidasi fungsi pemblokiran akun yang telah dinonaktifkan oleh Admin (`is_active = false`). Sistem harus mencegah pengguna dengan status nonaktif untuk melakukan autentikasi ke dalam sistem.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-04 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Autentikasi & Otorisasi | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Login Akun Nonaktif (`is_active=false`) | | |
| **Deskripsi Uji** | Memastikan akun yang dinonaktifkan oleh Admin tidak dapat melakukan login | | |
| **Kondisi Awal** | Terdapat akun dengan status `is_active=false` di DB | | |
| **Dependensi** | User Model `isActive()`, Auth Middleware | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Masukkan kredensial akun nonaktif | `disabled_user@snackcheck.com` / `password` | Login ditolak dengan keterangan akun dinonaktifkan | Login ditolak | Sukses | Akun di-block |

**Kondisi Akhir**: Pengguna gagal login dan disajikan pesan penolakan akses.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.4 Tampilan Pengujian Login Akun Nonaktif](path_tangkapan_layar/gambar_6_4_login_nonaktif.png)
> 
> *Gambar 6.4 Tampilan Pengujian Login Akun Nonaktif*

---

##### 5. Kasus Uji KU-05: Restriksi Akses Admin oleh User
**Penjelasan Pengujian**:  
Pengujian ini memverifikasi keamanan otorisasi *Role-Based Access Control* (RBAC) dengan mencoba mengakses URL rute khusus Admin (`/admin/*`) menggunakan akun dengan role `user` biasa.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-05 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Autentikasi & Otorisasi | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Restriksi Akses Fitur Admin | | |
| **Deskripsi Uji** | Menguji proteksi middleware `role:admin` dari akses pengguna biasa | | |
| **Kondisi Awal** | User biasa (`role=user`) sedang dalam posisi login | | |
| **Dependensi** | Middleware `RoleMiddleware` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Akses URL khusus admin secara langsung | `http://localhost:8000/admin/users` | Akses ditolak dengan status HTTP `403 Forbidden` | Menampilkan halaman HTTP 403 | Sukses | Restriksi bekerja |

**Kondisi Akhir**: Pengguna ditolak masuk ke halaman admin dan mendapat respon `403 Forbidden`.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.5 Tampilan Restriksi Akses Fitur Admin HTTP 403](path_tangkapan_layar/gambar_6_5_restriksi_admin.png)
> 
> *Gambar 6.5 Tampilan Restriksi Akses Fitur Admin (HTTP 403 Forbidden)*

---

##### 6. Kasus Uji KU-06: Logout Sistem
**Penjelasan Pengujian**:  
Pengujian ini bertujuan untuk memastikan fungsi *logout* menghancurkan sesi login pengguna secara sempurna dan mengembalikan sistem ke halaman autentikasi/login awal.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-06 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Autentikasi & Otorisasi | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Logout Sistem | | |
| **Deskripsi Uji** | Menguji pengakhiran sesi pengguna | | |
| **Kondisi Awal** | Pengguna dalam keadaan terautentikasi (login) | | |
| **Dependensi** | Auth Session Controller | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Klik tombol **Logout** | Event POST `/logout` | Session dihapus dan redirect ke Halaman Utama / Login | Pengguna keluar dan kembali ke Halaman Login | Sukses | Session dihancurkan |

**Kondisi Akhir**: Session pengguna bersih dan pengguna berada di halaman unauthenticated.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.6 Tampilan Pengujian Logout Sistem](path_tangkapan_layar/gambar_6_6_logout.png)
> 
> *Gambar 6.6 Tampilan Pengujian Logout Sistem*

---

#### B. MODUL 2: KLASIFIKASI & MANAJEMEN SNACK

##### 7. Kasus Uji KU-07: Tambah Snack & Klasifikasi ML (Flask API Online)
**Penjelasan Pengujian**:  
Pengujian ini memvalidasi fitur utama aplikasi, yaitu penambahan data gizi snack baru (`gula`, `natrium`, `lemak`, `serat`) dan pemrosesan klasifikasi berbasis Machine Learning CART melalui integrasi HTTP request ke Python Flask API.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-07 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Klasifikasi & Snack | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Tambah Snack & Klasifikasi ML CART (API Online) | | |
| **Deskripsi Uji** | Menguji penambahan data gizi snack baru dan klasifikasi berbasis model CART via Flask API | | |
| **Kondisi Awal** | User terautentikasi & Flask API berjalan di `127.0.0.1:5000` | | |
| **Dependensi** | `SnackController`, `ClassifierService`, Python Flask API | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Akses Halaman Tambah Snack | URL `/snacks/create` | Form input nilai nutrisi tampil | Form tampil dengan 4 parameter nutrisi | Sukses | - |
| 2 | Masukkan data nutrisi snack valid | `Nama: Oat Bar`, `Gula: 3`, `Natrium: 90`, `Lemak: 2`, `Serat: 4` | Form terisi valid | Terisi valid | Sukses | - |
| 3 | Klik tombol **Simpan & Klasifikasikan** | Form Submit | Data tersimpan di DB, API Flask mengembalikan `hasil="Snack Sehat"` dan *confidence score*, tersimpan ke Histori | Berhasil diklasifikasikan sebagai `Snack Sehat` dengan persentase confidence | Sukses | Menggunakan CART ML |

**Kondisi Akhir**: Snack baru tersimpan di DB beserta hasil klasifikasi CART ML dan catatan histori baru dibuat.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.7 Tampilan Tambah Snack & Hasil Klasifikasi CART ML](path_tangkapan_layar/gambar_6_7_tambah_snack_cart.png)
> 
> *Gambar 6.7 Tampilan Tambah Snack & Hasil Klasifikasi CART ML*

---

##### 8. Kasus Uji KU-08: Tambah Snack saat Flask API Offline (Fallback Rule-Based)
**Penjelasan Pengujian**:  
Pengujian ini bertujuan untuk membuktikan ketahanan sistem (*fault tolerance*). Ketika Flask API sedang tidak aktif/down, Laravel secara transparan mengalihkan klasifikasi ke metode *Rule-Based Fallback* tanpa menimbulkan pesan error 500.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-08 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Klasifikasi & Snack | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Fallback Klasifikasi saat Flask API Offline | | |
| **Deskripsi Uji** | Memastikan sistem tetap berjalan tanpa crash ketika Python Flask API mati | | |
| **Kondisi Awal** | Server Flask API ditutup/dimatikan | | |
| **Dependensi** | `ClassifierService::fallbackClassify` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Input data snack dan klik Simpan saat Flask Offline | `Nama: Keripik Pedas`, `Gula: 12`, `Natrium: 350`, `Lemak: 10`, `Serat: 1` | `ConnectionException` ditangkap, sistem menggunakan `fallbackClassify` rule-based (`Klaim Sehat Diragukan`) | Berhasil diklasifikasikan via `Rule-Based (Laravel Fallback)` tanpa error 500 | Sukses | Mechanism Fallback Berjalan |

**Kondisi Akhir**: Data snack tetap berhasil disimpan dengan kategori `Klaim Sehat Diragukan` melalui metode fallback.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.8 Tampilan Pengujian Fallback Rule-Based saat API Offline](path_tangkapan_layar/gambar_6_8_fallback_rule_based.png)
> 
> *Gambar 6.8 Tampilan Pengujian Fallback Rule-Based saat API Offline*

---

##### 9. Kasus Uji KU-09: Validasi Input Gizi Negatif / Kosong
**Penjelasan Pengujian**:  
Pengujian ini mengevaluasi validasi input form. Sistem ditantang dengan memasukkan data nutrisi bernilai negatif atau dikosongkan untuk memastikan sistem menolak data tersebut secara tepat.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-09 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Klasifikasi & Snack | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Validasi Input Nutrisi Invalid | | |
| **Deskripsi Uji** | Menguji penolakan form saat input angka negatif, non-numerik, atau kosong | | |
| **Kondisi Awal** | Form tambah snack terbuka | | |
| **Dependensi** | Laravel Form Validation Request | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Masukkan angka negatif pada gizi | `Gula: -5`, `Natrium: 100`, `Lemak: 2`, `Serat: 3` | Form ditolak, muncul pesan error "min:0" | Form ditolak dengan notifikasi error | Sukses | Validasi batas bawah |
| 2 | Kosongkan kolom `Nama Produk` | `Nama: ""` | Form ditolak, muncul pesan "field wajib diisi" | Ditolak | Sukses | Mandatory check |

**Kondisi Akhir**: Form tidak tersubmit, data tidak masuk database, dan kesalahan ditampilkan pada UI.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.9 Tampilan Validasi Error Form Input Snack](path_tangkapan_layar/gambar_6_9_validasi_form_error.png)
> 
> *Gambar 6.9 Tampilan Validasi Error Form Input Snack*

---

##### 10. Kasus Uji KU-10: Lihat Detail Snack
**Penjelasan Pengujian**:  
Pengujian ini memvalidasi tampilan rincian data snack, mulai dari nilai nutrisi, pewarnaan badge kategori (hijau/kuning/merah), hingga histori pengujian terkait.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-10 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Klasifikasi & Snack | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Lihat Detail Snack | | |
| **Deskripsi Uji** | Menguji tampilan rincian gizi, badge warna kategori, dan histori terkait | | |
| **Kondisi Awal** | Minimal 1 data snack tersimpan | | |
| **Dependensi** | `SnackController::show`, View `snacks.show` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Klik aksi **Detail** pada salah satu snack di daftar | ID Snack | Tampil rincian angka nutrisi, badge warna (hijau/kuning/merah), serta riwayat pengujian | Rincian tampil lengkap sesuai data DB | Sukses | Badge dinamis sesuai kategori |

**Kondisi Akhir**: Pengguna melihat halaman rincian snack secara utuh.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.10 Tampilan Halaman Detail Snack & Badge Kategori](path_tangkapan_layar/gambar_6_10_detail_snack.png)
> 
> *Gambar 6.10 Tampilan Halaman Detail Snack & Badge Kategori*

---

##### 11. Kasus Uji KU-11: Edit Data Snack & Re-Klasifikasi
**Penjelasan Pengujian**:  
Pengujian ini dilakukan untuk memastikan bahwa pengubahan nilai nutrisi pada produk snack secara otomatis memicu proses klasifikasi ulang (*re-classification*) dan menambahkan entri histori baru.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-11 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Klasifikasi & Snack | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Edit Data & Re-Klasifikasi | | |
| **Deskripsi Uji** | Menguji perubahan data nutrisi yang memicu re-klasifikasi hasil baru | | |
| **Kondisi Awal** | Snack dengan kategori `Snack Sehat` ada di sistem | | |
| **Dependensi** | `SnackController::update`, `ClassifierService` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Ubah kadar `gula` dari 3g menjadi 15g | `gula: 15` | Data ter-update, klasifikasi berubah menjadi `Perlu Perhatian` atau `Klaim Sehat Diragukan`, histori baru tercatat | Kategori snack berubah & histori baru bertambah | Sukses | Re-klasifikasi otomatis |

**Kondisi Akhir**: Kategori snack diperbarui di DB dan catatan histori pengujian baru dibuat.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.11 Tampilan Form Edit Data Snack & Re-Klasifikasi](path_tangkapan_layar/gambar_6_11_edit_snack.png)
> 
> *Gambar 6.11 Tampilan Form Edit Data Snack & Re-Klasifikasi*

---

##### 12. Kasus Uji KU-12: Hapus Data Snack
**Penjelasan Pengujian**:  
Pengujian ini bertujuan untuk menguji penghapusan record data snack dari daftar tabel dan basis data.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-12 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Klasifikasi & Snack | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Hapus Data Snack | | |
| **Deskripsi Uji** | Menguji penghapusan data snack dari daftar | | |
| **Kondisi Awal** | Terdaftar data snack pada tabel `snacks` | | |
| **Dependensi** | `SnackController::destroy` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Klik **Hapus** dan konfirmasi dialog | ID Snack | Data terhapus dari DB, notifikasi sukses muncul | Data hilang dari tabel & DB | Sukses | Cascade delete / soft delete |

**Kondisi Akhir**: Data snack tidak lagi muncul pada tabel daftar snack.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.12 Tampilan Penghapusan Data Snack](path_tangkapan_layar/gambar_6_12_hapus_snack.png)
> 
> *Gambar 6.12 Tampilan Penghapusan Data Snack*

---

##### 13. Kasus Uji KU-13: Isolasi Data Snack (Data Privacy)
**Penjelasan Pengujian**:  
Pengujian ini memvalidasi fitur keamanan privasi data. User A tidak boleh dapat melihat, mengedit, atau menghapus data snack milik User B melalui pengetikan URL manual.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-13 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Klasifikasi & Snack | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Privasi Data Pengguna (`scopeOwnedBy`) | | |
| **Deskripsi Uji** | Memastikan User A tidak dapat mengakses/mengedit snack milik User B | | |
| **Kondisi Awal** | User A dan User B masing-masing memiliki data snack | | |
| **Dependensi** | `Snack::scopeOwnedBy`, Auth Checks | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | User A mencoba membuka URL edit snack milik User B | URL `/snacks/{id_user_b}/edit` | Akses ditolak dengan HTTP `403 Forbidden` | Muncul respon `403 Forbidden` | Sukses | Proteksi data privacy |

**Kondisi Akhir**: User A tidak berhasil mengakses data milik User B.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.13 Tampilan Penolakan Akses Privasi Data Snack HTTP 403](path_tangkapan_layar/gambar_6_13_privasi_snack.png)
> 
> *Gambar 6.13 Tampilan Penolakan Akses Privasi Data Snack (HTTP 403)*

---

#### C. MODUL 3: HISTORI KLASIFIKASI

##### 14. Kasus Uji KU-14: Menampilkan Daftar Histori
**Penjelasan Pengujian**:  
Pengujian ini menguji penyajian daftar riwayat pengujian. Bagi pengguna biasa, hanya histori pribadinya yang ditampilkan, sedangkan bagi Admin, seluruh histori pengguna ditampilkan.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-14 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Histori Klasifikasi | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Menampilkan Daftar Histori | | |
| **Deskripsi Uji** | Menguji penyajian daftar riwayat pengujian sesuai role pengguna | | |
| **Kondisi Awal** | Terdapat data pada tabel `histories` | | |
| **Dependensi** | `HistoryController::index` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Login sebagai User dan buka `/histories` | URL `/histories` | Menampilkan hanya histori milik User tersebut | Tampil riwayat milik sendiri | Sukses | User scoping |
| 2 | Login sebagai Admin dan buka `/histories` | URL `/histories` | Menampilkan histori seluruh pengguna | Tampil riwayat seluruh pengguna | Sukses | Admin global view |

**Kondisi Akhir**: Pengguna melihat tabel riwayat sesuai hak aksesnya.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.14 Tampilan Halaman Daftar Histori Klasifikasi](path_tangkapan_layar/gambar_6_14_daftar_histori.png)
> 
> *Gambar 6.14 Tampilan Halaman Daftar Histori Klasifikasi*

---

##### 15. Kasus Uji KU-15: Detail Histori Klasifikasi
**Penjelasan Pengujian**:  
Pengujian ini memvalidasi rincian informasi histori yang mencakup parameter input gizi asli saat pengujian dilakukan serta persentase *confidence score* dari kelas Machine Learning.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-15 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Rendah | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Histori Klasifikasi | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Detail Histori Klasifikasi | | |
| **Deskripsi Uji** | Menguji visualisasi detail input JSON dan confidence score pada histori | | |
| **Kondisi Awal** | Halaman daftar histori terbuka | | |
| **Dependensi** | `HistoryController::show` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Klik **Detail** pada salah satu baris histori | ID History | Menampilkan rincian `detail_input` (gula, natrium, lemak, serat) dan persentase `confidence` | Tampil modal/halaman rincian input & confidence ML | Sukses | Format JSON casted array |

**Kondisi Akhir**: Informasi detail histori tersaji lengkap.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.15 Tampilan Rincian Detail Histori & Confidence Score](path_tangkapan_layar/gambar_6_15_detail_histori.png)
> 
> *Gambar 6.15 Tampilan Rincian Detail Histori & Confidence Score*

---

##### 16. Kasus Uji KU-16: Hapus Catatan Histori
**Penjelasan Pengujian**:  
Pengujian ini bertujuan untuk menguji fitur penghapusan entri histori klasifikasi tertentu dari basis data.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-16 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Histori Klasifikasi | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Hapus Histori Klasifikasi | | |
| **Deskripsi Uji** | Menguji penghapusan rekam medis/histori dari sistem | | |
| **Kondisi Awal** | Terdapat data pada halaman histori | | |
| **Dependensi** | `HistoryController::destroy` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Klik tombol Hapus pada baris histori | ID History | Record histori terhapus dari DB | Record terhapus | Sukses | - |

**Kondisi Akhir**: Data histori terpilih hilang dari daftar.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.16 Tampilan Penghapusan Catatan Histori](path_tangkapan_layar/gambar_6_16_hapus_histori.png)
> 
> *Gambar 6.16 Tampilan Penghapusan Catatan Histori*

---

#### D. MODUL 4: DASHBOARD & ANALITIK

##### 17. Kasus Uji KU-17: Visualisasi Donut Chart & Trend 6 Bulan
**Penjelasan Pengujian**:  
Pengujian ini memvalidasi rendering komponen grafik pada Dashboard, yaitu Donut Chart untuk persentase proporsi kategori dan Line Chart untuk tren klasifikasi 6 bulan terakhir.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-17 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Dashboard & Analitik | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Visualisasi Grafik Statistik | | |
| **Deskripsi Uji** | Menguji kalkulasi dan rendering grafik distribusi kategori serta grafik tren bulanan | | |
| **Kondisi Awal** | Pengguna login dan mengakses `/dashboard` | | |
| **Dependensi** | `DashboardController::index`, ChartJS | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Amati widget Donut Chart | Data Agregat Snack | Chart menampilkan persentase Snack Sehat (hijau), Perlu Perhatian (kuning), dan Klaim Diragukan (merah) | Donut chart muncul dengan warna sesuai | Sukses | Dynamic colors |
| 2 | Amati widget Line Chart Tren | Data 6 Bulan Terakhir | Chart menampilkan grafik tren jumlah klasifikasi snack dari 6 bulan sebelumnya | Line chart tren muncul | Sukses | Time-series query |

**Kondisi Akhir**: Visualisasi data analitik dirender dengan tepat tanpa error script.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.17 Tampilan Donut Chart & Line Chart Tren pada Dashboard](path_tangkapan_layar/gambar_6_17_dashboard_chart.png)
> 
> *Gambar 6.17 Tampilan Donut Chart & Line Chart Tren pada Dashboard*

---

##### 18. Kasus Uji KU-18: Indikator Status Koneksi Flask API
**Penjelasan Pengujian**:  
Pengujian ini memverifikasi deteksi keaktifan server Python ML pada Dashboard secara *real-time*. Jika server Flask aktif, indikator berwarna hijau, dan sebaliknya berwarna kuning/merah saat offline.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-18 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Dashboard & Analitik | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Indikator Status Flask API | | |
| **Deskripsi Uji** | Menguji deteksi kesehatan API Python di halaman Dashboard | | |
| **Kondisi Awal** | Server Laravel aktif | | |
| **Dependensi** | `ClassifierService::isHealthy` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Buka Dashboard saat Python API Aktif | Service Status | Tampil badge hijau "Python API Online (CART Model Active)" | Badge hijau tampil | Sukses | `isHealthy() = true` |
| 2 | Matikan Python API lalu refresh Dashboard | Service Status | Tampil badge peringatan merah/kuning "Python API Offline (Fallback Mode)" | Badge warning tampil | Sukses | `isHealthy() = false` |

**Kondisi Akhir**: User mendapatkan informasi status keaktifan server Machine Learning secara *real-time*.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.18 Tampilan Indikator Status Koneksi Flask API](path_tangkapan_layar/gambar_6_18_status_flask.png)
> 
> *Gambar 6.18 Tampilan Indikator Status Koneksi Flask API*

---

##### 19. Kasus Uji KU-19: Widget Statistik Admin
**Penjelasan Pengujian**:  
Pengujian ini menguji kebenaran penghitungan widget agregat khusus Admin (jumlah total user, user aktif, total klasifikasi hari ini, dan daftar top user).

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-19 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Dashboard & Analitik | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Widget Ringkasan Admin | | |
| **Deskripsi Uji** | Menguji kebenaran agregasi data pengguna dan total klasifikasi pada view admin | | |
| **Kondisi Awal** | Login sebagai Admin | | |
| **Dependensi** | `DashboardController` Admin Metrics | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Lihat widget bagian atas Dashboard | Query DB Aggregate | Tampil total pengguna, pengguna aktif/nonaktif, total klasifikasi hari ini, dan daftar top user | Seluruh angka match dengan jumlah baris database | Sukses | Accurate count |

**Kondisi Akhir**: Admin mendapatkan gambaran umum statistik sistem secara akurat.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.19 Tampilan Widget Agregat Statistik Admin](path_tangkapan_layar/gambar_6_19_widget_admin.png)
> 
> *Gambar 6.19 Tampilan Widget Agregat Statistik Admin*

---

#### E. MODUL 5: MANAJEMEN PENGGUNA (KHUSUS ADMIN)

##### 20. Kasus Uji KU-20: Menampilkan Daftar Pengguna
**Penjelasan Pengujian**:  
Pengujian ini memvalidasi kelengkapan tabel manajemen pengguna oleh Admin pada rute `/admin/users`.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-20 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Manajemen Pengguna | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Menampilkan Daftar Pengguna | | |
| **Deskripsi Uji** | Menguji kelengkapan tabel daftar seluruh akun pengguna di sistem | | |
| **Kondisi Awal** | Login sebagai Admin | | |
| **Dependensi** | `UserController::index` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Akses menu `/admin/users` | URL `/admin/users` | Menampilkan nama, email, role, status keaktifan, dan jumlah snack | Tabel pengguna tampil lengkap | Sukses | Paginated view |

**Kondisi Akhir**: Admin dapat melihat seluruh daftar akun yang terdaftar.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.20 Tampilan Halaman Manajemen Daftar Pengguna](path_tangkapan_layar/gambar_6_20_daftar_pengguna.png)
> 
> *Gambar 6.20 Tampilan Halaman Manajemen Daftar Pengguna*

---

##### 21. Kasus Uji KU-21: Ubah Role Pengguna
**Penjelasan Pengujian**:  
Pengujian ini menguji fitur pengubahan hak akses role pengguna dari `user` menjadi `admin` atau sebaliknya.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-21 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Manajemen Pengguna | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Ubah Role Pengguna | | |
| **Deskripsi Uji** | Menguji perubahan peranan akses pengguna (`user` ↔ `admin`) | | |
| **Kondisi Awal** | Berada di halaman `/admin/users` | | |
| **Dependensi** | `UserController::updateRole` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Ubah role akun "User Demo" menjadi `admin` | Target User ID | Field `role` pada DB berubah menjadi `admin`, user mendapat hak akses admin saat login ulang | Role berubah di DB & UI | Sukses | Role privilege update |

**Kondisi Akhir**: Peranan akses pengguna berhasil diperbarui di database.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.21 Tampilan Pengubahan Role Pengguna](path_tangkapan_layar/gambar_6_21_ubah_role.png)
> 
> *Gambar 6.21 Tampilan Pengubahan Role Pengguna*

---

##### 22. Kasus Uji KU-22: Toggle Status Akun (Aktif / Nonaktif)
**Penjelasan Pengujian**:  
Pengujian ini bertujuan untuk menguji fitur pengaktifan kembali atau penonaktifan akun pengguna secara langsung oleh Admin.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-22 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Manajemen Pengguna | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Penonaktifan & Pengaktifan Akun | | |
| **Deskripsi Uji** | Menguji fitur blokir/buka blokir akses pengguna | | |
| **Kondisi Awal** | Berada di halaman `/admin/users` | | |
| **Dependensi** | `UserController::toggle` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Klik tombol **Nonaktifkan** pada salah satu user | Target User ID | Attribute `is_active` berubah menjadi `false`, user tidak bisa login | Status berubah & login terblokir | Sukses | Instant revocation |
| 2 | Klik tombol **Aktifkan** pada user tersebut | Target User ID | Attribute `is_active` kembali `true`, user bisa login lagi | Status berubah & login diizinkan | Sukses | Access restored |

**Kondisi Akhir**: Status keaktifan pengguna diubah sesuai tindakan Admin.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.22 Tampilan Toggle Status Keaktifan Akun Pengguna](path_tangkapan_layar/gambar_6_22_toggle_status.png)
> 
> *Gambar 6.22 Tampilan Toggle Status Keaktifan Akun Pengguna*

---

#### F. MODUL 6: EXPORT DATA & LAPORAN

##### 23. Kasus Uji KU-23: Export Data Snack ke PDF
**Penjelasan Pengujian**:  
Pengujian ini memvalidasi pembuatan berkas laporan PDF data snack berformat A4 Landscape menggunakan pustaka DomPDF.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-23 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Export Data & Laporan | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Export Data Snack ke Dokumen PDF | | |
| **Deskripsi Uji** | Menguji pencetakan laporan data snack ke format file PDF landscape | | |
| **Kondisi Awal** | Berada di halaman daftar snack `/snacks` | | |
| **Dependensi** | `SnackController::exportPdf`, `Barryvdh\DomPDF` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Klik tombol **Export PDF** | Request GET `/snacks/export/pdf` | Browser mendownload file `.pdf` berformat A4 Landscape dengan tabel data lengkap | File PDF terunduh & format rapi | Sukses | Download trigger |

**Kondisi Akhir**: File PDF terunduh di perangkat pengguna.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.23 Tampilan Hasil Download Dokumen PDF Data Snack](path_tangkapan_layar/gambar_6_23_export_pdf.png)
> 
> *Gambar 6.23 Tampilan Hasil Download Dokumen PDF Data Snack*

---

##### 24. Kasus Uji KU-24: Export Data Snack ke Excel
**Penjelasan Pengujian**:  
Pengujian ini memverifikasi pembuatan file `.xlsx` berisi seluruh kolom data gizi snack yang diunduh langsung dari browser.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-24 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Export Data & Laporan | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Export Data Snack ke File Spreadsheet Excel | | |
| **Deskripsi Uji** | Menguji pembuatan berkas `.xlsx` data nutrisi snack | | |
| **Kondisi Awal** | Berada di halaman daftar snack `/snacks` | | |
| **Dependensi** | `SnackController::exportExcel`, `Maatwebsite\Excel` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Klik tombol **Export Excel** | Request GET `/snacks/export/excel` | Browser mendownload file `.xlsx` berisi kolom data nutrisi dan klasifikasi | File Excel terunduh & dapat dibuka di MS Excel | Sukses | Format `.xlsx` |

**Kondisi Akhir**: File Excel terunduh di perangkat pengguna.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.24 Tampilan Hasil Download Berkas Spreadsheet Excel Data Snack](path_tangkapan_layar/gambar_6_24_export_excel.png)
> 
> *Gambar 6.24 Tampilan Hasil Download Berkas Spreadsheet Excel Data Snack*

---

#### G. MODUL 7: FLASK MACHINE LEARNING API DIRECT ENDPOINTS

##### 25. Kasus Uji KU-25: Endpoint GET /health
**Penjelasan Pengujian**:  
Pengujian ini dilakukan dengan memanggil endpoint `GET /health` secara langsung pada server Python Flask API untuk mengecek kesiapan service dan ketersediaan kelas model.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-25 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Flask ML API Direct | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Cek Health Status API Python | | |
| **Deskripsi Uji** | Menguji respon status kesehatan dan ketersediaan model ML pada API | | |
| **Kondisi Awal** | Server Flask berjalan di port 5000 | | |
| **Dependensi** | `python-api/app.py` Route `/health` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Kirim request HTTP GET ke `http://127.0.0.1:5000/health` | GET Request | Mengembalikan HTTP 200 JSON `{"status": "ok", "model_loaded": true, "classes": [...]}` | Respon HTTP 200 JSON valid | Sukses | REST API check |

**Kondisi Akhir**: Client menerima status kesehatan API dan daftar kelas model.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.25 Tampilan Respon JSON Endpoint GET /health API Python](path_tangkapan_layar/gambar_6_25_api_health.png)
> 
> *Gambar 6.25 Tampilan Respon JSON Endpoint GET /health API Python*

---

##### 26. Kasus Uji KU-26: Endpoint POST /predict
**Penjelasan Pengujian**:  
Pengujian ini menguji endpoint prediksi tunggal `POST /predict` menggunakan Postman/cURL dengan menyertakan payload JSON data nutrisi snack.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-26 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Tinggi | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Flask ML API Direct | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Endpoint Prediksi Tunggal ML | | |
| **Deskripsi Uji** | Menguji inferensi model CART dengan payload JSON nutrisi tunggal | | |
| **Kondisi Awal** | Server Flask berjalan | | |
| **Dependensi** | `python-api/app.py` Route `/predict`, `cart_model.pkl` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Kirim JSON payload nutrisi via Postman/cURL | `{"gula": 3, "natrium": 90, "lemak": 2, "serat": 4}` | HTTP 200 JSON memuat `hasil`, objek `confidence` (persentase tiap kelas), dan `method` | Respon JSON sesuai harapan dengan confidence score | Sukses | Direct ML Inference |

**Kondisi Akhir**: API memberikan hasil prediksi beserta persentase keyakinan model.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.26 Tampilan Respon JSON Endpoint POST /predict API Python](path_tangkapan_layar/gambar_6_26_api_predict.png)
> 
> *Gambar 6.26 Tampilan Respon JSON Endpoint POST /predict API Python*

---

##### 27. Kasus Uji KU-27: Endpoint POST /batch-predict
**Penjelasan Pengujian**:  
Pengujian ini memvalidasi pemrosesan masif (*batch processing*) dengan mengirimkan array JSON berisi beberapa data snack ke endpoint `POST /batch-predict`.

| Field | Keterangan | Field | Keterangan |
| :--- | :--- | :--- | :--- |
| **Nama Projek** | SnackCheck | **Perancangan Uji** | Tim QA / Tester |
| **ID Kasus Uji** | KU-27 | **Tanggal Rancangan** | 3 Agustus 2026 |
| **Prioritas Uji** | Sedang | **Pelaksanaan Uji** | Tim QA / Tester |
| **Nama Modul** | Flask ML API Direct | **Tanggal Uji** | 3 Agustus 2026 |
| **Nama Uji** | Endpoint Prediksi Massal (Batch Processing) | | |
| **Deskripsi Uji** | Menguji pemrosesan inferensi banyak data produk sekaligus | | |
| **Kondisi Awal** | Server Flask berjalan | | |
| **Dependensi** | `python-api/app.py` Route `/batch-predict` | | |

| No | Langkah Uji | Data Uji | Hasil Yang Diharapkan | Hasil Yang Terjadi | Status Sukses/Gagal | Keterangan |
| :-: | :--- | :--- | :--- | :--- | :-: | :--- |
| 1 | Kirim Array JSON berisi 3 sampel snack | `[{"gula":2, "natrium":50, "lemak":1, "serat":3}, ...]` | HTTP 200 JSON memuat `total: 3` dan array `results` berisi prediksi masing-masing item | Memunculkan hasil prediksi seluruh item array | Sukses | Batch Inference |

**Kondisi Akhir**: Seluruh array data terproses dan mengembalikan hasil klasifikasi massal.

> **Keterangan Tangkapan Layar (Screenshot)**:
> 
> ![Gambar 6.27 Tampilan Respon JSON Endpoint POST /batch-predict API Python](path_tangkapan_layar/gambar_6_27_api_batch_predict.png)
> 
> *Gambar 6.27 Tampilan Respon JSON Endpoint POST /batch-predict API Python*

---

## 6.3 Rangkuman Hasil Pengujian
Berdasarkan seluruh rangkuman pengujian fungsionalitas yang telah dilakukan terhadap sistem **SnackCheck** dari butir uji **KU-01** sampai **KU-27**, didapatkan rekapitulasi tingkat keberhasilan pengujian seperti disajikan pada Tabel 6.2.

**Tabel 6.2 Rangkuman Rekapitulasi Hasil Pengujian *Black Box***

| No | Modul / Kelas Uji | Jumlah Butir Uji | Jumlah Sukses | Jumlah Gagal | Persentase Keberhasilan (%) |
| :-: | :--- | :-: | :-: | :-: | :-: |
| 1 | Autentikasi & Otorisasi | 6 | 6 | 0 | 100% |
| 2 | Klasifikasi & Manajemen Snack | 7 | 7 | 0 | 100% |
| 3 | Histori Klasifikasi | 3 | 3 | 0 | 100% |
| 4 | Dashboard & Analitik | 3 | 3 | 0 | 100% |
| 5 | Manajemen Pengguna (Khusus Admin) | 3 | 3 | 0 | 100% |
| 6 | Export Data & Laporan | 2 | 2 | 0 | 100% |
| 7 | Flask Machine Learning API Direct | 3 | 3 | 0 | 100% |
| **Total** | **Keseluruhan** | **27** | **27** | **0** | **100%** |

Perhitungan tingkat keberhasilan pengujian dilakukan dengan menggunakan formula sebagai berikut:

$$\text{Persentase Keberhasilan} = \left( \frac{\text{Total Butir Uji Sukses}}{\text{Total Butir Uji}} \right) \times 100\%$$

$$\text{Persentase Keberhasilan} = \left( \frac{27}{27} \right) \times 100\% = 100\%$$

### Kesimpulan Pengujian:
Dari rekapitulasi pengujian pada Tabel 6.2, didapatkan bahwa persentase keberhasilan pengujian fungsionalitas (*Black Box Testing*) pada sistem **SnackCheck** mencapai **100%**. Seluruh butir uji berjalan dengan sukses dan sesuai dengan kriteria hasil yang diharapkan. Dengan demikian, dapat disimpulkan bahwa sistem ini telah laik (*ready for production*), stabil, serta memenuhi seluruh kebutuhan fungsionalitas yang dirancang.
