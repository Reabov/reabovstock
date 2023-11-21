# Use an official PHP runtime as a parent image
FROM php:5.6-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html

# Install mysqli extension
RUN docker-php-ext-install mysqli pdo_mysql

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy the current directory contents into the container at /var/www/html/
COPY . /var/www/html/

RUN chmod -R 777 /var/www/html/

# Set the working directory to /var/www/html/
WORKDIR /var/www/html/