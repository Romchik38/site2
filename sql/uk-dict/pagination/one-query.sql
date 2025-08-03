EXPLAIN ANALYZE
WITH rows AS (
    SELECT article.identifier,
    article.created_at,
    article.img_id,
    article_translates.name as article_name,
    article_translates.short_description,
    author_translates.description as author_description,
    img_translates.description as img_description,
    img.path,
    ts_rank(
        tsv,
        to_tsquery('ukrainian', 'суд')
    ) as rank
    FROM article_translates,
        article,
        author_translates,
        author,
        img,
        img_translates
    WHERE article_translates.language = 'uk' AND 
        (
            tsv @@ to_tsquery('ukrainian', 'суд')
        ) AND
        article.active = 't' AND
        article.identifier = article_translates.article_id AND
        article.author_id = author.identifier AND
        article.img_id = img.identifier AND
        author.identifier = author_translates.author_id AND
        author.active = 't' AND
        author_translates.language = 'uk' AND
        img.active = 't' AND
        img.identifier = img_translates.img_id AND
        img_translates.language = 'uk'
    ORDER BY rank DESC
)
SELECT rows.*,
    COUNT(*) OVER () AS total_count
FROM rows 
OFFSET 0 LIMIT 5;
-- Planning Time: 6.806 ms
-- Execution Time: 2.071 ms