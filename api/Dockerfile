ARG PHP_VERSION=7.4
FROM php:$PHP_VERSION-fpm as build

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions bcmath
RUN install-php-extensions gd
RUN install-php-extensions gettext
RUN install-php-extensions pdo_mysql
RUN install-php-extensions tidy

RUN pecl install ds
RUN docker-php-ext-enable ds

RUN apt-get update && apt-get install -y default-mysql-client

COPY overrides.ini ${PHP_INI_DIR}/50-overrides.ini

COPY ./ /opt/api
WORKDIR /opt/api

# ---

ARG PHP_COMPOSER_VERSION=2
FROM composer:$PHP_COMPOSER_VERSION as composer

# ---

FROM build as development

RUN pecl install xdebug && docker-php-ext-enable xdebug;
COPY ./ext-xdebug.ini ${PHP_INI_DIR}/888-xdebug.ini

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

VOLUME [ "/opt/api/vendor" ]

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install \
    --verbose \
    --no-interaction;

# ---

FROM build as prod

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install \
    --verbose \
    --no-interaction \
    --prefer-dist \
    --no-dev \
    --optimize-autoloader;
