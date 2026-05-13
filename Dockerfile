FROM php:8.2-apache

# Instalar mysqli
RUN docker-php-ext-install mysqli

# Copiar arquivos
COPY . /var/www/html/
