
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl \
    libzip-dev libpng-dev libonig-dev libicu-dev \
    && docker-php-ext-install \
        pdo pdo_mysql zip intl

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
