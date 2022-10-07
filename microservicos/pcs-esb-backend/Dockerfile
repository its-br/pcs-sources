FROM php:8.0-apache
RUN apt-get update \
    && apt-get install -y libzip-dev
RUN a2enmod rewrite \
    && docker-php-ext-install pdo_mysql zip
COPY . /var/www/html/
COPY ./apache/apache2.conf /etc/apache2/
COPY ./apache/000-default.conf /etc/apache2/sites-available/
COPY ./apache/php.ini /usr/local/etc/php/
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install \
    && php artisan key:generate \
    && php artisan migrate
