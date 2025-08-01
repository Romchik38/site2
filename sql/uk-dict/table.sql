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

--MAIN QUERY
SELECT article_translates.article_id,
    article_translates.name as article_name,
    article_translates.short_description,
    article.author_id,
    article.img_id,
    article.created_at,
    author_translates.description as author_description,
    img_translates.description as img_description,
    ts_rank(
        tsv,
        to_tsquery('english', 'court')
    ) as rank
FROM article_translates,
    article,
    author_translates,
    author,
    img,
    img_translates
WHERE article_translates.language = 'en' AND 
    (
        tsv @@ to_tsquery('english', 'court')
    ) AND
    article.active = 't' AND
    article.identifier = article_translates.article_id AND
    article.author_id = author.identifier AND
    article.img_id = img.identifier AND
    author.identifier = author_translates.author_id AND
    author.active = 't' AND
    author_translates.language = 'en' AND
    img.active = 't' AND
    img.identifier = img_translates.img_id AND
    img_translates.language = 'en'
ORDER BY rank DESC;
    