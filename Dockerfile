FROM oven/bun:debian AS frontend

RUN useradd -m app
USER app
WORKDIR /home/app/app
COPY --chown=app:app . .

RUN bun install
RUN bun run build

FROM php:8.3-fpm AS final

RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -m app
USER app

WORKDIR /home/app/app
COPY --from=frontend --chown=app:app /home/app/app/ .

RUN composer install
CMD [ "bash", "./entry.bash" ]
