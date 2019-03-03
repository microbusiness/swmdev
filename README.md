Postgres and PostGis already installed

Create database with name and write database access in .env

DB_CONNECTION=pgsql

DB_HOST=127.0.0.1

DB_PORT=5432

DB_DATABASE={database name}

DB_USERNAME={DB user}

DB_PASSWORD={DB password}

-----------------------------
php artisan migrate

-----------------------------

php artisan db:seed

-----------------------------

Test route

No validation for bbox coordinates

http://swm.plto.ru/api/users?geo_location[nw][lat]=50&geo_location[nw][lng]=50&geo_location[se][lat]=-50&geo_location[se][lng]=-50&age[from]=18&age[to]=50&gender=female&hobby[]=football&hobby[]=snowboarding

-----------------------------
DEMO - http://swm.plto.ru/

First click - first point set,
 
second click - set second point, calculate coordinates for users and show

next click - clear map 