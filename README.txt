JAMBO – Sitio administrable en PHP (MySQL)
=========================================

1) Requisitos
   - PHP 8+
   - Extensión PDO MySQL habilitada
   - Servidor Apache (para .htaccess) o usa `php -S` en desarrollo
   - MySQL/MariaDB con una base `jambo_site` creada

2) Configura credenciales
   - Edita `config.php` y coloca host/usuario/contraseña correctos de MySQL.

3) Inicializa la base de datos
   - Inicia servidor: `php -S localhost:8000`
   - Abre: `http://localhost:8000/init_db.php` (se crearán tablas + seeds)

4) Accede al sitio
   - Público: `http://localhost:8000/`
   - Admin:   `http://localhost:8000/admin/login`
     Usuario: admin  |  Clave: 123456  (cámbiala más adelante en DB)

5) Cambios clave
   - Ajustes del sitio (nombre, logo, colores): /admin/ajustes
   - CRUD de servicios: /admin/servicios
   - Detalle de servicio abre en nueva pestaña desde /servicios

6) Despliegue en hosting
   - Sube todo el contenido del ZIP a la carpeta pública del hosting.
   - Asegúrate de que `.htaccess` esté permitido.
   - Crea la base `jambo_site` y un usuario con permisos.
   - Ajusta `config.php`.

