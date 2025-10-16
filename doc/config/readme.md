# Config

The primitive configuration data is defined in the `app/config` directory. Each file from this directory is automatically loaded. The configuration data is used inside the `app/bootstrap` files to define classes.

You can override the configuration data. To do this, create a new file named `config.local.php` in the `app` directory. In this file, specify the data you need to override. It will replace the base configuration. For convenience, `app/config.local.php.example` was created, which you can edit. Remove the `.example` extension and it will be loaded by the system.
