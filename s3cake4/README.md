
debugKitがつかいそうなのでsqlite3拡張を追加してみる
```
$ sudo apt install php-sqlite3
```

composerでcreate-project
```
$ sudo composer self-update
$ composer clearcache
$ composer create-project --prefer-dist cakephp/app:4.* s3cake4
```
通信の問題でパッケージの展開が失敗するところがあればcomposer updateを追加
```
$ cd s3cake4
$ composer update
```
aws sdkを追加
```
$ composer require aws/aws-sdk-php
```

# CakePHP Application Skeleton

A skeleton for creating applications with [CakePHP](https://cakephp.org) 4.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

他のホストからのアクセスを許可して
```bash
$ bin/cake server -H 0.0.0.0
```


Then visit `http://localhost:8765` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit the environment specific `config/app_local.php` and setup the 
`'Datasources'` and any other configuration relevant for your application.
Other environment agnostic settings can be changed in `config/app.php`.

app.php
```
    'Datasources' => [
        'default' => [
            'className' => Connection::class,
            'driver' => Postgres::class,
            'persistent' => false,
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'className' => Connection::class,
            'driver' => Postgres::class,
            'persistent' => false,
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
        ],
    ],
```
app_local.php
```
    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            'username' => 'postgres',
            //'password' => 'secret',
            'database' => 'tracea',
            'url' => env('DATABASE_URL', null),
        ],
        'test' => [
            'host' => 'localhost',
            'username' => 'postgres',
            'database' => 'tracea',
            'url' => env('DATABASE_TEST_URL', null),
        ],
    ],

...

    // never commit
    'AWS_REGION_CODE' => 'region code',
    'AWS_BUCKET_NAME' => 'bucket name',
    'AWS_ACCESS_KEY_ID' => 'key id',
    'AWS_SECRET_ACCESS_KEY' => 'access key',

```
## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.
