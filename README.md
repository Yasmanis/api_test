# Guía para el despliegue de la app

1. Correr los siguientes comandos:

> Descomprimir api.zip.
* `unzip api.zip`  
> Contruir la app a partir del docker-compose.yml.
* `docker-compose up -d`
> Conectarme al contenedor de la web.
* `docker exec -it id_web_container /bin/bash`
> Comandos para gestionar los permisos y que la app se ejecute correctamente.
* `cd /var/www`
* `chown -R $USER:www-data storage`
* `chown -R $USER:www-data bootstrap/cache`
* `chmod -R 775 storage`
* `chmod -R 775 bootstrap/cache`
> Realizar las migraciones y el poblado de las tablas
* `php artisan migrate --seed`

> Autenticación

2. Las credenciales por default son:
* `email`: admin@gmail.com
* `password`: 123
