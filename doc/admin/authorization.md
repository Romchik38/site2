# authorization

1. All requests pass through `AdminLoginMiddleware`. It cheсks - admin user must be logged in. If not, it will redirect admin user to login page. Middleware do not check any *roles*
