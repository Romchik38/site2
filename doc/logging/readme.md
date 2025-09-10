# Loggin

Site2 classes based on `Psr\Log\LoggerInterface`. By default, a [file logger](https://github.com/Romchik38/server/blob/master/src/Utils/Logger/DeferredLogger/FileLogger.php) is used. It's implements `DeferredLoggerInterface`.

If you do not want to use `DeferredLoggerInterface` you cat replace it in [bootstrap](./../../app/bootstrap/utils.php) with your own.

## Features of deferred logging

Messages are logged only once at the end, you have to call `sendAllLogs` yourself.

As an example look at the [index.php](./../../public/http/index.php). Messages are logged on line 49 and the script finishes its work:

```php
$logger->sendAllLogs();
```
