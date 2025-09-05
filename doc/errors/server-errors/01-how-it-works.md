# How it works

1. Nginx sends a request to php-fpm service
2. Php-fpm processes index.php
3. Index.php starts [Default server](https://github.com/Romchik38/server/blob/master/src/Servers/Http/DefaultServer.php)
4. Default server processes the request
5. On error executes [server error handler](./../../../app/code/Infrastructure/Http/RequestHandlers/ServerErrorHandler.php)
6. If `server error handler` throws an exception, `server` sends plain `500` error.
