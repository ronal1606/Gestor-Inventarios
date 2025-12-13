
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl \
    libzip-dev libpng-dev libonig-dev libicu-dev \
    && docker-php-ext-install \
        pdo pdo_mysql zip intl

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
