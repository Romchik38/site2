CREATE table
    article (
        identifier text UNIQUE NOT NULL,
        active boolean DEFAULT false
    );

CREATE table
    article_translates (
        article_id text NOT NULL REFERENCES article (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON DELETE CASCADE ON UPDATE CASCADE,
        name text UNIQUE,
        description text,
        created_at timestamp NOT NULL DEFAULT current_timestamp,
        updated_at timestamp NOT NULL DEFAULT current_timestamp,
        CONSTRAINT pk_article_translates PRIMARY KEY (article_id, language)
    );

CREATE table
    article_category (
        article_id text NOT NULL REFERENCES article (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
        category_id text NOT NULL REFERENCES category (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT pk_article_category PRIMARY KEY (article_id, category_id)
    );

--INSERT
-- WITH rows AS (
--     INSERT INTO article (identifier) 
--         VALUES ('article-1') RETURNING article_id
-- )
BEGIN;
INSERT INTO article (identifier) 
        VALUES ('article-1');
;
INSERT INTO article_translates (article_id, language, name, description)
    VALUES
    (
        'article-1',
        'en',
        'Article about something',
        'Today we talk about something'
    )
;
INSERT INTO article_category VALUES
    ('article-1', 'category-1')
;
COMMIT;

--getById query - ./article/getById.sql