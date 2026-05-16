# Arquitectura del Proyecto

## Enfoque general

El proyecto sigue el patrón **MVC (Modelo - Vista - Controlador) con Repositorios y Servicios** sobre Laravel.

Los controladores delegan el acceso a datos en repositorios, que a su vez
utilizan un servicio de base de datos (PDO) con consultas SQL manuales.

Se desarrolla la siguiente estructura:

## Capas principales

### 1. **Modelos**
- Bike
- Maintenance
- Rental
- Reservation
- User

### 2. **Controladores**
Gestionan la lógica de:
- HomeController (página principal)
- AuthController (autenticación)
- BikeController (bicicletas)
- BillingController (facturación)
- CartController (carrito de la compra)
- MaintenanceController (mantenimientos)
- PdfController (exportación de PDF)
- ReservationController (reservas)
- UserController (usuarios)

### 3. **Vistas**
Desarrolladas con Blade, incluyen:
- _layouts (plantillas)
- _partials (vistas reutilizables)
- auth (login y registro)
- bike (inicio, parcial de datos, creación y modificación)
- billing (inicio, parcial de datos)
- cart (inicio, confirmación)
- home (inicio, parcial de datos)
- legal (quienes somos, privacidad, contacto, cookies)
- maintenance (inicio, parcial de datos, creación y modificación)
- reservation (inicio, parcial de datos y supervisión)
- user (inicio, parcial de datos y modificación)

### 3. **Repositorios**
Encapsulan el acceso a la base de datos, separando las consultas SQL de los controladores:
- AuthRepository (login y registro)
- BikeRepository (bicicletas)
- BillingRepository (ingresos, gastos y movimientos)
- MaintenanceRepository (mantenimientos)
- ReservationRepository (reservas y alquileres)
- UserRepository (usuarios)

### 4. **Servicios**
- Database — PDO que proporciona los métodos `query()` y `execute()` con sentencias preparadas.


## Roles de usuario

| Rol | Permisos |
|-----|----------|
| Cliente | Ver catálogo, alquilar, consultar reservas |
| Técnico | Registrar mantenimientos, registrar supervisiones |
| Facturación | Consultar datos económicos |
| Administrador | Gestión completa del sistema |

 ## Diseño responsive
Se ha desarrollado con el enfoque "Mobile First" y se utilizan media queries para adaptar la visualización a:
- Escritorio
- Tablet

## Tecnologías utilizadas

| Tecnología        | Función en el proyecto |
|------------------|-------------------------|
| **Laravel**      | Framework principal basado en MVC. Gestiona rutas, controladores y modelos. |
| **PHP 8.2**      | Lenguaje backend que ejecuta la aplicación y la lógica del servidor. |
| **MySQL**        | Base de datos relacional para almacenar usuarios, bicicletas, reservas y mantenimientos. |
| **Blade**		   | Motor de plantillas para generar vistas dinámicas y reutilizables. |
| **HTML5**        | Estructura semántica del contenido de la aplicación. |
| **CSS3**         | Estilos, diseño visual y adaptación responsive. |
| **JavaScript**   | Interactividad en el frontend (menús, validaciones, componentes dinámicos). |
| **Font Awesome** | Iconografía para mejorar la interfaz y la experiencia de usuario. |
| **Composer**     | Gestión de dependencias PHP y paquetes de Laravel. |
| **jQuery 4.0**     | Biblioteca JavaScript para manipular el DOM de forma simple. |
| **Chart.js**     | Creación gráficos. |
| **Dompdf**     | Generador de PDF |


[⬅ Volver al índice](index.md)




