FROM php:8.2

# Install required packages
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /app

# Copy files
COPY . .

# Create SQLite DB file
RUN mkdir -p database && touch database/database.sqlite

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions (important for SQLite and Laravel)
RUN chmod -R 775 storage bootstrap/cache database

# Set up environment and generate key
RUN cp .env.example .env && php artisan key:generate

# Run migrations and seeders
RUN php artisan migrate --force && php artisan db:seed --force

# Expose port for Laravel dev server
EXPOSE 8000

# Start Laravel app
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
