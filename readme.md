# Readme for site2

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

The only dependency is *twig/twig*. You can replace it with any other template engine. All what you must do in this case - replace twig templates with new ones. Core logic will no change.

Programming:

- Site was writen with OOP and based on DDD.
- Phpstan with level 8
- deptrac
- Only PHP with minimum JS on frontend

See docs in [doc folder](./doc/)
