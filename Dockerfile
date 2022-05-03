FROM php:7.4.3-apache

# RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN apt update
RUN apt install bash
RUN alias composer='php /usr/bin/composer'
COPY ./composer.json .
RUN apt install git -y
RUN composer install
COPY ./src .