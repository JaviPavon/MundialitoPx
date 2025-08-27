# Dockerfile diagnóstico + build para Laravel 10 / Symfony 7 (PHP 8.2)
FROM php:8.2-fpm AS build

# Evitar interacción de apt
ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# Instalar herramientas del sistema + node/npm
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    zip \
    npm \
    nodejs \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP requeridas por Laravel/Symfony
RUN docker-php-ext-install pdo_mysql mbstring zip bcmath exif pcntl

WORKDIR /app

# Copiar composer files primero para cachear capas Docker
COPY composer.json composer.lock /app/

# Copiar el resto del código
COPY . /app

# Diagnóstico: mostrar versión PHP y extensiones, composer diagnose y check-platform-reqs
RUN php -v \
    && php -m | sort \
    && composer --version \
    && composer diagnose || true \
    && composer check-platform-reqs || true

# Instalación con log verbose (capturamos log para depuración)
# Si falla, STILL escribimos el log en /tmp/composer.log y lo mostramos (para que puedas copiarlo aquí).
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction -vvv > /tmp/composer.log 2>&1 || true \
    && echo "==== MOSTRANDO /tmp/composer.log ====" \
    && sed -n '1,200p' /tmp/composer.log || true

# Instalar dependencias JS (silencioso)
RUN npm install --production || true

# Ajustar permisos
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Stage final (imagen más ligera)
FROM php:8.2-fpm

WORKDIR /app
COPY --from=build /app /app

EXPOSE 9000

CMD ["php-fpm"]
