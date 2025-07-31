# Search

- postgresql full text search
- query

## Query

1. Accepted string
    Class `Romchik38\Site2\Application\Search\ArticleSearch\VO` uses pattern:
    `/^(?=[\p{L}\p{N}\' ]{1,255}$)(?=.*\p{L})(?!.*\'{2,})[\p{L}\p{N}\' ]+$/u`

    Description:

    (?=[\p{L}\p{N}' ]{1,255}$)      only allowed characters (letters, digits, apostrophes, and  spaces), - and the total string length must be from 1 to 255 characters.

    (?=.*\p{L})                     the string must contain at least one letter.
    (?!.*'{2,})                     disallows two or more consecutive apostrophes.

    [\p{L}\p{N}' ]+                 the main part of the string: only letters, digits, apostrophes, and spaces are allowed.

2. String modification:
    - removed white space chars from beginnig and end
    - replace multi white space chars with single ` ` (space)

3. Word check:
    - word length must be lower than 40
  