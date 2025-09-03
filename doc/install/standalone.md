# Standalone

1. Clone project
2. Php-fpm
3. Nginx
4. Postgresql

## 1. Clone project

1. Enter to `nginx` `html` folder and clone project `git clone https://github.com/Romchik38/site2.git`

2. Install dep `composer install`

## 2. Php-fpm

Site 2 based on `php 8.4`. Install `Php-fpm` with next extensions:

- pgsql
- GD

As additional you can install `xdebug` for developing.

## 3. Nginx

I have prepared [simple.conf](./../../nginx/simple.conf) that might help to configure nginx server. Please, edit it, with your configurations. So:

1. Copy `simple.conf` to your nginx `/etc/nginx/conf.d`
2. Look at the file and edit if necessary

## 4. Postgresql

Site2 uses Postgresql version 17. You must proceed next steps to run programm:

1. Install and configure your `Postgresql` mannualy.
2. Create database `site2`
3. Add database info from last dump file.
4. Place config file to [database.php](./../../app/config/private/)
5. Install dictionaries for full text search

### 4.1. Install and configure your `Postgresql` mannualy

You must install, update and configure your database by yourself. If you don't know what to do, familiarize yourself with the [database documentation](https://www.postgresql.org/).

### 4.2. Create database `site2`

Use [script](./../../docker/postgres/scripts/database.sql) to create a database `site2`

`psql -U postgres < database.sql`

### 4.3. Add database info from last dump file

`psql -U postgres -d site2 < site2.sql`

### 4. Place config file to [database.php](./../../app/config/private/)

After project's cloning:

1. create `private` folder inside `app/config/`. File `.gitignore` has detective to ignore this.
2. create file `database.php` inside `private` with similar code:

    ```php
    <?php

    declare(strict_types=1);

    return [
        'database.postgres.connect.main' => 'host=postgres dbname=site2 user=postgres password=Change_it'
    ];
    ```

Please, edit the code above to your configuration.
Read more about [connect settings](https://www.php.net/manual/en/function.pg-connect.php)
