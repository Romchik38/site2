--SIMPLE
SELECT article_id,
    name
FROM article_translates
WHERE to_tsvector('english', description) @@ to_tsquery('english', 'car & court');

-- A FEW COLUMNS
SELECT article_id
FROM article_translates
WHERE language='en' AND 
    (
        to_tsvector('english', description) || 
        to_tsvector('english', name) @@ to_tsquery('english', 'car')
    );

-- RANK 
SELECT article_id, 
    ts_rank(
        to_tsvector('english', description) ||
        to_tsvector('english', name),
        to_tsquery('english', 'court')
    ) as rank
FROM article_translates
WHERE language='en' AND 
    (
        to_tsvector('english', description) || 
        to_tsvector('english', name) @@ to_tsquery('english', 'court')
    )
ORDER BY rank DESC;
    