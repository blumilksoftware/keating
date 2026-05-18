FROM alpine:3.21.7@sha256:48b0309ca019d89d40f670aa1bc06e426dc0931948452e8491e3d65087abc07d AS secops-tools

# https://github.com/FiloSottile/age/releases
ARG AGE_VERSION="1.1.1"

# https://github.com/getsops/sops/releases
ARG SOPS_VERSION="3.8.1"

RUN wget --output-document age.tar.gz "https://github.com/FiloSottile/age/releases/download/v${AGE_VERSION}/age-v${AGE_VERSION}-linux-amd64.tar.gz" \
    && tar --extract --file age.tar.gz \
    && mv age/age /usr/local/bin \
    && mv age/age-keygen /usr/local/bin \
    && wget --output-document /usr/local/bin/sops "https://github.com/getsops/sops/releases/download/v${SOPS_VERSION}/sops-v${SOPS_VERSION}.linux.amd64" \
    && chmod +x /usr/local/bin/sops

FROM composer/composer:2.8.12-bin@sha256:f1a57d9cabfc04430058288eaab6c18967b19a3870b5fe71bf0c6afd67968653 AS composer-bin

FROM node:21.7.3-bullseye-slim@sha256:50adaf5a166e4e3dc01e77e9bdb4c35e34ef32a1e9e26200019cddb2b154fb34 AS node

FROM php:8.3.14-fpm-bullseye@sha256:0bd459a1077bcb18e6869c77c46cef20e83e754aa11a7036c36f0e6a5ea254c2

COPY --from=composer-bin ./composer /usr/bin/composer
COPY --from=secops-tools /usr/local/bin/age /usr/local/bin/age
COPY --from=secops-tools /usr/local/bin/age-keygen /usr/local/bin/age-keygen
COPY --from=secops-tools /usr/local/bin/sops /usr/local/bin/sops

ARG USER_NAME=host-user
ARG USER_ID=1000
ARG PHP_FPM_GROUP=www-data

RUN adduser \
        --disabled-password \
        --uid ${USER_ID} \
        ${USER_NAME} \
    && usermod \
        --append \
        --groups \
        ${PHP_FPM_GROUP} \
        ${USER_NAME}

#Add node and npm
COPY --from=node --chown=${USER_NAME}:root /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node --chown=${USER_NAME}:root /usr/local/bin/node /usr/local/bin/node
RUN ln --symbolic /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && chown --no-dereference ${USER_NAME}:root /usr/local/bin/npm \
    && ln --symbolic /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx \
    && chown --no-dereference ${USER_NAME}:root /usr/local/bin/npx

# Use the default development configuration
RUN mv "${PHP_INI_DIR}/php.ini-development" "${PHP_INI_DIR}/php.ini"

# For other versions check: http://nginx.org/packages/mainline/debian/pool/nginx/n/nginx/
ARG NGINX_VERSION="1.25.2-1~bullseye"
ARG PHPREDIS_VERSION=6.0.2

RUN apt-get update \
    && apt-get install --assume-yes gpg \
    && curl https://nginx.org/keys/nginx_signing.key | gpg --dearmour --output /etc/apt/trusted.gpg.d/apt.nginx.org.gpg > /dev/null \
    && echo "deb https://nginx.org/packages/mainline/debian bullseye nginx" | tee /etc/apt/sources.list.d/nginx.list \
    && apt-get update && apt-get install --assume-yes \
        nginx=${NGINX_VERSION} \
        gnupg \
        libzip-dev \
        libpng-dev \
        libpq-dev \
        supervisor \
        cron \
    && pecl install redis-${PHPREDIS_VERSION} \
    && docker-php-ext-install \
        zip \
        pdo_pgsql \
        gd \
    && docker-php-ext-enable \
        redis

ARG XDEBUG_VERSION=3.3.1
ARG INSTALL_XDEBUG=true

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug \
;fi

COPY ./entrypoint.sh /entrypoint.sh

WORKDIR /application

ENTRYPOINT ["/entrypoint.sh"]
