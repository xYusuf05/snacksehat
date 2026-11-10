# 📄 TABEL PENGUJIAN SISTEM (TEST CASE & EXECUTION DETAIL)
**Nama Projek**: SnackCheck - Sistem Klasifikasi Snack Sehat Berbasis Decision Tree CART  
**Dokumen Referensi**: `TABEL PENGUJIAN SISTEM.pdf` & `docs/rencana_pengujian.md`  
**Tanggal**: 3 Agustus 2026  

---

## MODUL 1: AUTENTIKASI & OTORISASI

### [KU-01] Registrasi Akun Baru

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

---

### [KU-02] Login Akun Valid

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

---

### [KU-03] Login Kredensial Salah

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

---

### [KU-04] Login Akun Nonaktif

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

---

### [KU-05] Restriksi Akses Admin oleh User

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

---

### [KU-06] Logout Sistem

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

---

## MODUL 2: KLASIFIKASI & MANAJEMEN SNACK

### [KU-07] Tambah Snack & Klasifikasi ML (Flask API Online)

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

---

### [KU-08] Tambah Snack saat Flask API Offline (Fallback Rule-Based)

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

---

### [KU-09] Validasi Input Gizi Negatif / Kosong

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

---

### [KU-10] Lihat Detail Snack

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

---

### [KU-11] Edit Data Snack & Re-Klasifikasi

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

---

### [KU-12] Hapus Data Snack

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

---

### [KU-13] Isolasi Data Snack (Data Privacy)

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

---

## MODUL 3: HISTORI KLASIFIKASI

### [KU-14] Menampilkan Daftar Histori

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

---

### [KU-15] Detail Histori Klasifikasi

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

---

### [KU-16] Hapus Catatan Histori

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

---

## MODUL 4: DASHBOARD & ANALITIK

### [KU-17] Visualisasi Donut Chart & Trend 6 Bulan

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

---

### [KU-18] Indikator Status Koneksi Flask API

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

---

### [KU-19] Widget Statistik Admin

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

---

## MODUL 5: MANAJEMEN PENGGUNA (KHUSUS ADMIN)

### [KU-20] Menampilkan Daftar Pengguna

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

---

### [KU-21] Ubah Role Pengguna

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

---

### [KU-22] Toggle Status Akun (Aktif / Nonaktif)

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

---

## MODUL 6: EXPORT DATA & LAPORAN

### [KU-23] Export Data Snack ke PDF

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

---

### [KU-24] Export Data Snack ke Excel

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

---

## MODUL 7: FLASK MACHINE LEARNING API DIRECT ENDPOINTS

### [KU-25] Endpoint GET /health

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

---

### [KU-26] Endpoint POST /predict

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

---

### [KU-27] Endpoint POST /batch-predict

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
