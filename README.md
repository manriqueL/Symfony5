
## Requisitos para instalar el proyecto en local
1. Tener instalado Node en versión >= 12.13.0 (node --version para ver la versión actual instalada).
2. Tener PHP > 7.2


## Setup nuevo proyecto
1. Crear la base de datos local
2. **Copiar** el archivo .env.example a .env y adaptar los parámetros para la conexión mysql
3. composer require "ext-gd:*" --ignore-platform-reqs
4. php bin/console doctrine:schema:create
5. php bin/console doctrine:fixtures:load
6. symfony server:start
7. Abrir navegador en la dirección localhost:8000/admin
8. Loguear con credenciales: admin/admin
9. Ir al menú lateral izquierdo -> Administrar -> Roles -> ROLE_SUPERUSER y asignarle todos los permisos necesarios