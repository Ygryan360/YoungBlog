FROM php:8.4-apache AS server

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
  git curl unzip zip \
  libpng-dev libjpeg-dev libfreetype6-dev \
  libonig-dev libxml2-dev libpq-dev libzip-dev libcurl4-openssl-dev libicu-dev default-mysql-client \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql mbstring pcntl gd zip intl

RUN a2enmod rewrite

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --from=oven/bun:latest /usr/local/bin/bun /usr/bin/bun

RUN chown -R www-data:www-data /app

# Copy entrypoint script and make executable
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN composer install --no-interaction --prefer-dist --no-progress || true && \
  php artisan key:generate && \
  php artisan migrate && \
  php artisan optimize

RUN bun install && bun run build

EXPOSE 80

# Use entrypoint to fix permissions at container start and run the default CMD
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

