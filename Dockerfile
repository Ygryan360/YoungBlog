# --- Assets build (Bun) stage ---
FROM oven/bun:1 AS assets

WORKDIR /app

COPY package.json ./

RUN if [ -f package.json ]; then bun install || true; else echo "[assets] No package.json, skipping bun install"; fi

COPY resources/ resources/

COPY vite.config.js ./

RUN if [ -f package.json ]; then bun run build || echo "[assets] Build failed/skipped"; fi


# ------------ PHP ---------
FROM php:8.4-apache AS server

ARG WWW_USER=1000

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libonig-dev \
  libxml2-dev \
  libpq-dev \
  libzip-dev \
  libcurl4-openssl-dev \
  zip \
  unzip \
  default-mysql-client

# Install PHP extensions
RUN apt-get update && apt-get install -y \
  git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libpq-dev libzip-dev libcurl4-openssl-dev libicu-dev zip unzip default-mysql-client \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql mbstring pcntl gd zip intl

# Copy vhost config
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache mods
RUN a2enmod rewrite

# Get latest Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY --from=assets /app/public/build ./public/build

# Create user
RUN groupadd --force -g $WWW_USER webapp
RUN useradd -ms /bin/bash --no-user-group -g $WWW_USER -u $WWW_USER webapp

# Clean cache
RUN apt-get -y autoremove \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 80

USER ${WWW_USER}
