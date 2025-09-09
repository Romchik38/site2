# Full text search

Site 2 uses Postgresql build in full text search.

- [postgres doc](https://www.postgresql.org/docs/current/textsearch.html)
- [uk dictionaries](https://github.com/brown-uk/dict_uk)
- [docker readme](./../../docker/postgres/readme.md)

## Article search

You can search for `articles` in one of two ways:

- Use the `search field` in the `site menu`.
- Visit the `/search` page and perform your search there.

The following components are responsible for the search functionality:

- [Application Service](./../../app/code/Application/Search/Article) - this is the service that contains the main search logic.
- [Javascript Component](./../../public/http/media/js/frontend/search/index.js) - a component that performs the search on the client side.
- [Http Action](./../../app/code/Infrastructure/Http/Actions/GET/Search/DefaultAction.php) - an action that handles the HTTP request related to the search.

More [details](./article.md) regarding search rules.
