#!/bin/bash
set -e
npm run build || true   # quítalo si no usas frontend con Vite/React
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache