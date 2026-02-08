FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy source
COPY . .

# Install dependencies without running scripts
RUN composer install --no-interaction --prefer-dist --no-scripts

# Permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 8000
