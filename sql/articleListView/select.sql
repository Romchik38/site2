--example 
WITH categories AS
(
    SELECT category_translates.category_id,
        category_translates.name
    FROM category_translates
    WHERE category_translates.language = 'en'
)

SELECT
    article.identifier,
    article.active,
    article_translates.language,
    article_translates.name,
    article_translates.short_description,
    article_translates.description,
    article_translates.created_at,
    article_translates.updated_at,
    -- create a list of categories
    array_to_json (
        array (
            select
                categories.name
            from
                categories, article_category
            where
                article.identifier = article_category.article_id AND
                categories.category_id = article_category.category_id
        )
    ) as category
FROM
    article,
    article_translates
WHERE
    article.identifier = article_translates.article_id
    AND article.active = 'true'
    AND article_translates.language = 'en'   
-- defaults:
--   ORDER BY article_translates.created_at
--   LIMIT 15
--   OFFSET 0
;