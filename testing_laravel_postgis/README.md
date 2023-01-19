
setup ubuntu22.04 server LTS


install php & postgis
```
$ sudo apt install vim git unzip -y
#$ sudo apt install apache2 -y
$ sudo apt install php -y

# for laravel, php-zipは別件用
$ sudo apt install php-curl php-xml php-pgsql php-zip -y

$ sudo apt install wget curl gnupg2 software-properties-common apt-transport-https -y
$ wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -
$ echo "deb http://apt.postgresql.org/pub/repos/apt/ `lsb_release -cs`-pgdg main" |sudo tee  /etc/apt/sources.list.d/pgdg.list
$ sudo apt install postgis postgresql-14-postgis-3 -y
```

log
```
Creating new PostgreSQL cluster 14/main ...
/usr/lib/postgresql/14/bin/initdb -D /var/lib/postgresql/14/main --auth-local peer --auth-host scram-sha-256 --no-instructions
The files belonging to this database system will be owned by user "postgres".
This user must also own the server process.

The database cluster will be initialized with locale "C.UTF-8".
The default database encoding has accordingly been set to "UTF8".
The default text search configuration will be set to "english".
```

edit conf files
```
$ sudo vi /etc/postgresql/14/main/postgresql.conf
listen_addresses = '*'
```

```
$ sudo vi /etc/postgresql/14/main/pg_hba.conf
local   all             postgres                                trust
local   all             all                                     trust
host    all             all             127.0.0.1/32            trust
host    all             all             ::1/128                 trust
host    all             all             0.0.0.0/0               trust
```


create db on main cluster.
```
createdb -U postgres -E UTF-8 map -T template0
psql -U postgres -d map -c "CREATE EXTENSION postgis;"
psql -U postgres -d map -c "CREATE EXTENSION postgis_topology;"
```

```
$ psql -U postgres -d map
map=# select postgis_full_version();

                                   postgis_full_version
-------------------------------------------------------------------------------------------------------
 POSTGIS="3.2.0 c3e3cc0" [EXTENSION] PGSQL="140" GEOS="3.10.2-CAPI-1.16.0" PROJ="8.2.1" LIBXML="2.9.12" LIBJSON="0.15" LIBPROTOBUF="1.3.3" WAGYU="0.5.0 (Internal)" TOPOLOGY
(1 row)
```

install composer
```
$ curl -sS https://getcomposer.org/installer -o composer-setup.php
yamamoto@yamamoto:~$ sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
All settings correct for using Composer
Downloading...

Composer (version 2.3.10) successfully installed to: /usr/local/bin/composer
Use it: php /usr/local/bin/composer

$ composer --version
Composer version 2.3.10 2022-07-13 15:48:23
```


```
composer create-project laravel/laravel softmap
```

require laravel-postgis inside new project
```
cd softmap
composer require mstaack/laravel-postgis
```

start debugging
```
php artisan serve --host 0.0.0.0
```

add the DatabaseServiceProvider to config/app.php
```
    'providers' => [

        (snip),

        MStaack\LaravelPostgis\DatabaseServiceProvider::class,

    ],

```

edit .env file
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=map
DB_USERNAME=postgres
DB_PASSWORD=
```

tutorial
```
php artisan make:model Location
php artisan make:migration create_locations_table
php artisan make:controller LocationController
```

```
php artisan migrate
php artisan migrate:rollback
```



[create table先のschema変更]

* pgsql driverを二つ変える
  * 同時に2つのconnectionはできないのでトランザクションできなくて採用できないか


dynamic table create
```
$ php artisan make:migration create_pool_schema
$ php artisan make:controller UpperController
$ php artisan make:migration create_meta_table
```


eloquent
```
$ php artisan make:model Location
```


# could not find driver => php-pgsql

```
$ php artisan migrate

   Illuminate\Database\QueryException

  could not find driver (SQL: select * from information_schema.tables where table_catalog = map and table_schema = public and table_name = migrations and table_type = 'BASE TABLE')
```


# reference

laravel
https://laravel.com/docs/9.x

laravel postgis
https://github.com/mstaack/laravel-postgis

laravel api
https://laravel.com/api/9.x/Illuminate/Database/Connection.html
