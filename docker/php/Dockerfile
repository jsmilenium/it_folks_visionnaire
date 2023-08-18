# Use the official PHP image as the base image
FROM php:8.1-fpm-alpine

USER root

WORKDIR /var/www/html

#COPY ../../../composer.json .

RUN apt-get update && apt-get install -y \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        libpq-dev \
        zip \
        curl \
        unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install exif \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-source delete

COPY . /var/www/html

COPY ../../../.env /var/www/html/.env

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Run the composer install command to install the dependencies for the Laravel app
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the Laravel application code to the container
COPY . .

# Set the ownership of the files in the /app directory to the www-data user
RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 777 /var/www/html/storage

# Run the command to start PHP-FPM
CMD ["php-fpm"]