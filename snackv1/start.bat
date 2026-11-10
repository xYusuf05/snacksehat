@echo off
:: =============================================================================
:: start.bat
:: Jalankan Python Flask API + Laravel sekaligus di Windows (Laragon)
:: Double-click file ini atau jalankan dari CMD di folder snack-classifier/
:: =============================================================================

title SnackCheck – Server Launcher
color 0B

echo.
echo  =============================================
echo    SNACKCHECK - Memulai Semua Server
echo  =============================================
echo.

:: ── Python Flask API ──────────────────────────────────────────────────────────
echo  [1/2] Menjalankan Python Flask API (port 5000)...
echo.

if not exist "python-api\venv\Scripts\activate.bat" (
    echo  [ERROR] Virtual environment tidak ditemukan.
    echo  Jalankan install-laragon.sh terlebih dahulu.
    pause
    exit /b 1
)

if not exist "python-api\cart_model.pkl" (
    echo  [INFO] Model belum dilatih. Melatih model CART...
    cd python-api
    call venv\Scripts\activate.bat
    python train_model.py
    call venv\Scripts\deactivate.bat
    cd ..
)

:: Buka Python API di window baru
start "Flask API - SnackCheck" cmd /k "cd python-api && call venv\Scripts\activate.bat && echo Flask API berjalan di http://127.0.0.1:5000 && python app.py"

:: Tunggu sebentar supaya Flask sempat start
timeout /t 3 /nobreak > nul

:: ── Laravel ──────────────────────────────────────────────────────────────────
echo  [2/2] Menjalankan Laravel (port 8000)...
echo.

if not exist "laravel-app\artisan" (
    echo  [ERROR] Folder laravel-app tidak ditemukan atau belum di-setup.
    pause
    exit /b 1
)

:: Buka Laravel di window baru
start "Laravel - SnackCheck" cmd /k "cd laravel-app && echo Laravel berjalan di http://localhost:8000 && php artisan serve"

:: Tunggu sebentar lalu buka browser
timeout /t 3 /nobreak > nul

echo.
echo  =============================================
echo    Semua server berjalan!
echo  =============================================
echo.
echo    Flask API : http://127.0.0.1:5000
echo    Laravel   : http://localhost:8000
echo.
echo    Login Admin : admin@snackcheck.com / password
echo    Login User  : user@snackcheck.com  / password
echo.
echo  Membuka browser...
start http://localhost:8000

echo  Tekan tombol apapun untuk menutup launcher ini.
echo  (Server Python dan Laravel tetap berjalan di window masing-masing)
pause > nul
