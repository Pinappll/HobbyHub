FROM php:8.2-apache

# Mise à jour des dépôts
RUN apt-get update

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install GD library for image manipulation
RUN apt-get update -y && apt-get install -y libpng-dev libfreetype6-dev libyaml-dev lsb-release wget gnupg \
    && docker-php-ext-configure gd --with-freetype \
    && docker-php-ext-install gd

# Install YAML extension
RUN pecl install yamL

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Ajout du dépôt PostgreSQL 16
RUN echo "deb http://apt.postgresql.org/pub/repos/apt/ $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
    && wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -

# Mise à jour des dépôts et installation de postgresql-client-16
RUN apt-get update && apt-get install -y postgresql-client-16

# Install zip, unzip and PHP Zip extension
RUN apt-get install -y zip unzip libzip-dev \
    && docker-php-ext-install zip

# Nettoyage des fichiers inutiles
RUN apt-get clean && rm -rf /var/lib/apt/lists/*