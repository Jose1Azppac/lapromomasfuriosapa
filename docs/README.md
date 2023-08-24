# Dinamica "La promo mas furiosa"


## Installation

#### El sitio esta desarrollado bajo el framework laravel.

#### Copiar la carpeta html a la raiz o carpeta donde vaya a quedar el desarrollo. (html/) o (html/carpeta).

#### Una vez copiada la carpeta, ejecutar el siguiente comando SSH.

```bash
$ composer update o composer install
```

#### Crear en raiz de la aplicación un archivo llamado .env el cual contendrá la configuración de las variables de entorno de la aplicación y debe ser basado en el archivo .env.example (en este archivo viene toda la configuracion del sitio) que se encuentra en raiz.

##### A continuación dejo las variables que deberán actualizar:

- APP_DEBUG=false

- APP_URL=https://dominio.com/carpeta/

- ASSET_URL=https://dominio.com/carpeta/

- MAIL_TO_SEND_CONTACT= contactopa@promocionesfritolay.com (correo confirmado por marca)


#### Crear una instancia de base de datos Mysql, una vez creada actualizar el archivo .env con los datos requeridos, posterior ejecutar el siguiente comando SSH. 

```bash
$ php artisan migrate --seed 
```

#### Modificar las variables de entorno para la conexión a la base de datos Mysql.

- DB_CONNECTION=mysql
- DB_HOST=localhost
- DB_PORT=3306
- DB_DATABASE=DBname
- DB_USERNAME=DBuser
- DB_PASSWORD=DBpassword

#### Modificar las variables de entorno para el envío de Mail (entiendo que estas se cambian hasta que el desarrollo se encuentra en PROD, en ser así dejar las que están por el momento para DEV).

  - MAIL_MAILER=smtp 
  - MAIL_HOST=ip-or-host-smtp-service 
  - MAIL_PORT=587 
  - MAIL_USERNAME=user-smtp 
  - MAIL_PASSWORD=password-smtp 
  - MAIL_ENCRYPTION=null 
  - MAIL_FROM_ADDRESS=mail-sender
  - MAIL_FROM_NAME="La promo mas furiosa"

#### Ejecutar el siguiente comando SSH
```bash
$ php artisan storage:link
```
-
-
#### Modificar la variable de entorno siguiente (actualizada en el .env.example) con el ENDPOINT de la API correspondiente de acuerdo al ambiente donde se este instalando el sitio.

- API_MONGO

```
- DEV: https://zkwxumpjdtkltajrkonmtcmws.pepmx.com
- STG: https://stg-zkwxumpjdtkltajrkonmtcmws.pepmx.com
- PROD: https://zkwxumpjdtkltajrkonmtcmws.lapromomasfuriosa.com
```
-
-
### Configuracion extra
###### Por cuestiones de seguridad es necesario configurar las siguientes cabeceras en los distintos entornos.
-
```bash
- Header always set Strict-Transport-Security "max-age=63072000; includeSubdomains;"
- Header set Content-Security-Policy "frame-ancestors 'self';"
- Header always set X-Frame-Options "SAMEORIGIN"
- Header set Access-Control-Allow-Headers "Cookie, accept, origin, x-request, Content-Type, Accept, X-Requested-with, withCredentials, Authorization, client-security-token"
- Header set X-XSS-Protection "1; mode=block"
- Header set Access-Control-Allow-Credentials "true"
- Header set P3P 'CP="CURa ADMa DEVa TAIi PSAi PSDi IVAi IVDi CONi HISa TELi OUR IND DSP CAO COR"'
- Header set Access-Control-Allow-Origin "*"
```