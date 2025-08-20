FROM php:8.4-apache AS server

WORKDIR /app

COPY . .

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

# Get Bun
COPY --from=oven/bun:latest /usr/local/bin/bun /usr/bin/bun

# Permissions : tout appartient à www-data (utilisateur d’Apache par défaut)
RUN chown -R www-data:www-data /app

RUN composer install --no-interaction --prefer-dist --no-progress || true && \
  php artisan key:generate && \
  php artisan migrate && \
  php artisan optimize

RUN bun install && bun run build

# Expose port
EXPOSE 80

