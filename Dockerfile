FROM php:8.2-fpm-alpine

WORKDIR /var/www/app

RUN apk update && apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev

RUN docker-php-ext-install pdo pdo_mysql intl zip \
    && apk --no-cache add nodejs npm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN chmod 777 -R /var/www/app

