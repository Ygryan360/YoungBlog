FROM php:8.3-apache AS base

ARG WWW_USER=1000

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public \
  COMPOSER_ALLOW_SUPERUSER=1 \
  PHP_MEMORY_LIMIT=512M \
  PHP_OPCACHE_VALIDATE_TIMESTAMPS=1 \
  PHP_OPCACHE_MAX_ACCELERATED_FILES=20000 \
  PHP_OPCACHE_MEMORY_CONSUMPTION=192 \
  PHP_OPCACHE_INTERNED_STRINGS_BUFFER=16

RUN apt-get update && apt-get install -y --no-install-recommends \
  git unzip zip curl pkg-config mariadb-client gosu \
  libpng-dev libjpeg-dev libfreetype6-dev \
  libzip-dev libicu-dev libxml2-dev libonig-dev libcurl4-openssl-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring bcmath gd zip intl opcache \
  && a2enmod rewrite headers \
  && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/conf-available/*.conf \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

FROM base AS vendor-production

WORKDIR /var/www/html

COPY composer.json composer.lock* ./

RUN composer install --no-interaction --prefer-dist --no-dev --no-scripts --no-progress --classmap-authoritative

FROM base AS vendor-development
WORKDIR /var/www/html
COPY composer.json composer.lock* ./
RUN composer install --no-interaction --prefer-dist --no-scripts --no-progress

FROM oven/bun:1 AS assets
WORKDIR /app

COPY package.json ./
RUN if [ -f package.json ]; then bun install; else echo "No package.json, skipping bun install"; fi

COPY resources/ resources/
COPY vite.config.js ./
RUN if [ -f package.json ]; then bun run build || echo "Asset build failed/ skipped"; fi

FROM base AS runtime

ARG APP_ENV=local

ENV APP_ENV=${APP_ENV}

WORKDIR /var/www/html

COPY . .

RUN if [ "$APP_ENV" = "production" ]; then echo "Using production vendors"; fi
COPY --from=vendor-production /var/www/html/vendor /tmp/vendor-production
COPY --from=vendor-development /var/www/html/vendor /tmp/vendor-development
RUN if [ "$APP_ENV" = "production" ]; then mv /tmp/vendor-production vendor && rm -rf /tmp/vendor-development; else mv /tmp/vendor-development vendor && rm -rf /tmp/vendor-production; fi

RUN if [ "$APP_ENV" = "production" ]; then \
  composer dump-autoload --optimize --no-dev && php artisan package:discover --ansi; \
  else \
  composer dump-autoload && (php artisan package:discover --ansi || true); \
  fi

COPY --from=assets /app/public/build ./public/build

RUN mkdir -p storage bootstrap/cache \
  && chown -R www-data:www-data storage bootstrap/cache \
  && usermod -u ${WWW_USER} www-data && groupmod -g ${WWW_USER} www-data || true

HEALTHCHECK --interval=30s --timeout=5s --retries=3 CMD curl -f http://localhost/ || exit 1

EXPOSE 80

COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
