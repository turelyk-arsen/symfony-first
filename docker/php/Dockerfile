FROM php:8.1.0-fpm-alpine
RUN apk add --no-cache curl git zlib-dev bash
RUN docker-php-ext-install pdo pdo_mysql

COPY  ./ /app
WORKDIR /app
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer