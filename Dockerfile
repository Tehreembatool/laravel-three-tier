FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libsqlite3-dev libonig-dev \
    && docker-php-ext-install pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-interaction --optimize-autoloader --no-scripts
COPY . .

RUN php artisan package:discover --ansi \
    && mkdir -p storage/framework/cache \
       storage/framework/sessions \
       storage/framework/views \
       storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
