# ==========================================
# Stage 1: Build Vue.js frontend
# ==========================================
FROM node:20-alpine AS frontend-build

WORKDIR /build
COPY frontend/package.json ./
RUN npm install
COPY frontend/ ./
RUN npm run build

# ==========================================
# Stage 2: Build Laravel backend with Composer
# ==========================================
FROM composer:2 AS backend-build

WORKDIR /app

# Create fresh Laravel 11 project (scaffolds ALL required files)
RUN composer create-project laravel/laravel:^11.0 /app --prefer-dist --no-interaction

# Install Sanctum
RUN composer require laravel/sanctum --no-interaction

# Overlay custom application code on top of scaffold
COPY backend/bootstrap/app.php /app/bootstrap/app.php
COPY backend/public/index.php /app/public/index.php
COPY backend/app/Models/User.php /app/app/Models/User.php
COPY backend/app/Models/Question.php /app/app/Models/Question.php
COPY backend/app/Models/FoodItem.php /app/app/Models/FoodItem.php
COPY backend/app/Models/UserProgress.php /app/app/Models/UserProgress.php
COPY backend/app/Models/FoodCollection.php /app/app/Models/FoodCollection.php
COPY backend/app/Http/Controllers/AuthController.php /app/app/Http/Controllers/AuthController.php
COPY backend/app/Http/Controllers/GameController.php /app/app/Http/Controllers/GameController.php
COPY backend/routes/api.php /app/routes/api.php
COPY backend/routes/web.php /app/routes/web.php
COPY backend/database/migrations/ /app/database/migrations/
COPY backend/database/seeders/DatabaseSeeder.php /app/database/seeders/DatabaseSeeder.php
COPY backend/config/database.php /app/config/database.php
COPY backend/config/cors.php /app/config/cors.php
COPY backend/config/sanctum.php /app/config/sanctum.php

# Regenerate autoload
RUN composer dump-autoload --optimize

# ==========================================
# Stage 3: Production runtime
# ==========================================
FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    postgresql-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Copy backend from build
COPY --from=backend-build /app /var/www/backend

# Copy frontend from build
COPY --from=frontend-build /build/dist /var/www/frontend

# Copy docker configs
COPY docker/nginx/render.conf /etc/nginx/http.d/default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Setup storage permissions
RUN mkdir -p /var/www/backend/storage/framework/cache/data \
    && mkdir -p /var/www/backend/storage/framework/sessions \
    && mkdir -p /var/www/backend/storage/framework/views \
    && mkdir -p /var/www/backend/storage/logs \
    && mkdir -p /var/www/backend/bootstrap/cache \
    && chown -R www-data:www-data /var/www/backend/storage \
    && chown -R www-data:www-data /var/www/backend/bootstrap/cache \
    && chmod -R 775 /var/www/backend/storage \
    && chmod -R 775 /var/www/backend/bootstrap/cache

WORKDIR /var/www/backend

EXPOSE 10000

CMD ["/start.sh"]
