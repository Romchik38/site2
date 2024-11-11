--example 
WITH categories AS
(
    SELECT category_translates.category_id,
        category_translates.name
    FROM category_translates
    WHERE category_translates.language = $1
)
SELECT
article.identifier,
article_translates.name,
article_translates.short_description,
article_translates.description,
article_translates.created_at,
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
    AND article_translates.language = $1 
--ORDER BY article_translates.created_at DESC NULLS LAST
--   LIMIT 15
--   OFFSET 0
;


WITH categories AS
(    
    SELECT category_translates.category_id,        
    category_translates.name    
    FROM category_translates    
    WHERE category_translates.language = 'en'
)
    
SELECT article.identifier,
    article_translates.name,
    article_translates.short_description,
    article_translates.description,
    article_translates.created_at,
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
FROM    article,    article_translates
WHERE    article.identifier = article_translates.article_id    
    AND article.active = 'true'    
    AND article_translates.language = 'en' 
    ORDER BY article_translates.created_at DESC NULLS LAST
    LIMIT 15 
    OFFSET 0
;