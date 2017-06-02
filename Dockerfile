FROM php:7.1-fpm

RUN apt-get update && apt-get install -y mysql-client

RUN docker-php-ext-install pdo_mysql