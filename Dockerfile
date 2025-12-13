FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
