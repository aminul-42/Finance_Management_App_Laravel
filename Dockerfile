FROM php:8.2

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev sqlite3 libsqlite3-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /app

# Copy files
COPY . .

# Install PHP dependencies
RUN composer install

# Laravel setup
RUN cp .env.example .env && \
    php artisan key:generate && \
    php artisan config:clear

# Expose port and start server
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
