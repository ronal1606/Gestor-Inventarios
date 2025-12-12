FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    libicu-dev \
 && docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader || cat /var/www/storage/logs/laravel.log || true

CMD ["php-fpm"]

