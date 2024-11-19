FROM node:14-alpine AS node
FROM composer:2.3 AS composer

FROM alpine:3.16.9

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY --from=node /usr/lib           /usr/lib
COPY --from=node /usr/local/share   /usr/local/share
COPY --from=node /usr/local/lib     /usr/local/lib
COPY --from=node /usr/local/include /usr/local/include
COPY --from=node /usr/local/bin     /usr/local/bin

RUN apk update --no-cache && apk add --no-cache \
    curl \
    supervisor \
    unzip \
    python3 \
    g++ \
    make \
    nginx \
    yarn \
    php81 \
    php81-apcu \
    php81-calendar \
    php81-common \
    php81-cli \
    php81-common \
    php81-ctype \
    php81-curl \
    php81-dom \
    php81-exif \
    php81-fileinfo \
    php81-fpm \
    php81-gd \
    php81-intl \
    php81-mbstring \
    php81-mysqli \
    php81-mysqlnd \
    php81-opcache \
    php81-pdo \
    php81-pdo_mysql \
    php81-pdo_pgsql \
    php81-pgsql \
    php81-phar \
    php81-session \
    php81-simplexml \
    php81-sqlite3 \
    php81-tokenizer \
    php81-xml \
    php81-xmlwriter \
    php81-xsl \
    php81-zip

RUN rm -rf /var/lib/apk/lists/* /tmp/* /var/tmp/* /usr/share/doc/* /usr/share/man/* /var/cache/apk/*

RUN ln -s /usr/sbin/php-fpm81 /usr/sbin/php-fpm \
    && ln -s /usr/bin/php81 /usr/bin/php \
    && mkdir -p /run/php /var/log/php-fpm

RUN adduser -u 1000 -D -S -G www-data www-data

COPY .docker/php/supervisord.conf   /etc/supervisor/conf.d/supervisor.conf
COPY .docker/nginx/nginx.conf         /etc/nginx/nginx.conf
COPY .docker/php/php-fpm.conf       /etc/php81/php-fpm.conf
COPY .docker/php/php.ini            /etc/php81/php.ini

WORKDIR /app

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]
