FROM php:8.1-apache

# Instalar Postfix, outras dependências, unzip e a extensão zip
RUN apt-get update && apt-get install -y \
    postfix \
    mailutils \
    libzip-dev \
    curl \
    unzip && \
    docker-php-ext-install mysqli pdo pdo_mysql zip

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar o módulo do Apache
RUN a2enmod rewrite

# Copiar arquivos do projeto para o container
COPY . /var/www/html/

# Expor a porta 80
EXPOSE 80
