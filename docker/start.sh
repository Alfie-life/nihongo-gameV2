#!/bin/sh
set -e

cd /var/www/backend

echo "=== Nihongo Game - Starting up ==="

# Fix permissions
chown -R www-data:www-data /var/www/backend/storage /var/www/backend/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/backend/storage /var/www/backend/bootstrap/cache 2>/dev/null || true

# Write .env file from environment variables
echo "Writing .env from environment..."
cat > .env << ENV_INNER
APP_NAME="Nihongo Game"
APP_ENV=${APP_ENV:-production}
APP_DEBUG=${APP_DEBUG:-false}
APP_KEY=${APP_KEY:-}
APP_URL=${RENDER_EXTERNAL_URL:-http://localhost:10000}
LOG_CHANNEL=${LOG_CHANNEL:-stderr}
DB_CONNECTION=${DB_CONNECTION:-pgsql}
DATABASE_URL=${DATABASE_URL:-}
DB_HOST=${DB_HOST:-}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-}
DB_USERNAME=${DB_USERNAME:-}
DB_PASSWORD=${DB_PASSWORD:-}
SESSION_DRIVER=${SESSION_DRIVER:-file}
SESSION_LIFETIME=120
CACHE_STORE=${CACHE_STORE:-file}
SANCTUM_STATEFUL_DOMAINS=${SANCTUM_STATEFUL_DOMAINS:-}
ENV_INNER

# Generate APP_KEY if needed
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:dGhpc2lzYXRlbXBvcmFyeWtleXBsZWFzZWNoYW5nZQ==" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force --no-interaction
fi

# Clear caches
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Wait for database
echo "Waiting for database..."
RETRIES=0
until php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'OK'; } catch(\Exception \$e) { exit(1); }" 2>/dev/null || [ $RETRIES -ge 30 ]; do
    RETRIES=$((RETRIES + 1))
    echo "  DB not ready, retry $RETRIES/30..."
    sleep 2
done

# Run migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction 2>&1 || echo "Migration note: may already be up to date"

# Seed database
echo "Seeding data..."
php artisan db:seed --force --no-interaction 2>&1 || echo "Seed note: may already be seeded"

# Cache for production
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true

echo "=== Starting Nginx + PHP-FPM ==="
exec /usr/bin/supervisord -c /etc/supervisord.conf
