# Readme for site2

![status](https://placehold.co/15x15/f03c15/f03c15.png) `status: ready`
![phpstan](https://placehold.co/15x15/1589F0/1589F0.png) `phpstan: level 8`
![phpunit](https://placehold.co/15x15/c5f015/c5f015.png) `phpunit: low`

## Primary goals

Site2 is based on [php-server](https://github.com/Romchik38/server) and [php-container](https://github.com/Romchik38/php-container) and demonstrates:

- [multilanguage system](./doc/language/01-readme.md)
- [twig view](./doc/templates/readme.md)
- [Image Converter](./doc/Image_Converter/01_readme.md)

## Additional

Also, you can inspect additional features:

- [Routing system](./doc/routing/readme.md) with PSR-7 Request/Response and middlewares
- [DI Container](./doc/bootstrap/Container.md)
- [Docker](./doc/docker/00_readme.md) package for developing only
- [Architecture](./doc/architecture/readme.md)
- [User login](./doc/frontend/login.md)
- [Admin user login (authentication and authorization)](./doc/admin/readme.md)
- [Error handling](./doc/errors/errors.md)
- [Design](./doc/design/01-readme.md)
- [Logging](./doc/logging/readme.md)
- [CSRF](./doc/security/csrf.md)
- [Sitemap](./doc/sitemap/readme.md) system
- [Breadcrumbs](./doc/breadcrumbs/readme.md) on every page
- [Filtering](./doc/filtering/readme.md)
- [Most Visited](./doc/most-visited/readme.md)
- [Similar](./doc/similar/readme.md)
- [Continue reading](./doc/continue-reading/readme.md)
- [Banner](./doc/banner/readme.md) with priority on main and category pages
- [Javascript components](./doc/javascript-components/readme.md)
- [Full text search based on Postgresql](./doc/search/readme.md)
- [Accept terms and conditions popup](./doc/accept-terms-conditions/readme.md)
- [Minum memory usage](./doc/monitoring/memory.md)
- [SEO](./doc/seo/readme.md)
- [Mailer](./doc/mail/readme.md)
- [PageSpeed Insights](./doc/page-speed/readme.md)

## Dependencies

Minimum dependencies:

1. *twig/twig*. You can replace it with any other template engine. All what you must do in this case - replace twig templates with new ones. Core logic will no change.
2. *laminas/laminas-diactoros* - psr-7 implementation
3. *wapmorgan/mp3info* - mp3 file checker (forked and refactored by me)
4. Boostrap 5 as a css framework

## Programming

- Site was writen with OOP.
- Phpstan with level 8.
- Code based on architectural layers: domain, application and infrastructure.
- Only PHP with minimum pure JS on the frontend.

See docs in [doc folder](./doc/)

## Code quality

- phpstan level 8
  - ![passes](https://placehold.co/15x15/0dbc79/0dbc79.png)`[OK] No errors`  
- phpunit
  - ![passes](https://placehold.co/15x15/0dbc79/0dbc79.png)`OK (365 tests, 626 assertions)`
  - tested primary domain
- laminas-coding-standard
  - ![passes](https://placehold.co/15x15/0dbc79/0dbc79.png)`75 / 75 (100%)`
- deptrac levels
  - domain
  - application
  - infrastructure

## Install

Please read [installation guide](./doc/install/readme.md) to run site2 as quickly as possible.
