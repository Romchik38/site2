# Standalone

1. Clone project
2. Php-fpm
3. Nginx
4. Postgresql
5. Directories and permissions
6. Check frontend
7. Check backend

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
2. Install dictionaries for full text search
3. Create database `site2`
4. Add database info from last dump file.
5. Place config file to [database.php](./../../app/config/private/)

### 4.1. Install and configure your `Postgresql` mannualy

You must install, update and configure your database by yourself. If you don't know what to do, familiarize yourself with the [database documentation](https://www.postgresql.org/).

### 4.2. Install dictionaries for full text search

1. Move dictionaries from `docker/postgres/dict` to you postgres `tsearch_data` dir. For example - `/usr/share/pgsql/tsearch_data` is relevant in `Fedora42`.
2. run sql script `sql/uk-dict/dictionary.sql`
    `psql -U postgres -d site2 < dictionary.sql

### 4.3. Create database `site2`

Use [script](./../../docker/postgres/scripts/database.sql) to create a database `site2`

`psql -U postgres < database.sql`

### 4.4. Add database info from last dump file

`psql -U postgres -d site2 < site2.sql`

### 4.5 Place config info to [database.php](./../../app/config/private/)

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

## 5. Directories and permissions

### 5.1 Selinux

cd /full_path_to/site2_folder
restorecon -R .

### 5.2 Config var/ folder

Creating a `var/` directory for logging and assigning write permissions to it for the service. Adding a SELinux rule so that the service can create and edit the log file. The log file will be created automatically upon first recording.

```bash
cd /full_path_to/site2_folder
mkdir app/var/
sudo semanage fcontext -a -t httpd_sys_rw_content_t "/full_path_to/site2_folder/app/var(/.*)?"
sudo restorecon -R .
sudo chown user_name:service_name app/var/
chmod g=rwx app/var/
```

## 6. Check frontend

- Visit `/` url. It should redirect to `/en` or `/uk` based on your browser config.
- Check search by placed query to search field and pressing next to it button.
- visit `/login` page

Read [frontend login](./../frontend/login.md) section.

## 7. Check backend

To check backend

- login into system `/login/admin`
- you will be redirected to `/admin`

Read [admin login](./../admin/readme.md) section.
