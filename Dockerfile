FROM php:8.3-apache AS server

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git curl unzip zip ca-certificates \
  libpng-dev libjpeg-dev libfreetype6-dev \
  libonig-dev libxml2-dev libpq-dev libzip-dev libcurl4-openssl-dev libicu-dev default-mysql-client \
  build-essential make gcc \
  && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql mbstring pcntl gd zip intl bcmath

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy Apache virtual host configuration
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copy composer from the composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy bun from the oven/bun image
COPY --from=oven/bun:latest /usr/local/bin/bun /usr/bin/bun

# Install su-exec
RUN curl -Ls https://github.com/ncopa/su-exec/archive/master.tar.gz | tar xz \
  && cd su-exec-master \
  && make \
  && mv su-exec /usr/local/bin/su-exec \
  && chmod +x /usr/local/bin/su-exec \
  && cd .. \
  && rm -rf su-exec-master

# Copy dependency files first (for better caching)
COPY composer.json composer.lock* package.json ./

# Install PHP dependencies (exclude dev dependencies for production)
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-autoloader

# Install Node.js dependencies
RUN bun install --frozen-lockfile

# Copy application files (excluding storage and vendor)
COPY app ./app
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY public ./public
COPY resources ./resources
COPY routes ./routes
COPY artisan ./
COPY .env.example ./.env

# Generate autoloader
RUN composer dump-autoload --no-dev --optimize

# Build assets
RUN bun run build

# Create storage directories with proper structure
RUN mkdir -p storage/app/public \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache

# Set proper permissions
RUN chown -R www-data:www-data /app \
  && chmod -R 755 /app \
  && chmod -R 775 storage bootstrap/cache

# Copy entrypoint script and make executable
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

# Use entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]