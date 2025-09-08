# Continue reading

Site2 has a function to remember the `last article read`. It will be shown in the "Continue reading" section in your account and when you open a new article.

The following components are responsible for processing and displaying information:

- [Javascript module](./../../public/http/media/js/frontend/continue_reading)
- [Application service](./../../app/code/Application/Article/ContinueReading)
- [Api view endpoint](./../../app/code/Infrastructure/Http/Actions/POST/Api/ArticleContinueReading/DefaultAction.php)
- [Api update endpoint](./../../app/code/Infrastructure/Http/Actions/POST/Api/ArticleContinueReading/Update/DefaultAction.php)

## How it works

The `JavaScript module` sends a request to the `API view endpoint` and receives the `last 2 viewed articles`. Based on the received information, the module decides whether or not to show the last viewed article block to the visitor.

If the `module` decides to show the block to the visitor, it also makes a corresponding request to the `API update endpoint`.
