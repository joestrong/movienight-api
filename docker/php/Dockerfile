FROM php:7.2-fpm

# install the PHP extensions we need
RUN apt-get update

RUN docker-php-ext-install mysqli pdo_mysql

COPY ./ /web
