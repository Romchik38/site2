# readme

[hub](https://hub.docker.com/_/php)

1. Ini files from `docker/php-fpm/php/conf.d` will be copied to `$PHP_INI_DIR/conf.d/` directory (by default it's */usr/local/etc/php/conf.d*)

2. xdebug.ini

    - remove `back` from `docker/php-fpm/php/conf.d/xdebug.ini.back` it will be used inside a container
    - delete `;` inside it if you want to use xdebug
    - config your code editor.

    For `VS Code` use:

    ```json
      {
          "name": "Listen for Xdebug",
          "type": "php",
          "request": "launch",
          "port": 9003,  
          "pathMappings": {
              "/": "${workspaceFolder}"
          }     
      },
    ```

3. After than container can be builded
