# ============================================
# Stage 1: Build frontend assets with Node
# ============================================
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci

COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

RUN npm run build

# ============================================
# Stage 2: Main Application Runtime (PHP + Nginx)
# ============================================
FROM php:8.3-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    bash \
    sqlite-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_sqlite bcmath mbstring xml zip opcache

# Get Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Copy built assets from frontend stage
COPY --from=frontend /app/public/build ./public/build

# Configure directory permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Install composer production dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/fpm_custom.conf /usr/local/etc/php-fpm.d/z-custom.conf

# Setup database directory for SQLite persistent storage
RUN mkdir -p /var/www/html/database/data && chown -R www-data:www-data /var/www/html/database

# Expose port 10000 (Render default web service port)
EXPOSE 10000

# Set entrypoint
RUN chmod +x docker/entrypoint.sh
ENTRYPOINT ["docker/entrypoint.sh"]
