# Dockerfile para Laravel 10 / Symfony 7 — Build y runtime en PHP 8.2
FROM php:8.2-fpm

ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# Instalar dependencias de sistema + node (suficiente para la mayoría de casos)
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl unzip zip libzip-dev libonig-dev nodejs npm ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Extensiones PHP necesarias
RUN docker-php-ext-install pdo_mysql mbstring zip bcmath exif pcntl

WORKDIR /app

# Copiar composer files primero para cache de capas
COPY composer.json composer.lock /app/

# Copiar resto del código
COPY . /app

# Instalar dependencias PHP y JS
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction \
    && npm install --production

# Ajustar permisos
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
