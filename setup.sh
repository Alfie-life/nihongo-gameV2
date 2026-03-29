#!/bin/bash
set -e

echo "========================================="
echo "  日本語ゲーム - Project Setup"
echo "========================================="

# --- 1. Create Laravel project ---
echo ""
echo "[1/6] Creating Laravel project..."
if [ ! -f backend/artisan ]; then
    composer create-project laravel/laravel backend-temp --prefer-dist --no-interaction
    # Move files from temp to backend, preserving our custom files
    cp -rn backend-temp/* backend/ 2>/dev/null || true
    cp -rn backend-temp/.* backend/ 2>/dev/null || true
    rm -rf backend-temp
    echo "  -> Laravel installed"
else
    echo "  -> Laravel already exists, skipping"
fi

cd backend

# --- 2. Install Sanctum ---
echo ""
echo "[2/6] Installing Laravel Sanctum..."
composer require laravel/sanctum --no-interaction
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider" --force
echo "  -> Sanctum installed"

# --- 3. Copy .env ---
echo ""
echo "[3/6] Setting up environment..."
cp .env.example .env 2>/dev/null || true
php artisan key:generate --force
echo "  -> Environment configured"

cd ..

# --- 4. Setup Frontend ---
echo ""
echo "[4/6] Setting up Vue.js frontend..."
cd frontend
npm install
echo "  -> Frontend dependencies installed"
cd ..

# --- 5. Docker ---
echo ""
echo "[5/6] Building Docker containers..."
docker-compose build
docker-compose up -d

# --- 6. Migrations & Seed ---
echo ""
echo "[6/6] Running migrations & seeding..."
sleep 10  # Wait for MySQL
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force

echo ""
echo "========================================="
echo "  Setup Complete!"
echo "  Open http://localhost:8080"
echo "========================================="
