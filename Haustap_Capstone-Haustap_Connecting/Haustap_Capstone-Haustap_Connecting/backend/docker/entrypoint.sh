#!/bin/bash

# Laravel Docker Entrypoint Script

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
while ! mysqladmin ping -h mysql -P 3306 -u haustap_user -p"haustap_password" --silent; do
    echo "⏳ MySQL is not ready yet. Waiting..."
    sleep 2
done
echo "✅ MySQL is ready!"

# Wait for Redis to be ready
echo "⏳ Waiting for Redis to be ready..."
while ! redis-cli -h redis -p 6379 ping; do
    echo "⏳ Redis is not ready yet. Waiting..."
    sleep 2
done
echo "✅ Redis is ready!"

# Create storage directories if they don't exist
echo "📁 Setting up storage directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set proper permissions
echo "🔒 Setting permissions..."
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

# Install dependencies if vendor directory doesn't exist
if [ ! -d "vendor" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install --no-interaction --no-scripts --no-progress --prefer-dist --optimize-autoloader
fi

# Install Firebase Admin SDK if not installed
if ! composer show kreait/firebase-php > /dev/null 2>&1; then
    echo "🔥 Installing Firebase Admin SDK..."
    composer require kreait/firebase-php
fi

# Generate Laravel key if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating Laravel application key..."
    php artisan key:generate
fi

# Run migrations
echo "🔄 Running database migrations..."
php artisan migrate --force

# Clear and cache Laravel config
echo "🗑️ Clearing Laravel caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "⚙️ Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create Firebase service account directory
echo "📂 Setting up Firebase service account directory..."
mkdir -p storage/app/firebase

# Seed the database (optional - uncomment if needed)
# echo "🌱 Seeding database..."
# php artisan db:seed --force

# Install Node dependencies and build assets if package.json exists
if [ -f "package.json" ]; then
    echo "📦 Installing Node dependencies..."
    npm install
    echo "🏗️ Building assets..."
    npm run build
fi

# Create supervisor log directory
mkdir -p /var/log/supervisor

# Start supervisor to manage PHP-FPM and queue workers
echo "🚀 Starting supervisor..."
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf