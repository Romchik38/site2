# Container

- description
- structure

## Description

Site2 uses [php-container](https://github.com/Romchik38/php-container) to create classes and their dependecies. All dependecies are added manually, any magic.

Read [php-container readme](https://github.com/Romchik38/php-container/blob/main/README.MD) to learn more.

## Structure

All bootstrap files are placed in [bootstrap folder](./../../app/bootstrap/).

There are 2 entry points:

- [main](./../../app/bootstrap_http_sql.php)
- [image converter](./../../app/bootstrap_img.php)

Both points have shared resources. You can notice this by the common included files.

The boostrap system consists of the following groups:

- http (web)
- persist (databases)
- application (logic)
- consts (autoload from [config](./../../app/config/))
- utils (logging, generation, and so on)

If necessary, the corresponding block needs to be connected.
