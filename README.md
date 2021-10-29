
## Requisitos para instalar el proyecto en local
1. Tener instalado Node en versión >= 12.13.0 (node --version para ver la versión actual instalada).
2. Tener PHP > 7.2


## Setup nuevo proyecto
1. Ejecutar en la consola: cd public/base
2. npm install
3. Crear la base de datos local
4. **Copiar** el archivo .env.example a .env y adaptar los parámetros para la conexión mysql
5. composer require "ext-gd:*" --ignore-platform-reqs
6. php bin/console doctrine:schema:create
7. php bin/console doctrine:fixtures:load
8. symfony server:start
9. Abrir navegador en la dirección localhost:8000/admin
10. Loguear con credenciales: admin/admin
11. Ir al menú lateral izquierdo -> Administrar -> Roles -> ROLE_SUPERUSER y asignarle todos los permisos necesarios


## Modificación de estilos
Modificar los archivos de la carpeta ubicada en public/base/scss según necesidad.
El archivo _customs.scss contiene modificaciones propias del TSJ y variables claves para customizar el template.
Se recomienda utilizar ese archivo en caso de necesitar agregar código específico.

Una vez modificado los archivos, es necesario realizar las siguientes acciones para que se apliquen los cambios:
1. Moverse a la carpeta: cd public/base
2. Ejecutar: gulp css