### PHP DEPENDENCIES ###
FROM composer:2.7.7@sha256:2088445f2bcaea6fe72cefcdd9ef0cb75139ee103459cc0d1dad496e19847d2c AS vendor

WORKDIR /app_composer_dependencies

COPY composer.json composer.lock ./

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist \
    --ignore-platform-reqs

### FRONTEND ###
FROM node:21.7.3-bullseye-slim@sha256:50adaf5a166e4e3dc01e77e9bdb4c35e34ef32a1e9e26200019cddb2b154fb34 AS frontend

WORKDIR /app_frontend_dependencies

COPY package.json package-lock.json postcss.config.js tailwind.config.js vite.config.js ./

RUN npm clean-install

COPY resources/js ./resources/js/
COPY resources/css ./resources/css/

RUN npm run build

### APPLICATION ###
FROM php:8.3.10-fpm-bullseye@sha256:857b7cdf42fc4e5b313548e6f6260fce0534439e30915824a5ac3efe9a121dff AS app

COPY --from=vendor /usr/bin/composer /usr/local/bin/composer

# For other versions check: http://nginx.org/packages/mainline/debian/pool/nginx/n/nginx/
ARG NGINX_VERSION="1.25.0-1~bullseye"
ARG PHPREDIS_VERSION=6.0.2

RUN apt-get update \
    && apt-get install --assume-yes gpg \
    && curl https://nginx.org/keys/nginx_signing.key | gpg --dearmour --output /etc/apt/trusted.gpg.d/apt.nginx.org.gpg > /dev/null \
    && echo "deb https://nginx.org/packages/mainline/debian bullseye nginx" | tee /etc/apt/sources.list.d/nginx.list \
    && apt-get update && apt-get install --assume-yes \
        nginx=${NGINX_VERSION} \
        libzip-dev \
        libpq-dev \
        supervisor \
        cron \
    && pecl install redis-${PHPREDIS_VERSION} \
    && docker-php-ext-install \
        zip \
        pdo_pgsql \
        opcache \
    && docker-php-ext-enable \
        redis

RUN mv "${PHP_INI_DIR}/php.ini-production" "${PHP_INI_DIR}/php.ini"
COPY ./environment/prod/app/php.ini "${PHP_INI_DIR}/conf.d/zzz-overrides-php.ini"
COPY ./environment/prod/app/php-fpm.conf "/usr/local/etc/php-fpm.d/zzz-overrides.conf"
COPY ./environment/prod/app/nginx.conf "/etc/nginx/nginx.conf"
COPY ./environment/prod/app/supervisord.conf "/etc/supervisor/custom-supervisord.conf"
COPY ./environment/prod/app/entrypoint.sh /entrypoint.sh

WORKDIR /application

# Copy Frontend build
COPY --chown=www-data:www-data --from=frontend /app_frontend_dependencies/public/build ./public/build/

# Copy Composer dependencies
COPY --chown=www-data:www-data --from=vendor /app_composer_dependencies/vendor ./vendor/

# Copy App files
COPY --chown=www-data:www-data . .

RUN composer dump-autoload --optimize

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]

ARG DEPLOYMENT_PROJECT_VERSION_ARG
ENV DEPLOY_VERSION=${DEPLOYMENT_PROJECT_VERSION_ARG}
