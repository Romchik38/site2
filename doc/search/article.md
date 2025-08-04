# Search

- classes
- query
- postgresql
- features

## Classes

Search query reaches the action `search` with GET method.

- accepts query - `Romchik38\Site2\Infrastructure\Http\Actions\GET\Search\DefaultAction`
- prepares query and forms result - `Romchik38\Site2\Application\Search\Article\ArticleSearchService`
- database repository - `Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Search\Article\Repository`
- query value object - `Romchik38\Site2\Application\Search\Article\VO\Query`

## Query

1. Accepted string
    Class `Romchik38\Site2\Application\Search\Article\VO\Query` uses pattern:

    ```php
    '/^(?=[\p{L}\p{N}\'’` ]{1,255}$)(?=.*[\p{L}\p{N}])(?!.*\'{2,})(?!.*’.*’)(?!.*`.*`)[\p{L}\p{N}\'’` ]+$/u'
    ```

    ```Description:

    (?=[\p{L}\p{N}\'’` ]{1,255}$)           allows only letters, digits, straight/typographic/backtick apostrophes, and spaces; total length: 1–255

    (?=.*[\p{L}\p{N}])                      requires at least one letter or number
    (?!.*\'{2,})                            disallows two or more consecutive '
    (?!.*ʼ{2,})                             disallows more than one typographic apostrophe ’
    (?!.*`.*`)                              disallows more than one backtick `
    [\p{L}\p{N}\'’` ]+                      main content of the string

    ```

2. String modification:
    - removed white space chars from beginnig and end
    - replace multi white space chars with single ` ` (space)
    - drops duplicates in word check

3. Word check:
    - word length must be lower than 40
    - word starts with `'ʼ
    - max words count 7

## Postgresql

' and ` is the same
' and ʼ is diff

## Features

- Search based on article's `name` and `description` columns.
- Operand `&` used with multiple wods.
