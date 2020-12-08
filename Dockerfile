FROM php:7.4-alpine

RUN apk --update --no-cache add git bash

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

CMD php -S 0.0.0.0:80 index.php
