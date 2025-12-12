FROM php:8.2-fpm

# Extensiones necesarias
RUN apt-get update && apt-get install -y \
    libonig-dev libzip-dev unzip git \
 && docker-php-ext-install pdo pdo_mysql mbstring zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar archivos
COPY . .

RUN composer install --no-dev --optimize-autoloader \
 && php artisan config:cache \
 && php artisan route:cache

CMD ["php-fpm"]
