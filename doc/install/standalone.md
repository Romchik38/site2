# Standalone

1. Clone project
2. Php-fpm
3. Nginx
4. Postgresql

## 1. Clone project

- Enter to nginx html folder and clone project `git clone https://github.com/Romchik38/site2.git`

## 2. Php-fpm

Site 2 based on php 8.4. Install `Php-fpm` with next extensions:

- pgsql
- GD

As additional you can install `xdebug` for developing.

## 3. Nginx

I have prepared [simple.conf](./../../nginx/simple.conf) that might help to configure nginx server. Please, edit it, with your configurations.

## 4. Postgresql

Site2 uses Postgresql version 17. You must proceed next steps to run programm:

1. Create database `site2`
2. Add database info from last dump file.
3. Place config file to [database.php](./../../app/config/private/)
4. Install dictionaries for full text search