FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    libonig-dev \
    libzip-dev && apt-get clean && rm -rf /var/lib/apt/lists/*



RUN docker-php-ext-install pdo_mysql mbstring zip exif


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN ln -sf /bin/bash /bin/sh

WORKDIR /var/www/html
COPY . /var/www/html

RUN chmod 0777 -R /var/www/ && chown -R www-data:www-data /var/www/html && chmod +x .docker/php/start.sh

USER www-data

COPY .docker/php/php.ini /usr/local/etc/php/conf.d/
