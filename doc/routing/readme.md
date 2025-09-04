# Routing

- routing system
- router middlewares
- middlewares logic
- routes (actions)
- boostrap file

## Routing system

Structure:

- [server](https://github.com/Romchik38/server/blob/master/src/Http/Servers/DefaultServer.php)
- [router handler](https://github.com/Romchik38/server/blob/master/src/Http/Routers/MiddlewareRouter.php)
- [router middlewares](https://github.com/Romchik38/server/tree/master/src/Http/Routers/Middlewares)

          Client
            |  |
      req   |  |  res
            v  |
          Server--<--
            |       ^
      req   |       |  res
            v       |
          Router Handler--<----
            |                 |
      req   |                 |
            v                 |
          Middleware 1        |
          ....                |
          Middleware n        ^
            |                 |  
            V                 |   res
            -------------------

- `server` passes the `request` unchanged to `router handler`
- `router handler` keeps track of `middlewares` and passes the `request` through them until it receives a response from one of them.

Depending on the middleware's `returns`, the router's action may be as follows:

- `null` - pass request to the next middleware
- `response` - returns it to server immediately
- `another result` - add the result as request attribute and pass updated request to next middleware

At the end of the `middleware` chain, if no `response` was received, an error will be thrown.

## Router middlewares

The site uses the following middlewares:

1. [PrefferedRootRouterMiddlewareUseAcceptLanguage](https://github.com/Romchik38/server/blob/master/src/Http/Routers/Middlewares/PrefferedRootRouterMiddlewareUseAcceptLanguage.php)
2. [DynamicPathRouterMiddleware](https://github.com/Romchik38/server/blob/master/src/Http/Routers/Middlewares/DynamicPathRouterMiddleware.php)
3. [ControllerRouterMiddleware](https://github.com/Romchik38/server/blob/master/src/Http/Routers/Middlewares/ControllerRouterMiddleware.php)
4. [HandlerRouterMiddleware as Not found](https://github.com/Romchik38/server/blob/master/src/Http/Routers/Middlewares/HandlerRouterMiddleware.php)

## Middlewares logic

- `Preferred` extract accept language header and returns an array of languages. So they will be added to request attributes

- `Dynamic Path` prepares url part and decide what to do:
  1. if no root were founded - it will redirect to `preferred` or `default` root
  2. if root were founded - it creates [DynamicRoot](https://github.com/Romchik38/server/blob/master/src/Http/Routers/Handlers/DynamicRoot/DynamicRoot.php) and [Path](https://github.com/Romchik38/server/blob/master/src/Http/Controller/Path.php) and returns the [DynamicPathMiddlewareResult](https://github.com/Romchik38/server/blob/master/src/Http/Routers/Middlewares/Result/DynamicPathMiddlewareResult.php) with them. So the result will be passed as an attribute to the request.
  3. if `Path` throws an error - it returns `null` because it doesn't know what to do.

- `Controller middleware` - knows how to work with [Controller](https://github.com/Romchik38/server/blob/master/src/Http/Controller/Controller.php).
  1. It takes `Path` from the request and run the `controller chain`.
  2. It also holds http methods: returns blank body on `HEAD's` and `method not allowed` on unknown one.
  3. It Returns `null` if no action were found.

- `Handler as Not found` - returns `404` page content.

## Routes (actions)

- [admin list](./../admin/routes.md)
- [frontend list](./../frontend/routes.md)

## Boostrap file

Look at [bootstrap file](./../../app/bootstrap/http/router.php)