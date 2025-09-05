# Not found Error (404)

`Not found` block consist of 2 parts:

1. [HandlerRouterMiddleware](https://github.com/Romchik38/server/blob/master/src/Http/Routers/Middlewares/HandlerRouterMiddleware.php)
2. [Request Handler](./../../../app/code/Infrastructure/Http/RequestHandlers/NotFoundHandler.php)

The block executes at the end of router middleware chain if no controller were found. See [routing](./../../routing/readme.md).
