# Authorization

- midlewares
- schema
- existing midlewares
- create new

## Midlewares

- All requests pass through [AdminLoginMiddleware](./../../app/code/Infrastructure/Http/RequestMiddlewares/Admin/AdminLoginMiddleware.php). It cheсks - admin user must be logged in. If not, it will redirect admin user to login page. Middleware do not check any *roles*

- [AdminRolesMiddleware](./../../app/code/Infrastructure/Http/RequestMiddlewares/Admin/AdminRolesMiddleware.php) class is responsable to check admin user's roles. It takes allowed roles as param and compare them to admin user's roles. On first match execution will pass. If admin user does not have any allowed role, it will be redirected to admin page (any admin user can visit).

## Schema

                Admin controller
                      ||
                      \/
                Auth middleware
                      ||
                      \/
                    /   \
                   /     \
           Success      Failure  
           /     \          \
          /       \          \
      Default   Next         Admin Login Page
      Action    Controller

## Existing midlewares

The following midlewares are created by default:

- Admin Root
- Admin All Requests

You can find them in [boostrap file](./../../app/bootstrap/http/actionsList/request_middlewares.php)

These `middlewares` are added to the corresponding `controllers` when the `addRequestMiddleware` function is called. Read more [post controller bootstrap](./../../app/bootstrap/http/actionsList/post.php)

## Create new

You can either create new `middlewares` or use existing ones to restrict access to different parts of the site.

1. Create a `class`
2. Add `class` to [bootstrap](./../../app/bootstrap/http/actionsList/request_middlewares.php)
3. Add `middleware` in the [post controller bootstrap](./../../app/bootstrap/http/actionsList/post.php)

Readm more about [container](https://github.com/Romchik38/php-container). It's pretty simple.
