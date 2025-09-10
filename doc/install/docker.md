# Docker install

Launching with Docker is intended for `development purposes only`. If you wish to use Docker to demonstrate the website externally, please make the necessary changes yourself.

File structure:

- [compose.yaml](./../../compose.yaml)
- [nginx folder](./../../docker/nginx/)
- [php-fpm folder](./../../docker/php-fpm/)
- [postgresql folder](./../../docker/postgres/)

Content:

1. Clone project
2. Read all docs
3. Nginx
4. Php-fpm
5. Postgresql

## 1. Clone project

Enter to `any folder from your disk` and clone the project `git clone https://github.com/Romchik38/site2.git`

## 2. Read all docs

Please read all `readme.md` files in folders above.

## 3. Nginx

Docker will copy `docker/nginx/conf.d/default.conf` to container. So edit it with your configuration.

## 4. Php-fpm

Look at the [readme](./../../docker/php-fpm/readme.md)

1. After `docker compose up -d --build` is executed, inside a container `app` folder run `composer install`

2. Create `var` folder inside `app` to log. File `file.log` will be created auto on the first error.

## 5. Postgresql

Look at [readme](./../../docker/postgres/readme.md)
