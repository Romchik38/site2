# Readme for site2

![status](https://placehold.co/15x15/f03c15/f03c15.png) `status: development`
![phpstan](https://placehold.co/15x15/1589F0/1589F0.png) `phpstan: level 8`
![phpunit](https://placehold.co/15x15/c5f015/c5f015.png) `phpunit: very low`

Site2 is based on [php-server](https://github.com/Romchik38/server) and demonstrates:

- [multilanguage system](./doc/language/01-readme.md)
- [twig view](./doc/templates/01-readme.md)
- [Image Converter](./doc/Image_Converter/01_readme.md)

Additional:

- Routing system with PSR-7 Request/Response
- [Error handling](./doc/errors/errors.md)
- [Design](./doc/design/01-readme.md)
- Sitemap system
- Breadcrumbs on every page
- Logging
- [CSRF](./doc/security/csrf.md)
- [Mailer](./doc/mail/docker.md)
- [Docker](./doc/docker/00_readme.md) package for developing only
- User and admin user login (authentication and authorization)
- [DI Container](./doc/bootstrap/Container.md)

The only dependency is *twig/twig*. You can replace it with any other template engine. All what you must do in this case - replace twig templates with new ones. Core logic will no change.

Programming:

- Site was writen with OOP and based on DDD.
- Phpstan with level 8
- deptrac
- Only PHP with minimum JS on frontend

See docs in [doc folder](./doc/)

## Code quality

- phpstan level 8
  - ![passes](https://placehold.co/15x15/0dbc79/0dbc79.png)`[OK] No errors`  
- phpunit
  - ![passes](https://placehold.co/15x15/0dbc79/0dbc79.png)`OK (6 tests, 8 assertions)`
  - tested partially
- laminas-coding-standard
  - ![passes](https://placehold.co/15x15/0dbc79/0dbc79.png)`65 / 65 (100%)`
