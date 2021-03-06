FROM php:7.3-fpm

COPY ./ /usr/src/app
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /usr/src/app

RUN apt-get update && apt-get install -y git zip libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql
RUN composer install
RUN php artisan key:generate
RUN php artisan migrate
RUN php artisan storage:link
RUN php artisan db:seed

EXPOSE 8000
