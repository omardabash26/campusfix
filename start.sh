#!/usr/bin/env sh

echo "==> start.sh running, PORT=${PORT:-8080}"

php artisan migrate --force || echo "==> migrate failed, continuing"

echo "==> launching server on 0.0.0.0:${PORT:-8080}"
exec php artisan serve --host 0.0.0.0 --port "${PORT:-8080}"
