# authorization

1. All requests pass through `AdminLoginMiddleware`. It cheсks - admin user must be logged in. If not, it will redirect admin user to login page. Middleware do not check any *roles*

2. `AdminRolesMiddleware` class is responsable to check admin user's roles. It takes allowed roles as param and compare them to admin user's roles. On first match execution will pass. If admin user does not have any allowed role, it will be redirected to admin page (any admin user can visit).
