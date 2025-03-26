# readme

[hub](https://hub.docker.com/_/php)

1. Ini files
  files from `docker/php-fpm/php/conf.d`
  will be copied to $PHP_INI_DIR/conf.d/ directory (by default it's */usr/local/etc/php/conf.d*)

2. to use x-debug
  remove `back` from `docker/php-fpm/php/conf.d/xdebug.ini.back` and delete `;` inside it
  config your code editor

  for VS Code use:
  
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
