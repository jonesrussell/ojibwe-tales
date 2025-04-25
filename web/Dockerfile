FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /var/www/storage
RUN chown -R www-data:www-data /var/www/bootstrap/cache

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"] 