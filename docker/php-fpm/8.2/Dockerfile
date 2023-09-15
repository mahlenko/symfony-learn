FROM php:8.2-fpm-alpine

# Install packages
RUN apk update && apk upgrade && \
    apk add -y --no-cache \
        curl \
        git \
        build-base \
        zlib-dev \
        oniguruma-dev \
        autoconf \
        bash

# Install extensions
RUN apk add --update linux-headers

ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug-3.2.1 && docker-php-ext-enable xdebug; \
    fi;

COPY ./8.2/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Postgress
RUN apk add --no-cache libpq-dev && \
    docker-php-ext-install pdo_pgsql

# Configure non-root user.
ARG PUID=1000
ARG PGID=1000

RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
COPY ./ /var/www
WORKDIR /var/www

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

CMD php-fpm
EXPOSE 9000
