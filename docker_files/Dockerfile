FROM php:8.1.0-fpm-alpine

RUN apk add --no-cache curl git zlib-dev bash
RUN docker-php-ext-install pdo_mysql

RUN apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | sh
RUN apk add symfony-cli

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./ /var/www
WORKDIR /var/www

RUN composer install

CMD ["symfony", "server:start", "-d"]

# EXPOSE 9000

# CMD ["sh", "-c", "cd /app && symfony server:start -d"]
