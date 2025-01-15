FROM php:8.2-fpm
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html
COPY . .
RUN composer install
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
