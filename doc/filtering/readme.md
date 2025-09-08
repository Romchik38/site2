# Filtering

- description
- how it works
- example

## Description

On the external part of the website, filtering by articles has been implemented. You can see an example here - `/article`. If you scroll down the page and click on page `2`, you will notice that the URL has changed to `/article?page=2&limit=15&order_by=created_at&order_direction=desc`.
You can try to change the settings manually. For example, change the limit value to `5`. The system will return `a new list` of articles and you will be inside a different sorting, but still on page `2`. As confirmation, check the number of possible pages at the bottom. Their number should increase by a factor of 3 (15/5 = 3).
Be careful with changing the values manually. In case incorrect data is submitted to the system, an error page will be shown.

On the `/article` page, the filtering controls are hidden. This was done intentionally. You can see the filtering with controls on any category page. To do this, go to the list of categories page `/category` and choose the one with more articles (for convenience of viewing). For example `/category/traffic`. You can see the controls below the "Last publications" heading. Change a value and click the filter button.

## How it works

The following elements are a responsible for filtering:

- `Commands` that are responsible for the upload and initial validation of user data.
- The `application service` that receives the corresponding command.
- `Value objects` that validate the received data and are subsequently used for selection.

Also involved in the filtering process are:

- The `HTTP action` through which the request is sent to the application service.
- `A database` that stores information.
- `Pagination classes` that create HTML code from the available request data
- `ApiDTO` in a JSON response

## Example

Let's look at the code block that is responsible for filtering the `/article` page.

### Application

The command used for filtering is [Filter](./../../app/code/Application/Article/List/Commands/Filter/Filter.php). First, you need to create this command. This can be done via the `constructor` or the static `fromRequest` method.

Next, this `command` must be passed to the [article filtering service's](./../../app/code/Application/Article/List/ListService.php) `list` method.

Inside the `list` method, a [search criteria](./../../app/code/Application/Article/List/Commands/Filter/SearchCriteria.php) is created which is then passed to the database.

At the end, the mentioned function returns a [result](./../../app/code/Application/Article/List/Commands/Filter/FilterResult.php) with a list of found articles.

### Infrastructure

The task at the `infrastructure level` is to create a `command` and pass it to a `service`. Upon receiving the `result`, for example an HTTP action, it has all the data to form a display - fields, values, a list of articles, and their total count.

### Database

The database `repository`, in turn, receives the mentioned `search criteria` and knows how to work with it in order to execute a `query` to the corresponding `tables`.

The `repository's` task is to create an [article read model](app/code/Application/Article/List/Commands/Filter/ArticleDTO.php). The `repository` creates the appropriate [value objects](./../../app/code/Domain/Article/VO) from the available data and pass them to the `model`.
