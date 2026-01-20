1) Clonar el repositorio
git clone https://github.com/tu-usuario/gestion-biblioteca.git
cd gestion-biblioteca

2) Instalar dependencias
composer install

3)  Configurar el archivo .env

Copia el archivo de ejemplo:

cp .env.example .env


Configura la conexión a PostgreSQL:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=biblioteca
DB_USERNAME=postgres
DB_PASSWORD=tu_password

4)  Generar la clave de la aplicación
php artisan key:generate


5)  Ejecutar migraciones
php artisan migrate

 Opcional (solo desarrollo):
Para borrar y recrear toda la base de datos:

php artisan migrate:fresh


6)  Ejecutar seeders (datos de prueba)
php artisan db:seed


O un seeder específico:

php artisan db:seed --class=UsuarioSeeder


7)  Levantar el servidor
php artisan serve


La aplicación estará disponible en:

http://127.0.0.1:8000

8) Endpoints principales (API)
 Libros
Método	Endpoint	Descripción
GET	/api/libros	Listar libros
GET	/api/libros/{id}	Ver libro por ID
POST	/api/libros	Crear libro
PUT	/api/libros/{id}	Actualizar libro

9) Usuarios
Método	Endpoint
GET	/api/usuarios
POST	/api/usuarios

10) Préstamos
Método	Endpoint
POST	/api/prestamos
PATCH	/api/prestamos/{id}


11) Ejemplo JSON para crear un préstamo
{
  "usuario_id": 1,
  "libro_id": 2,
  "fecha_prestamo": "2026-01-19",
  "fecha_devolucion_estimada": "2026-02-02",
  "estado": "activo"
}

12) Relaciones del sistema

Un autor puede tener muchos libros (Many to Many)

Un libro puede tener varios autores

Un usuario puede tener muchos préstamos

Un préstamo pertenece a un usuario y a un libro



13) Buenas prácticas aplicadas

Eager Loading (with()) para evitar N+1 Problem

Validaciones con Form Request

Uso de migraciones y seeders

API REST estructurada

PostgreSQL como motor de base de datos


14) Autor

Tu Nombre
 Email: juan.zapata.giraldo25@gmail.com

 GitHub: https://github.com/juan-z-04  





