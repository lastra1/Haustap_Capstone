FROM php:8.2-cli-alpine

# Install system dependencies
RUN apk add --no-cache \
    mysql-client \
    bash \
    curl \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy Laravel application from the correct path
COPY Haustap_Capstone-Haustap_Connecting/Haustap_Capstone-Haustap_Connecting/backend/ ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set proper permissions
RUN chmod -R 755 /app/storage /app/bootstrap/cache

# Create .env file from example if it doesn't exist
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Generate application key
RUN php artisan key:generate

# Expose port
EXPOSE 8000

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
  CMD curl -f http://localhost:8000/api/health || exit 1

# Start Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]