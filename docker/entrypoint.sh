#!/usr/bin/env bash
set -e

APP_USER=www-data
APP_GROUP=www-data

fix_permissions() {
  for dir in storage bootstrap/cache; do
    if [ ! -d "$dir" ]; then
      mkdir -p "$dir"
    fi
    if [ ! -w "$dir" ]; then
      echo "[entrypoint] Fixing permissions on $dir"
      chown -R $APP_USER:$APP_GROUP "$dir" || true
      chmod -R ug+rwX "$dir" || true
    fi
  done
}

generate_app_key() {
  if [ -f .env ]; then
    if grep -q '^APP_KEY=$' .env || ! grep -q '^APP_KEY=' .env; then
      echo "[entrypoint] Generating APP_KEY"
      php artisan key:generate --ansi || echo "[entrypoint] Failed to generate key"
    fi
  fi
}

cache_optimize_prod() {
  if [ "${APP_ENV}" = "production" ]; then
    echo "[entrypoint] Optimizing caches"
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
  fi
}

fix_permissions
generate_app_key
cache_optimize_prod

if [ "$(id -u)" = "0" ]; then
  exec gosu $APP_USER:$APP_GROUP "$@"
else
  exec "$@"
fi
