# Dockerfile para Laravel 10 + Symfony 7
FROM php:8.2-fpm

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libonig-dev npm nodejs \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath

WORKDIR /app

COPY . /app

# Instalar dependencias PHP y JS
RUN composer install --no-dev --optimize-autoloader && npm install --production

# Ajustar permisos
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
