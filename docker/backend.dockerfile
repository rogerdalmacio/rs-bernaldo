FROM php:8.2-fpm

# Install system dependencies for Laravel extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    unzip \
    && docker-php-ext-install zip pdo pdo_pgsql mbstring

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set user and working directory
USER 1000
WORKDIR /var/www/html
