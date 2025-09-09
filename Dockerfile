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
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

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

# Copy dependency files first
COPY composer.json composer.lock* package.json ./

# Install PHP dependencies WITHOUT scripts
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts

# Copy application files
COPY . .

# Create necessary directories
RUN mkdir -p storage/app/public \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache \
  public/build \
  && chown -R www-data:www-data bootstrap/cache storage \
  && chmod -R 775 bootstrap/cache storage

# Run autoloader optimization
RUN composer dump-autoload --no-dev --optimize

# Final ownership and permissions
RUN chown -R www-data:www-data /app \
  && chmod -R 755 /app \
  && chmod -R 775 storage bootstrap/cache

# Copy entrypoint script and make executable
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

# Use entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]