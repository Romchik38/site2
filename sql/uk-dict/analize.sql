-- Без індексу
explain analyze SELECT article_id
FROM article_translates
WHERE language='uk' AND 
    (
        to_tsvector('ukrainian', description) || 
        to_tsvector('ukrainian', name) @@ to_tsquery('ukrainian', 'авто | суд')
    );
--Bitmap Heap Scan on article_translates  (cost=8.55..37.52 rows=1 width=45) (actual time=5.878..127.165 rows=17 loops=1)
--   Recheck Cond: (language = 'uk'::text)
--   Filter: ((to_tsvector('ukrainian'::regconfig, description) || to_tsvector('ukrainian'::regconfig, name)) @@ '''авто'' | ''суд'''::tsquery)
--   Rows Removed by Filter: 10
--   Heap Blocks: exact=15
--   ->  Bitmap Index Scan on pk_article_translates  (cost=0.00..8.54 rows=27 width=0) (actual time=0.022..0.022 rows=48 loops=1)
--         Index Cond: (language = 'uk'::text)
-- Planning Time: 0.308 ms
-- Execution Time: 127.s196 ms

-- З індексом
explain analyze SELECT article_id
FROM article_translates
WHERE language='uk' AND 
    (
        tsv @@ to_tsquery('ukrainian', 'авто | суд')
    );
-- Seq Scan on article_translates  (cost=0.00..15.81 rows=9 width=45) (actual time=0.036..0.549 rows=17 loops=1)
--   Filter: ((tsv @@ '''авто'' | ''суд'''::tsquery) AND (language = 'uk'::text))
--   Rows Removed by Filter: 37
-- Planning Time: 0.364 ms
-- Execution Time: 0.564 ms
