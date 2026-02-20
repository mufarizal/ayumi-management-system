FROM php:8.2-fpm

#  ganti versi PHP kalau project butuh beda
# contoh: php:8.1-fpm

RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#  DEV MODE PHP (biar error nongol)
RUN echo "display_errors=On" >> /usr/local/etc/php/conf.d/dev.ini \
 && echo "display_startup_errors=On" >> /usr/local/etc/php/conf.d/dev.ini \
 && echo "error_reporting=E_ALL" >> /usr/local/etc/php/conf.d/dev.ini

WORKDIR /var/www
