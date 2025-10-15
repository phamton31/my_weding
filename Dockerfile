# Usamos la imagen base de PHP con Apache
FROM php:8.2-apache

# Instalamos dependencias necesarias para PostgreSQL y PDO
RUN apt-get update && apt-get install -y \
        libpq-dev \
        && docker-php-ext-install pdo pdo_pgsql

# Configuramos el directorio de trabajo
WORKDIR /var/www/html

# Copiamos el código de tu proyecto
COPY . .

# Exponemos el puerto 80
EXPOSE 80
