FROM php:8.2-fpm-alpine

ENV APP_HOME=/var/www/html

RUN  apk update && apk upgrade &&  apk add $PHPIZE_DEPS

RUN apk add --no-cache \
    curl \
    libmemcached-dev \
    libzip-dev \
    zlib-dev \
    postgresql-dev

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip

RUN apk del --no-cache libmemcached-dev

WORKDIR $APP_HOME

COPY . .

RUN cp .env.example .env

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN composer self-update
RUN composer install
RUN chown -R www-data:www-data $APP_HOME
RUN chmod -R 777 $APP_HOME/storage
RUN chmod -R 777 $APP_HOME/bootstrap/cache
RUN php artisan key:generate