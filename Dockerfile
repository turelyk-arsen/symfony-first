FROM php:8.1.0-fpm-alpine

RUN apk add --no-cache curl git zlib-dev bash

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./ /app
WORKDIR /app

RUN composer install

CMD ["sh", "-c", "cd /app && symfony server:start -d"]
