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

BEGIN;
INSERT INTO article (identifier) VALUES 
    ('article-1'),
    ('article-2')
;
INSERT INTO article_translates (article_id, language, name, description)
    VALUES
    ('article-1', 'en', 'Article about something', 'Today we talk about something'),
    ('article-2', 'en', 'Second article about that', 'Tomorrow we will talk about that')
;
INSERT INTO article_category VALUES
    ('article-1', 'category-1'),
    ('article-1', 'category-2')
;
COMMIT;

--getById query - ./article/getById.sql