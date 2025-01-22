FROM php:8.2-cli

RUN apt-get update && apt-get install -y libmcrypt-dev mariadb-client \
    && docker-php-ext-install pdo_mysql pcntl

RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

RUN apt-get install -y wget unzip curl

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
       && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
       && rm composer-setup.php


RUN apt-get install -y cron

USER 1000:1000

WORKDIR /var/www
