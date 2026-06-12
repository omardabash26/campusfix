#!/usr/bin/env sh

echo "==> Running migrations"
php artisan migrate --force || true

echo "==> Starting server on port ${PORT:-8080}"
php artisan serve --host 0.0.0.0 --port "${PORT:-8080}"
