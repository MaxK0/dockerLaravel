FROM php:8.4.1-fpm-alpine

RUN apk update && apk add --no-cache \
      libpng-dev \
      libzip-dev \
      zip \
      unzip \
      git \
      postgresql-dev \
      && docker-php-ext-install pdo_mysql \
      && docker-php-ext-install bcmath \
      && docker-php-ext-install gd \
      && docker-php-ext-install zip

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www/html
