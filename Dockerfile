FROM php:7-alpine

RUN apk --no-cache add postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql