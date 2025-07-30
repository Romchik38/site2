--CHECK
SELECT to_tsvector('ukrainian', 'hello world');

--SIMPLE
SELECT article_id,
    name
FROM article_translates
WHERE to_tsvector('ukrainian', description) @@ to_tsquery('ukrainian', 'авто & суд');

-- A FEW COLUMNS
SELECT article_id
FROM article_translates
WHERE language='uk' AND 
    (
        to_tsvector('ukrainian', description) || 
        to_tsvector('ukrainian', name) @@ to_tsquery('ukrainian', 'авто & суд')
    );

-- RANK 
SELECT article_id, 
    ts_rank(
        to_tsvector('ukrainian', description) ||
        to_tsvector('ukrainian', name),
        to_tsquery('ukrainian', 'court')
    ) as rank
FROM article_translates
WHERE language='uk' AND 
    (
        to_tsvector('ukrainian', description) || 
        to_tsvector('ukrainian', name) @@ to_tsquery('ukrainian', 'court')
    )
ORDER BY rank DESC;
    