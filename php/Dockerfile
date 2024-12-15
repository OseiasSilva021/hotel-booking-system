FROM php:8.1-apache

# Instalar Postfix
RUN apt-get update && apt-get install -y postfix mailutils

# Habilitar o módulo do Apache
RUN a2enmod rewrite

# Instalar as dependências do PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar arquivos do projeto para o container
COPY . /var/www/html/

# Expor a porta 80
EXPOSE 80
