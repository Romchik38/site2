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
- Logging
- [CSRF](./doc/security/csrf.md)
- [Mailer](./doc/mail/docker.md)
- [Docker](./doc/docker/00_readme.md) package for developing only
- User and admin user login (authentication and authorization)
- [DI Container](./doc/bootstrap/Container.md)
- Code architectural layers
- Sitemap system
- Breadcrumbs on every page
- Filtering
- Most Visited
- Similar
- Continue reading
- Banner with priority on main and category pages
- Javascript components
- Full workflow control inside domain model

## Dependencies

1. *twig/twig*. You can replace it with any other template engine. All what you must do in this case - replace twig templates with new ones. Core logic will no change.

2. *laminas/laminas-diactoros* - psr-7 implementation

3. *wapmorgan/mp3info* - mp3 file checker (forked and refactored)

4. Boostrap 5 as css framework

## Programming

- Site was writen with OOP.
- Phpstan with level 8.
- Code based on architectural layers: domain, application and infrastructure.
- Only PHP with minimum JS on frontend.

See docs in [doc folder](./doc/)

## Code quality

- phpstan level 8
  - ![passes](https://placehold.co/15x15/0dbc79/0dbc79.png)`[OK] No errors`  
- phpunit
  - ![passes](https://placehold.co/15x15/0dbc79/0dbc79.png)`OK (153 tests, 290 assertions)`
  - tested primary domain
- laminas-coding-standard
  - ![passes](https://placehold.co/15x15/0dbc79/0dbc79.png)`75 / 75 (100%)`
- deptrac levels
  - domain
  - application
  - infrastructure

## Memory usage

See memory usage [doc file](./doc/monitoring/memory.md).
