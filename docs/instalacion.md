# Instalación

## Requisitos previos

Para ejecutar el proyecto localmente se necesitan:

- PHP 8.2 o superior  
- Composer 2.9
- MySQL 8.x
- Nginx

## Pasos de instalación
- Clonar el repositorio en el servidor:
  git clone https://github.com/Ti7euF/GoRentBike /var/www/GoRentBike

- Dar permisos
  chmod -R 775 storage bootstrap/cache
  chown -R www-data:www-data /var/www/GoRentBike

- Instalar dependencias PHP
  composer install

- Crear archivo de entorno y configurar
  cp .env.example .env
  nano .env

- Generar clave de aplicación
  php artisan key:generate

- Configurar caché de Laravel
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache

- Instalar, iniciar y activar el servicio de nginx
  sudo apt install nginx -y
  sudo systemctl start nginx
  sudo systemctl enable nginx

- Configurar y linkear el servidor
  sudo nano /etc/nginx/sites-available/gorentbike
  sudo ln -s /etc/nginx/sites-available/gorentbike /etc/nginx/sites-enabled/

- Comprobar configuración y reiniciar
  sudo nginx -t
  sudo systemctl reload nginx

- Instalar y configurar MySQL
  sudo apt install mysql-server -y
  sudo mysql
  CREATE DATABASE gorentbike CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  CREATE USER 'gorentbike_user'@'localhost' IDENTIFIED BY 'Pass';
  GRANT ALL PRIVILEGES ON gorentbike.* TO 'gorentbike_user'@'localhost';
  FLUSH PRIVILEGES;

- Importar plantilla de base de datos  
  mysql -u gorentbike_user -p gorentbike < database.sql


## Variables de entorno
No hay variables de entorno.


[⬅ Volver al índice](index.md)