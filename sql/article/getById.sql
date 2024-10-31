--this is not works because translate or category may not be added
SELECT article.identifier,
    article.active,
    article_translates.language,
    article_translates.name,
    article_translates.description,
    article_translates.created_at,
    article_translates.updated_at,
    -- create a list of categories
    article_category.category_id
    FROM article, article_translates, article_category
    --expression
    WHERE article.identifier = $1 AND
        article.identifier = article_translates.article_id AND
        article.identifier = article_category.article_id
;
