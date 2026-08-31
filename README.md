# IRAB - Sistema de Enfermería

Proyecto hecho en grupo por alumnos de 3er año de la Tecnicatura en Análisis y Desarrollo de Software.

Construido con [CodeIgniter 4](https://codeigniter.com) (PHP) + MySQL/MariaDB (XAMPP).

## Requisitos

- XAMPP con PHP **8.2+** (probado con PHP 8.2.12) y MySQL/MariaDB.
- Extensiones de PHP habilitadas: `intl`, `mbstring`, `json`, `mysqlnd`, `curl` (XAMPP las trae activadas por defecto).
- [Composer](https://getcomposer.org/) instalado y disponible en el PATH.

## Instalación (primera vez)

1. Clonar el repo dentro de `htdocs`:
   ```
   cd C:\xampp\htdocs
   git clone <url-del-repo> irab
   cd irab
   ```

2. Instalar las dependencias de PHP (esto genera la carpeta `vendor/`, que **no** se sube al repo):
   ```
   composer install
   ```

3. Crear el archivo de entorno local a partir de la plantilla:
   ```
   copy env .env
   ```
   Editar `.env` y completar:
   - `CI_ENVIRONMENT = development`
   - `app.baseURL = 'http://localhost/irab/public/'`
   - `database.default.hostname = localhost`
   - `database.default.database = enfermeria_irab`
   - `database.default.username = root`
   - `database.default.password =` (vacío por defecto en XAMPP)
   - `database.default.DBDriver = MySQLi`

4. Generar la clave de encriptación de la app (solo una vez, cada dev tiene la suya):
   ```
   php spark key:generate
   ```

5. Levantar MySQL desde el Panel de Control de XAMPP e importar el esquema de la base de datos:
   - Vía phpMyAdmin: crear la base y ejecutar el script `database/enfermeria_irab.sql`.
   - Vía consola:
     ```
     C:\xampp\mysql\bin\mysql -u root -e "source C:/xampp/htdocs/irab/database/enfermeria_irab.sql"
     ```
   El script crea la base `enfermeria_irab` y todas sus tablas si no existen.

6. Levantar Apache (XAMPP) y entrar a:
   ```
   http://localhost/irab/public/
   ```
   Alternativa sin Apache, usando el servidor de desarrollo de CodeIgniter:
   ```
   php spark serve
   ```
   (en ese caso usar `app.baseURL = 'http://localhost:8080/'` en el `.env`)

## Notas del repositorio

- `vendor/` y `.env` están en `.gitignore` y **no se commitean**. Cada persona corre `composer install` y arma su propio `.env` (paso 2 y 3).
- `composer.lock` sí se commitea: garantiza que todo el equipo instale las mismas versiones de dependencias.
- El esquema SQL de referencia vive en [`database/enfermeria_irab.sql`](database/enfermeria_irab.sql).
- Si se agregan cambios de esquema, actualizar ese archivo (o migrar a CodeIgniter Migrations más adelante) para que quede versionado junto al código.

## Estructura

Instalación estándar de `codeigniter4/appstarter` (v4.7). Controllers, Models y Views del dominio de enfermería van en `app/Controllers`, `app/Models`, `app/Views` respectivamente.
