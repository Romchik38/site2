FROM php:8.4.8-fpm

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        mailutils \
        msmtp \
        git \
        zip \
        unzip \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /var/lib/apt/lists/*

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions pgsql xdebug GD
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

ENV $PHP_INI_DIR=/usr/local/etc/php
COPY php/conf.d/site2.ini $PHP_INI_DIR/conf.d/
COPY php/conf.d/xdebug.ini $PHP_INI_DIR/conf.d/
COPY php/msmtprc /etc/msmtprc