
FROM php:8.2-fpm

# 1. Instalar dependencias del sistema y librerías para extensiones
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev

# 2. Configurar e instalar extensiones PHP requeridas por Laravel y Filament
# (Filament necesita bcmath y gd es vital para inventarios con imagenes)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl

# 3. Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Establecer directorio de trabajo
WORKDIR /var/www/html

# 5. Copiar archivos del proyecto
COPY . .

# 6. Instalar dependencias de PHP (CRUCIAL PARA QUE NO SE REINICIE)
# Usamos --no-dev para producción y optimizamos el autoloader
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 7. Permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# 8. Comando de inicio
CMD ["php-fpm"]
