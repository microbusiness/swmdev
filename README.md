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

http://swm.plto.ru/api/users?geo_location[nw][lat]=10&geo_location[nw][lng]=10&geo_location[se][lat]=-10&geo_location[se][lng]=-10&age[from]=18&age[to]=50&gender=male&hobby[]=football&hobby[]=snowboarding