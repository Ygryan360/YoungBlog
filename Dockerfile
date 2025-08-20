# --- Assets build (Bun) stage ---
FROM oven/bun:1 AS assets

WORKDIR /app

COPY package.json bun.lockb* ./

RUN if [ -f package.json ]; then bun install || true; else echo "[assets] No package.json, skipping bun install"; fi

COPY resources/ resources/
COPY vite.config.js ./

RUN if [ -f package.json ]; then bun run build || echo "[assets] Build failed/skipped"; fi


# ------------ PHP + Apache ---------
FROM php:8.4-apache AS server

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git curl unzip zip \
  libpng-dev libjpeg-dev libfreetype6-dev \
  libonig-dev libxml2-dev libpq-dev libzip-dev libcurl4-openssl-dev libicu-dev default-mysql-client \
  && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql mbstring pcntl gd zip intl

# Enable Apache mods
RUN a2enmod rewrite

# Copy vhost config
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Get Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy assets build
COPY --from=assets /app/public/build ./public/build

# Permissions : tout appartient à www-data (utilisateur d’Apache par défaut)
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80

