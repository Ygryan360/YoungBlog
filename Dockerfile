# --- Assets build (Bun) stage ---
FROM oven/bun:1 AS assets

WORKDIR /app

COPY package.json ./

RUN if [ -f package.json ]; then bun install || true; else echo "[assets] No package.json, skipping bun install"; fi

COPY resources/ resources/

COPY vite.config.js ./

RUN if [ -f package.json ]; then bun run build || echo "[assets] Build failed/skipped"; fi


# --- Final runtime stage ---
FROM php:8.4-apache AS final

ARG WWW_USER=1000

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1 APACHE_DOCUMENT_ROOT=/app/public

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
  git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libpq-dev libzip-dev libcurl4-openssl-dev libicu-dev zip unzip default-mysql-client \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql mbstring pcntl gd zip intl \
  && a2enmod rewrite headers \
  && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/conf-available/*.conf

RUN groupadd --force -g ${WWW_USER} webapp && id -u ${WWW_USER} 2>/dev/null || useradd -ms /bin/bash --no-user-group -g ${WWW_USER} -u ${WWW_USER} webapp

COPY composer.json composer.lock* ./

RUN composer install --no-interaction --prefer-dist --no-progress || true

COPY . .

COPY --from=assets /app/public/build ./public/build

RUN mkdir -p storage bootstrap/cache && chown -R ${WWW_USER}:${WWW_USER} storage bootstrap/cache && chmod -R ug+rwX storage/bootstrap/cache 2>/dev/null || true && chmod -R ug+rwX storage bootstrap/cache

RUN if [ -f artisan ]; then grep -q '^APP_KEY=' .env 2>/dev/null || php artisan key:generate --ansi || true; fi

EXPOSE 80

USER ${WWW_USER}
