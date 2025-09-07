FROM php:8.3-apache AS server

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git curl unzip zip \
  libpng-dev libjpeg-dev libfreetype6-dev \
  libonig-dev libxml2-dev libpq-dev libzip-dev libcurl4-openssl-dev libicu-dev default-mysql-client \
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

# Copy composer files
COPY composer.json composer.lock* ./

# Install PHP dependencies
RUN if [ -f composer.lock ]; then \
      composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader; \
    else \
      composer install --no-dev --no-interaction --prefer-dist; \
    fi

# Copy application files
COPY . .

# Set proper permissions
RUN chown -R www-data:www-data /app

# Copy entrypoint script and make executable
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

# Use entrypoint to fix permissions at container start and run the default CMD
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

