# Mail

- docker

## Docker

Inside docker site2 uses `Mailpit` and `msmtp` to send mail. It's only for tests env.
To use in production you must configure mailer manually.

- [php.ini](./../../docker/php-fpm/php/conf.d/site2.ini)
- [msmtprc](./../../docker/php-fpm/php/msmtprc)