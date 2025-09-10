# Controller

1. Controller collection
2. Controller chain
3. Actions
4. Middlewares
5. Example

Read more about [controller](https://github.com/Romchik38/server/blob/master/docs/controller/00_readme.md).

## 1. Controller collection

The [Controller collection](https://github.com/Romchik38/server/blob/master/src/Http/Controller/ControllersCollection.php) holds all controllers by http method. See [bootstrap creation](./../../app/bootstrap/http/router.php) and [bootstrap config](./../../app/bootstrap/http/actionsList.php)

## 2. Controller chain

Controllers chain is a list. First in the list called `root`. Look at the [get list](./../../app/bootstrap/http/actionsList/get.php) and the [post list](./../../app/bootstrap/http/actionsList/post.php).

## 3. Actions

Any `controller` can have actions - `default` and `dynamic`. Look at the [boostrap](./../../app/bootstrap/http/actions.php) and [classes](./../../app/code/Infrastructure/Http/Actions/)

## 4. Middlewares

Before each controller can be placed `request middleware`, after - `response middleware`. So we can control flow betwen controllers. Look at the [bootstrap](./../../app/bootstrap/http/actionsList/request_middlewares.php) and [classes](./../../app/code/Infrastructure/Http/RequestMiddlewares/)

## 5. Example

1. Clien sends `GET` request on `/en/contacts`.
2. Dynamic Path Router Middleware create a `Path` like `['root', 'contacts']` and `DynamicRoot` with `en` as the `currentRoot`
3. `ControllerCollection` takes from `GET` storage `root` controller and pass the `request`
4. `root` controller understands that the first part of the `Path` belongs to it, so it will be executed. Next, the `root` needs to decide what to do with `contacts`. First, it checks if it has a `child` with that `name`. No, it doesn't have such a controller. Then it checks if it has a `DynamicAction`. Yes, it exists, so control with the request is passed to this [DynamicAction](./../../app/code/Infrastructure/Http/Actions/GET/Root/DynamicAction.php).
5. `DynamicAction` gets the `request`. Also it can find the `contacts` as a `route` from the `request`. It has to decide what to do - if it knows something about `contacts`, provide a response; if it knows nothing about `contacts`, throw an exception. In this case, a page named `contacts` will be found and a response will be provided.
