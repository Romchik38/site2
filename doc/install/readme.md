# Install

Site 2 based on 3 main parts:

- Php-fpm
- Nginx server
- Postgresql database

App Server can be started [mannually](./standalone.md) or with [docker](./docker.md).

You can replace `Nginx` with other server. All what you need is to send all requests to the [entry point](./../../public/http/index.php)

In theory, you can replace `Postgres` with another database, but the site performs full-text search using `Postgres`, so [search module](./../search/readme.md) must either be disabled or replaced.

The guide turned out to be a little complicated, apologies in advance. If you have any problems, please write me an email.
