FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl libonig-dev libzip-dev zip libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip dom

WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
