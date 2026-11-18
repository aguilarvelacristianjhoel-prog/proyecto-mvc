# Proyecto MVC + ORM ligero — Facultad y Docente

Proyecto original adaptado a las tablas `facultad` y `docente` de `evaluacion_daw2`, manteniendo la estructura MVC, las librerías de acceso PDO y las rutas.

## Instalación
1. Coloca la carpeta `PROYECTO_PRACTICA_MVC_ORM` dentro de `htdocs`.
2. Importa `evaluacion_daw2.sql` en phpMyAdmin, seleccionando/creando la base `evaluacion_daw2` si es necesario.
3. Configura host, puerto, usuario y contraseña en `Config/Config.php` según tu MySQL. La configuración existente se conserva.
4. En `Config/Config.php`, ajusta `BASE_URL` si cambias el nombre de la carpeta.
5. Accede a `http://localhost/PROYECTO_PRACTICA_MVC_ORM/`.

## Módulos
- Facultad: id, nombre, abreviatura y estado (altas, modificaciones y desactivación lógica).
- Docente: id, id_facultad, dni, apellidos, nombres, correo, categoria, dedicacion y estado.
- Relación de docente con facultad mediante llave foránea.
- Categorías: AUXILIAR, ASOCIADO, PRINCIPAL.
- Dedicaciones: DEDICACION EXCLUSIVA-DE, TIEMPO COMPLETO-TC, TIEMPO PARCIAL-TP.

No se altera el núcleo de la arquitectura MVC/ORM ligero. Requiere PHP con PDO MySQL y mbstring, Apache y MariaDB/MySQL. El aplicativo requiere autenticación antes de uso público.
