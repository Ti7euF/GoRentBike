# Arquitectura del Proyecto

## Enfoque general

El proyecto sigue el patrón **MVC (Modelo - Vista - Controlador)** proporcionado por Laravel.

Aunque la arquitectura está en desarrollo, se plantea la siguiente estructura:

## Capas principales

### 1. **Modelos**
- NSNC

### 2. **Controladores**
Gestionarán la lógica de:
- Home (página principal)
- Auth (autenticación)

### 3. **Vistas**
Desarrolladas con Blade, incluirán:
- NSNC

## Roles de usuario

| Rol | Permisos |
|-----|----------|
| Cliente | Ver catálogo, alquilar, consultar reservas |
| Técnico | Registrar mantenimientos |
| Facturación | Consultar datos económicos |
| Administrador | Gestión completa del sistema |

 ## Diseño responsive
Se desarrolla con el enfoque "Mobile First" y se utilizan media queries para adaptar la visualización a:
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


[⬅ Volver al índice](index.md)




