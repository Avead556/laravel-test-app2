#!/bin/sh
if [ ! -d "vendor" ]; then
  composer install
fi

if [ ! -f ".env" ]; then
    echo ".env.example => .env";
    cp .env.example .env
fi

if ! grep -q "APP_KEY=.*[^\s]" .env; then
    echo "artisan key:generate";
    php artisan key:generate
fi

chmod 0777 .env

docker-php-entrypoint php-fpm
