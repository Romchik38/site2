# Todo

## Current

- after update to new server v
  - `RequestHandlerTrait`
    - remove `use` from some action, which use it
  - check sitemap - must form encoded urls (LinkTree)
  - check `Fileloader`
    - refactor if used
    - use in server error handler
  - `DatabaseSqlInterface` methods `queryParams` and `transactionQueryParams` accept array with null

- refactor twig from include to extends
- implement 404 page
  - use not found handler
  - look at `not-found` template folder

## Next

- return check "vendor/bin/deptrac"

- move to server
  - TwigView
  - Image storage

- monitoring
