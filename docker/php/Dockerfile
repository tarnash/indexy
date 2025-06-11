FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl libonig-dev libzip-dev zip libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip dom sockets

# Установка Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
