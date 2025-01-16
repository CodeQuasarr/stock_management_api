# Utiliser une image PHP officielle avec FPM
FROM php:8.2-fpm

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installer Composer (gestionnaire de dépendances PHP)
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier l'application Laravel dans le conteneur
COPY . .

# Donner les bonnes permissions aux répertoires
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Installer les dépendances de Laravel
RUN composer install --optimize-autoloader --no-dev

# Exposer le port utilisé par PHP-FPM
EXPOSE 9000

# Commande par défaut (démarrage de PHP-FPM)
CMD ["php-fpm"]
