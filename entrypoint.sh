#!/usr/bin/env bash
set -e

echo "Starting Laravel application setup..."

# Wait for database connection if needed (optional)
# php artisan wait:db

# Ensure storage directory structure exists in the volume
mkdir -p /app/storage/app/public \
         /app/storage/framework/cache/data \
         /app/storage/framework/sessions \
         /app/storage/framework/views \
         /app/storage/logs \
         /app/bootstrap/cache

# Set proper ownership and permissions for storage and bootstrap/cache
chown -R www-data:www-data /app/storage /app/bootstrap/cache
chmod -R 775 /app/storage /app/bootstrap/cache

# Create storage symlink if missing
if [ ! -L /app/public/storage ]; then
    echo "Creating storage symlink..."
    if command -v su-exec >/dev/null 2>&1; then
        su-exec www-data:www-data php /app/artisan storage:link
    else
        php /app/artisan storage:link
    fi
fi

# Install Node.js dependencies and build assets if needed
if [ ! -d /app/node_modules ] || [ ! -f /app/public/build/manifest.json ]; then
    echo "Installing Node.js dependencies and building assets..."
    if command -v su-exec >/dev/null 2>&1; then
        su-exec www-data:www-data bun install --frozen-lockfile
        if [ -f "vite.config.js" ] || [ -f "vite.config.ts" ]; then
            su-exec www-data:www-data bun run build || echo "Asset build failed, continuing..."
        fi
    else
        bun install --frozen-lockfile
        if [ -f "vite.config.js" ] || [ -f "vite.config.ts" ]; then
            bun run build || echo "Asset build failed, continuing..."
        fi
    fi
fi
# if ! grep -q "APP_KEY=" /app/.env || grep -q "APP_KEY=$" /app/.env; then
#     echo "Generating application key..."
#     php /app/artisan key:generate --force
# fi

# Clear and cache configurations for production
echo "Optimizing Laravel for production..."
php /app/artisan config:cache
php /app/artisan route:cache
php /app/artisan view:cache

# Run database migrations if needed (uncomment if you want auto-migrations)
# echo "Running database migrations..."
# php /app/artisan migrate --force

# Final permission check
chown -R www-data:www-data /app/storage /app/bootstrap/cache

echo "Laravel application setup completed. Starting Apache..."

# Start apache in foreground
exec /usr/sbin/apache2ctl -D FOREGROUND