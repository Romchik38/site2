# readme

Project uses [php-server](https://github.com/Romchik38/server) multi language system. It consists of:

- Router Middlewares
- Translate service
- Translate storage

## Router Middlewares

To ensure the language functionality on the site, middleware is used. The language code is prepended to the beginning of the URL. If a request comes from a URL that doesn't contain a known language, a redirect is performed to a URL with a language that is either present in the Accept-Language header and matches a site language, or to the URL with the default language.

For example:

1. We have languages according to the configuration: `en` and `uk`, where `en` is the default language.
2. A request is received for the URL `/`, which is the home page.
3. The `Accept-Language` header is checked.
4. If a language from list #1 is found in the `Accept-Language` header, it will be redirected to `/found_language`.
5. If not, it will be redirected to `/en`.
