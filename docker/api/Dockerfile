FROM php:8.3-cli

# Install system dependencies and PHP extensions needed by Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libonig-dev \
        libzip-dev \
        curl \
    && docker-php-ext-install mbstring pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Default command launches Laravel dev server
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8001"]