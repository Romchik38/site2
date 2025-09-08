# Similar

On the article page `/article/article-id`, similar articles by category are offered. Their number is limited to three and can be changed as needed by making changes to the code.

The [application service](./../../app/code/Application/Article/SimilarArticles) is responsible for providing data on similar articles.

The selection is based on the categories of the provided article.

To get a list of similar articles, you need to call service's `list` method with [command](./../../app/code/Application/Article/SimilarArticles/Commands/ListSimilar/ListSimilar.php).
