FROM php:8.3-cli

# Installer les dépendances système et les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libxml2-dev \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    xml \
    zip \
    opcache

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/stock_management_api
