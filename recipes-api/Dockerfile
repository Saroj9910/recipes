# Use the official PHP image with Apache
FROM php:7.4-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the contents of the project directory on the host machine to /var/www/html in the container
COPY . /var/www/html/

# Install the necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql
