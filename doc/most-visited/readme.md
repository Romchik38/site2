# Most Visited

The site keeps statistics on unique visits to `articles`. The most popular will be shown on the category page `/category/categity-id`  and in the `/articles`.  

You can view and reset the statistics in the admin panel `/admin/article/most_visited`.

Most Visited block consist of the following parts:

- [view application service](./../../app/code/Application/Article/MostVisited)
- [view repository](./../../app/code/Infrastructure/Persist/Sql/ReadModels/Article/MostVisited/Repository.php)
- [article application service](./../../app/code/Application/Article/ArticleService/ArticleService.php) with method `incrementViews` and `clearViews`

## Frontend

The [articleviews](./../../public/http/media/js/frontend/articleviews) JavaScript module is used to record a page view. It makes a POST request to the `/api/articleviews` API endpoint and sends the view data.

## API endpoint

[Post action](./../../app/code/Infrastructure/Http/Actions/POST/Api/ArticleViews/DefaultAction.php) processes the received information and provides a successful response if the processing was error-free.

The `post action` passes the received data to the [application service](./../../app/code/Application/Article/ArticleViews/ArticleViewsService.php). It is in this service that the decision to record the view is made.

## Application service

The [Views application service](./../../app/code/Application/Article/ArticleViews/ArticleViewsService.php) receives a [command](./../../app/code/Application/Article/ArticleViews/UpdateView.php) to record a view via the `updateView` method. The service interacts with the [visitor service](./../../app/code/Application/Visitor/VisitorService.php) and can check if this page has been visited before. If so, nothing happens. If the article is being viewed for the first time, a commands to record the view is sent to the `visitor service` and the [article service](./../../app/code/Application/Article/ArticleService/ArticleService.php).
