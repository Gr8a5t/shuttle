#!/bin/bash
set -e

echo "🚀 Starting Shuttle deployment..."

# ------------------------------------
# SQLite: Use persistent disk at /data
# ------------------------------------
DB_PATH="/data/database.sqlite"

# If DB_DATABASE env var is set, use it. Otherwise, default to /data/database.sqlite
if [ -n "$DB_DATABASE" ]; then
    DB_PATH="$DB_DATABASE"
fi

echo "📂 Using database at: $DB_PATH"

DB_DIR=$(dirname "$DB_PATH")
if [ ! -d "$DB_DIR" ]; then
    echo "📁 Creating database directory: $DB_DIR"
    mkdir -p "$DB_DIR"
fi

# Check if SQLite file exists. If not, touch it and run migrations + seeding
NEW_DB=false
if [ ! -f "$DB_PATH" ]; then
    echo "📝 Database file not found. Creating it..."
    touch "$DB_PATH"
    NEW_DB=true
fi

# Ensure correct permissions for database folder and SQLite file
chown -R www-data:www-data "$DB_DIR"
chmod 775 "$DB_DIR"
chmod 664 "$DB_PATH"

# Run Laravel optimizations
echo "⚡ Optimizing Laravel config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Seed database if it was newly created
if [ "$NEW_DB" = true ]; then
    echo "🌱 Seeding database with AdminSeeder..."
    php artisan db:seed --class=AdminSeeder --force
fi

# Ensure correct ownership and permissions on files created/modified during bootstrap
echo "🔒 Adjusting storage and cache permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "🎬 Starting Supervisor..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
