#!/usr/bin/env sh

echo "==> start.sh running, PORT=${PORT:-8080}"

php artisan migrate --force || echo "==> migrate failed, continuing"

php artisan config:cache || true
php artisan view:cache || true

export PHP_CLI_SERVER_WORKERS=4

echo "==> launching server on 0.0.0.0:${PORT:-8080}"
exec php artisan serve --host 0.0.0.0 --port "${PORT:-8080}"
