#!/usr/bin/env bash
# =============================================================================
# install-laragon.sh
# Script setup otomatis SnackCheck di Laragon (Windows via Git Bash / WSL)
# Jalankan dari dalam folder snack-classifier/
# =============================================================================

set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
CYAN='\033[0;36m'
NC='\033[0m'

info()    { echo -e "${CYAN}[INFO]${NC}  $1"; }
success() { echo -e "${GREEN}[OK]${NC}    $1"; }
warn()    { echo -e "${YELLOW}[WARN]${NC}  $1"; }
error()   { echo -e "${RED}[ERROR]${NC} $1"; exit 1; }

echo ""
echo -e "${CYAN}=============================================${NC}"
echo -e "${CYAN}   SNACKCHECK – Setup Otomatis Laragon      ${NC}"
echo -e "${CYAN}=============================================${NC}"
echo ""

# ── Cek tools ──────────────────────────────────────────────────────────────────
info "Memeriksa kebutuhan sistem..."
command -v php     >/dev/null 2>&1 || error "PHP tidak ditemukan. Pastikan Laragon berjalan."
command -v composer>/dev/null 2>&1 || error "Composer tidak ditemukan."
command -v python  >/dev/null 2>&1 || python3 --version >/dev/null 2>&1 || error "Python tidak ditemukan."
command -v mysql   >/dev/null 2>&1 || warn "MySQL client tidak ditemukan. Buat database manual di phpMyAdmin."
success "Semua tools tersedia."

# ── Python API Setup ───────────────────────────────────────────────────────────
echo ""
info "=== SETUP PYTHON FLASK API ==="

cd python-api

# Buat virtualenv
if [ ! -d "venv" ]; then
    info "Membuat virtual environment Python..."
    python -m venv venv 2>/dev/null || python3 -m venv venv
    success "Virtual environment dibuat."
else
    warn "Virtual environment sudah ada, lewati."
fi

# Aktifkan venv dan install
info "Menginstall dependensi Python..."
if [[ "$OSTYPE" == "msys" || "$OSTYPE" == "win32" ]]; then
    # Windows Git Bash
    source venv/Scripts/activate
else
    source venv/bin/activate
fi

pip install -r requirements.txt -q
success "Dependensi Python berhasil diinstall."

# Training model
if [ ! -f "cart_model.pkl" ]; then
    info "Melatih model CART Decision Tree..."
    python train_model.py
    success "Model CART berhasil dilatih dan disimpan."
else
    warn "Model sudah ada (cart_model.pkl), lewati training."
fi

deactivate
cd ..

# ── Laravel Setup ──────────────────────────────────────────────────────────────
echo ""
info "=== SETUP LARAVEL ==="

cd laravel-app

# Copy .env
if [ ! -f ".env" ]; then
    info "Membuat file .env..."
    cp .env.example .env
    success ".env dibuat."
else
    warn ".env sudah ada, lewati."
fi

# Composer install
info "Menginstall dependensi Laravel (Composer)..."
composer install --no-interaction -q
success "Composer install selesai."

# Generate key
info "Generate APP_KEY..."
php artisan key:generate --force
success "APP_KEY berhasil digenerate."

# Buat database
echo ""
warn "Pastikan Laragon MySQL sudah berjalan!"
read -p "Masukkan nama database [snackcheck]: " DB_NAME
DB_NAME=${DB_NAME:-snackcheck}

read -p "Masukkan MySQL username [root]: " DB_USER
DB_USER=${DB_USER:-root}

read -s -p "Masukkan MySQL password [kosong = Enter]: " DB_PASS
echo ""

# Update .env database
sed -i "s/DB_DATABASE=.*/DB_DATABASE=${DB_NAME}/"   .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=${DB_USER}/"   .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASS}/"   .env

# Buat database jika belum ada
info "Membuat database '${DB_NAME}'..."
if [ -z "$DB_PASS" ]; then
    mysql -u "$DB_USER" -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null && success "Database berhasil dibuat." || warn "Gagal membuat database otomatis. Buat manual di phpMyAdmin: http://localhost/phpmyadmin"
else
    mysql -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null && success "Database berhasil dibuat." || warn "Gagal membuat database otomatis. Buat manual di phpMyAdmin."
fi

# Migrasi
info "Menjalankan migrasi database..."
php artisan migrate --force
success "Migrasi selesai."

# Seeder
info "Menjalankan seeder (50 data snack + akun demo)..."
php artisan db:seed --force
success "Seeder selesai."

# Install package tambahan
info "Menginstall Laravel Breeze..."
composer require laravel/breeze --dev -q
php artisan breeze:install blade --quiet
success "Breeze berhasil diinstall."

info "Menginstall DomPDF (export PDF)..."
composer require barryvdh/laravel-dompdf -q
success "DomPDF berhasil diinstall."

info "Menginstall Laravel Excel (export Excel)..."
composer require maatwebsite/excel -q
success "Laravel Excel berhasil diinstall."

# Publish pagination views
php artisan vendor:publish --tag=laravel-pagination --force -q

cd ..

# ── Selesai ────────────────────────────────────────────────────────────────────
echo ""
echo -e "${GREEN}=============================================${NC}"
echo -e "${GREEN}   INSTALASI SELESAI!                        ${NC}"
echo -e "${GREEN}=============================================${NC}"
echo ""
echo -e "Langkah selanjutnya:"
echo ""
echo -e "  ${CYAN}1. Jalankan Python API:${NC}"
echo -e "     cd python-api"
echo -e "     venv\\Scripts\\activate   (Windows)"
echo -e "     python app.py"
echo -e "     → API berjalan di http://127.0.0.1:5000"
echo ""
echo -e "  ${CYAN}2. Jalankan Laravel:${NC}"
echo -e "     cd laravel-app"
echo -e "     php artisan serve"
echo -e "     → Aplikasi di http://localhost:8000"
echo ""
echo -e "  ${CYAN}3. Login dengan akun demo:${NC}"
echo -e "     Admin : admin@snackcheck.com / password"
echo -e "     User  : user@snackcheck.com  / password"
echo ""
