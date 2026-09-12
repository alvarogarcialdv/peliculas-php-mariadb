# Películas PHP + MariaDB

Aplicación educativa para practicar el despliegue tradicional de una aplicación web. Permite listar, buscar, consultar, crear, editar y eliminar películas. Está desarrollada con PHP, PDO, MariaDB y plantillas HTML, sin framework ni Composer.

## Requisitos

- PHP 8.4 o posterior con las extensiones `pdo_mysql` y `mbstring`, y soporte de sesiones.
- MariaDB con InnoDB y `utf8mb4`.
- Cliente `mariadb` o un panel que permita importar archivos SQL.

## Preparación de MariaDB

Crea una base y un usuario local. Sustituye la contraseña de ejemplo:

```sql
CREATE DATABASE peliculas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'peliculas'@'127.0.0.1' IDENTIFIED BY 'SUSTITUIR_POR_UNA_CLAVE_LOCAL';
GRANT SELECT, INSERT, UPDATE, DELETE ON peliculas.* TO 'peliculas'@'127.0.0.1';
```

Importa el esquema con una cuenta que pueda crear tablas y carga una sola vez los doce clásicos de aventuras, fantasía y ciencia ficción:

```bash
mariadb -u root -p peliculas < base-datos/esquema.sql
mariadb -h 127.0.0.1 -u peliculas -p peliculas < base-datos/datos-iniciales.sql
```

## Configuración

`.env.example` enumera las variables necesarias, pero PHP no carga archivos `.env` automáticamente. El código consume `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` y `DB_PASSWORD`. `APP_PORT` se usa en el comando de desarrollo. `APP_ENV` queda disponible para el entorno, pero no altera el comportamiento actual.

En Bash:

```bash
export APP_ENV=desarrollo
export APP_PORT=8000
export DB_HOST=127.0.0.1
export DB_PORT=3306
export DB_NAME=peliculas
export DB_USER=peliculas
read -rsp 'Contraseña de MariaDB: ' DB_PASSWORD
export DB_PASSWORD
```

No guardes contraseñas reales en el repositorio.

## Ejecución local

Desde la raíz del proyecto, inicia el servidor de desarrollo:

```bash
php -S "127.0.0.1:${APP_PORT}" -t publico servidor.php
```

Abre `http://127.0.0.1:8000/peliculas`. `GET /salud` comprueba la conexión con MariaDB y devuelve `200` si está disponible o `503` si falla.

En Apache, configura `publico/` como raíz web, habilita `mod_rewrite` y permite las reglas de `publico/.htaccess`. En hosting compartido, mantén `src/`, `configuracion/` y `vistas/` fuera de la raíz pública siempre que el proveedor lo permita. La aplicación está preparada para publicarse en la raíz del dominio.

## Pruebas

Comprueba la sintaxis y la validación sin instalar dependencias:

```bash
find . -name '*.php' -not -path './vendor/*' -exec php -l {} \;
php pruebas/validacion.php
```

La prueba de persistencia necesita una base exclusiva de pruebas con `base-datos/esquema.sql` importado y las variables `DB_*` apuntando a ella:

```bash
php pruebas/base-datos.php
```

La prueba crea datos dentro de una transacción y ejecuta `rollback`; el contador de identificadores puede avanzar. No la ejecutes contra datos reales.

## Sesiones y seguridad

Los formularios usan sesiones PHP para los tokens CSRF y los mensajes de confirmación. El servidor debe conservar la sesión entre peticiones. Con varias instancias, se necesitaría almacenamiento de sesiones compartido o afinidad de sesión; esta entrega no incorpora esas soluciones. Las consultas usan parámetros preparados y las salidas HTML se escapan.

No se incluye una licencia en esta entrega.
