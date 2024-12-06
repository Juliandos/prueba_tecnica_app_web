
# Cocktail Web Application

## Introducción
Este proyecto es una aplicación web que permite agregar y gestionar cocktails a través de una base de datos utilizando datos obtenidos de la API pública de TheCocktailDB (https://www.thecocktaildb.com/api.php). La aplicación proporciona una interfaz fácil de usar para interactuar con la API, agregar cocktails a la base de datos, y permitir la edición y eliminación de cocktails ya existentes.

Además, los usuarios pueden iniciar sesión y cerrar sesión en la plataforma para gestionar sus datos de manera segura. El sistema está optimizado para dispositivos móviles gracias al uso de Bootstrap 5.

## Tecnologías Usadas
- **Laravel**: El framework backend utilizado para gestionar las rutas, controladores y la base de datos.
- **SQLite**: Base de datos ligera utilizada para almacenar los cocktails y la información del usuario.
- **jQuery**: Biblioteca de JavaScript utilizada para manejar la interacción asincrónica y la manipulación del DOM.
- **DataTables**: Plugin de jQuery utilizado para gestionar y visualizar los datos en tablas de forma interactiva.
- **SweetAlert2**: Librería para mostrar alertas y confirmaciones personalizadas de manera visualmente atractiva.
- **Bootstrap 5**: Framework CSS para la creación de interfaces responsivas y modernas.

## Características de la Aplicación
- **Obtención de Datos desde una API**: La aplicación obtiene información sobre cocktails desde la API pública de TheCocktailDB, permitiendo agregar estos datos a la base de datos del sistema.
- **Agregación de Datos a una Base de Datos**: Los usuarios pueden agregar nuevos cocktails a la base de datos desde la interfaz de usuario.
- **Eliminación de Cocktails**: Los usuarios pueden eliminar cocktails existentes de la base de datos a través de la interfaz de usuario.
- **Edición de Cocktails**: Los usuarios pueden editar los detalles de un cocktail existente, como nombre, categoría y más.
- **Inicio de Sesión**: Los usuarios pueden registrarse y acceder a la plataforma para gestionar sus cocktails de manera segura.
- **Cierre de Sesión**: Los usuarios pueden cerrar sesión para proteger su cuenta y mantener la seguridad en la plataforma.

## Instalación

### Requisitos previos:
Asegúrate de tener instalados los siguientes programas en tu máquina:
- PHP (versión 8.x o superior)
- Composer (gestor de dependencias de PHP)
- SQLite (base de datos)

### Pasos para instalar:
1. Clona el repositorio en tu máquina:
   ```bash
   git clone https://github.com/usuario/cocktail-web-app.git
   ```

2. Navega al directorio del proyecto:
   ```bash
   cd cocktail-web-app
   ```

3. Instala las dependencias de Laravel usando Composer:
   ```bash
   composer install
   ```

4. Copia el archivo de configuración `.env`:
   ```bash
   cp .env.example .env
   ```

5. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

6. Configura la base de datos SQLite editando el archivo `.env`:
   ```plaintext
   DB_CONNECTION=sqlite
   DB_DATABASE=/ruta/a/tu/base_de_datos.sqlite
   ```

7. Ejecuta las migraciones de la base de datos:
   ```bash
   php artisan migrate
   ```

8. Inicia el servidor local:
   ```bash
   php artisan serve
   ```

Accede a la aplicación en [http://localhost:8000](http://localhost:8000).

## Ejecución

Una vez completados los pasos de instalación, puedes acceder a la aplicación a través de tu navegador en la URL [http://localhost:8000](http://localhost:8000). La aplicación te permitirá interactuar con la base de datos de cocktails, desde agregar nuevos cocktails hasta editar o eliminar los existentes.

1. En la página principal, puedes ver una lista de los cocktails existentes.
2. Usando la barra de navegación, puedes acceder a las opciones de agregar un cocktail o iniciar sesión.
3. Al iniciar sesión, tendrás acceso a funciones adicionales como la edición y eliminación de cocktails.

## Capturas de Pantalla

A continuación se muestran algunas capturas de pantalla de la aplicación:

1. **Pantalla de inicio de sesión**
   ![Login Screen](./screenshots/login.png)

2. **Vista de la lista de cocktails**
   ![Cocktails List](./screenshots/cocktails_list.png)

3. **Formulario para agregar un nuevo cocktail**
   ![Add Cocktail](./screenshots/add_cocktail.png)

4. **Modal de confirmación para eliminar un cocktail**
   ![Delete Confirmation](./screenshots/delete_confirmation.png)
