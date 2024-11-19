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
        article_translates.updated_at,
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
        ) as category,
        person_translates.person_id,
        person_translates.first_name,
        person_translates.last_name
        FROM
            article,
            article_translates,
            person_translates
        WHERE 
            article.identifier = 'simplification-of-the-drivers-license-examination-process'
            AND article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = 'en'
            AND person_translates.person_id = article.author_id
            AND person_translates.language = 'en'
;

