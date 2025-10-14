# Imagen base con PHP y Apache
FROM php:8.2-apache

# Copiamos todos los archivos del proyecto al servidor
COPY . /var/www/html/

# Damos permisos al archivo JSON para que pueda ser modificado
RUN chmod 666 /var/www/html/invitados.json

# Exponemos el puerto 80 (Render detectará esto automáticamente)
EXPOSE 80
