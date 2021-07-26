ARG php_version
FROM php:${php_version}-cli as build

RUN apt-get update && apt-get install -y default-mysql-client

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions bcmath
RUN install-php-extensions pdo_mysql

# ---

FROM composer as composer

# ---

FROM build as phpunit

COPY . /app
VOLUME /app
WORKDIR /app

COPY tests/entrypoint.sh /usr/local/bin/custom_entrypoint
RUN chmod a+x /usr/local/bin/custom_entrypoint

# COPY --from=composer /usr/bin/composer /usr/bin/composer
# RUN composer install \
#     --verbose \
#     --no-interaction;

ENTRYPOINT ["/usr/local/bin/custom_entrypoint", "docker-php-entrypoint"]
CMD ["/app/bin/phpunit"]
