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

http://domain.tld/api/users?geo_location[nw][lat]=52.57&geo_location[nw][lng]=3.76&geo_location[se][lat]=52.13&geo_location[se][lng]=6.06&age[from]=18&age[to]=24&gender=male&hobby[]=football&hobby[]=snowboarding