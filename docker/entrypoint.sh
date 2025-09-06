#!/usr/bin/env bash
set -e

# Ensure storage and bootstrap/cache ownership/permissions
chown -R www-data:www-data /app/storage /app/bootstrap/cache
chmod -R ug+rwx /app/storage /app/bootstrap/cache

# Create storage symlink if missing
if [ ! -L /app/public/storage ]; then
  su-exec www-data:www-data php /app/artisan storage:link
fi

# Run any pending migrations (optional - disabled by default)
# php /app/artisan migrate --force

# If vendor is missing, run composer install
if [ ! -d /app/vendor ]; then
  su-exec www-data:www-data composer install --no-interaction --prefer-dist --no-progress
fi

# Build assets if node_modules not present
if [ ! -d /app/node_modules ]; then
  # bun may run as root inside container; try to run as www-data
  su-exec www-data:www-data bun install
  su-exec www-data:www-data bun run build
fi

# Start apache in foreground
exec /usr/sbin/apache2ctl -D FOREGROUND
