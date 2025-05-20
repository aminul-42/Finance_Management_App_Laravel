FROM php:8.2

RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev sqlite3 libsqlite3-dev

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-dev
RUN cp .env.example .env
RUN php artisan key:generate

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
