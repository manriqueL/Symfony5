
## Requisitos para instalar el proyecto en local
1. Tener instalado Node en versión >= 12.13.0 (node --version para ver la versión actual instalada).
2. Tener PHP > 7.4
3. Tener instalado gulp (npm install -g gulp)

## Tener en cuenta
1. El template funciona con roles.
2. Al seguir los pasos de abajo, se crea un usuario con el rol ROLE_SUPERUSER.
3. No es posible crear nuevos usuarios con dicho rol (a menos que sea por base de datos).
4. Ningún otro usuario podrá modificar, ver o eliminar datos de la cuenta con el rol ROLE_SUPERUSER.
5. No es posible crear un nuevo rol que contenga el string "ROLE_SUPERUSER".

## Setup nuevo proyecto
1. Ejecutar en la consola: cd public/base
2. npm install
3. gulp css
4. Crear la base de datos local
5. **Copiar** el archivo .env.example a .env y adaptar los parámetros para la conexión mysql
6. cd ../../
7. composer install
8. php bin/console doctrine:schema:create
9. php bin/console doctrine:fixtures:load
10. symfony server:start
11. Abrir navegador en la dirección localhost:8000
12. Loguear con credenciales: admin/admin
13. Ir al menú lateral izquierdo -> Administrar -> Roles -> ROLE_SUPERUSER y asignarle todos los permisos necesarios


## Modificación de estilos
Modificar los archivos de la carpeta ubicada en public/base/scss según necesidad.
El archivo _customs.scss contiene modificaciones propias del TSJ y variables claves para customizar el template.
Se recomienda utilizar ese archivo en caso de necesitar agregar código específico.

Una vez modificado los archivos, es necesario realizar las siguientes acciones para que se apliquen los cambios:
1. Moverse a la carpeta: cd public/base
2. Ejecutar: gulp css