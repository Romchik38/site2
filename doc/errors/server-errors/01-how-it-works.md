# How it works

1. Nginx send a request to php-fpm service
2. Php-fpm process index.php
3. Index.php starts [Default server](https://github.com/Romchik38/server/blob/master/src/Servers/Http/DefaultServer.php)
4. Default server process the request
5. Executes [server error controller](./02-server-error-controller.md) ([controller](https://github.com/Romchik38/server/blob/master/src/Controllers/Controller.php)) on error
6. Variant 1 - controller works
7. Variant 2 - controller not works

## 4. Default server process the request

Default server (server) has main try/catch block.

When an error occures server:

- do log (if logger was provided)
- execute Server error controller

## 6. Variant - controller works

- sends a controller result as a response

## 7. Variant - controller not works

- catch error from controller
- do log (if logger was provided)
- sends a plain text message as a response
