FROM php:8.4-apache

ARG WWW_USER=1000

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public \
  COMPOSER_ALLOW_SUPERUSER=1 \
  PATH="/root/.bun/bin:${PATH}"

RUN apt-get update && apt-get install -y \
  git unzip zip curl pkg-config mariadb-client \
  libpng-dev libjpeg-dev libfreetype6-dev \
  libzip-dev libicu-dev libxml2-dev libonig-dev libcurl4-openssl-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring bcmath gd zip intl opcache \
  && a2enmod rewrite headers \
  && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/conf-available/*.conf \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://bun.sh/install | bash

WORKDIR /var/www/html

COPY . .

COPY composer.json composer.lock* ./
RUN composer install --no-interaction --prefer-dist
RUN php artisan migrate

COPY package.json bun.lockb* ./
RUN bun install

RUN bun run build

RUN usermod -u ${WWW_USER} www-data && groupmod -g ${WWW_USER} www-data || true \
  && chown -R www-data:www-data /var/www/html

USER www-data
