# Instalación

## Requisitos previos

Para ejecutar el proyecto localmente se necesitan:

- PHP 8.2 o superior  
- Composer 2.9
- MySQL 8.x
- Nginx

## Pasos de instalación
- Clonar el repositorio en el servidor:
  ```bash
  git clone https://github.com/Ti7euF/GoRentBike /var/www/GoRentBike
  ```

- Dar permisos
  ```bash
  chmod -R 775 storage bootstrap/cache
  chown -R www-data:www-data /var/www/GoRentBike
  ```

- Instalar dependencias PHP
  ```bash
  composer install
  ```

- Crear archivo de entorno y configurar
  ```bash
  cp .env.example .env
  nano .env
  ```

- Generar clave de aplicación
  ```bash
  php artisan key:generate
  ```

- Configurar caché de Laravel
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

- Instalar, iniciar y activar el servicio de nginx
  ```bash
  sudo apt install nginx -y
  sudo systemctl start nginx
  sudo systemctl enable nginx
  ```

- Configurar y linkear el servidor
  ```bash
  sudo nano /etc/nginx/sites-available/gorentbike
  sudo ln -s /etc/nginx/sites-available/gorentbike /etc/nginx/sites-enabled/
  ```

- Comprobar configuración y reiniciar
  ```bash
  sudo nginx -t
  sudo systemctl reload nginx
  ```

- Instalar y configurar MySQL
  ```bash
  sudo apt install mysql-server -y
  sudo mysql
  ```
  ```sql
  CREATE DATABASE gorentbike CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  CREATE USER 'gorentbike_user'@'localhost' IDENTIFIED BY 'Test123!';
  GRANT ALL PRIVILEGES ON gorentbike.* TO 'gorentbike_user'@'localhost';
  FLUSH PRIVILEGES;
  ```

- Importar plantilla de base de datos  
  ```sql
  mysql -u gorentbike_user -p gorentbike < database.sql
  ```


## Variables de entorno
En el archivo .env crear las variables

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:Ja3cMweXfkDD9eI0lJRE0q/074zqWhwYJAzpPuwp4Bw=
APP_DEBUG=false
APP_URL=http://localhost:8000
APP_TIMEZONE=Europe/Madrid

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=gorentbike
DB_USERNAME=gorentbike_user
DB_PASSWORD=Test123!
```
[⬅ Volver al índice](index.md)