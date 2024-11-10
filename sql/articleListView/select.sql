--example 
SELECT article.identifier,
    article.active,
    article_translates.language,
    article_translates.name,
    article_translates.description,
    article_translates.created_at,
    article_translates.updated_at,
    -- create a list of categories
    array(
        select category_id from article_category 
            where article.identifier = article_category.article_id
        ) as categories 

    FROM article, article_translates
    --expression
    WHERE article.identifier = article_translates.article_id AND
        article.active = 'true' AND
        article_translates.language = 'en'
;

