FROM php:8.2-apache

# Instalar dependencias del sistema y Node
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql mbstring

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar directorio de la app
WORKDIR /app

# Copiar archivos
COPY . /app

# Copiar .env de producción (si lo tienes preparado)
# COPY .env.prod /app/.env

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader \
    && npm install --omit=dev \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Dar permisos a storage y bootstrap
RUN chmod -R 775 storage bootstrap/cache

# Exponer puerto
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
