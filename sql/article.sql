CREATE table
    articles (
        article_id serial PRIMARY KEY,
        identifier text UNIQUE NOT NULL
    );

CREATE table
    article_translates (
        article_id int NOT NULL REFERENCES articles (article_id) ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON DELETE CASCADE,
        name text NOT NULL UNIQUE,
        description text NOT NULL,
        created_at timestamp NOT NULL DEFAULT current_timestamp,
        updated_at timestamp NOT NULL DEFAULT current_timestamp,
        CONSTRAINT pk_articles_translates PRIMARY KEY (article_id, language)
    );

WITH rows AS (
    INSERT INTO articles (identifier) 
        VALUES ('article-about-something') RETURNING article_id
)
INSERT INTO article_translates
    (article_id, language, name, description)
    VALUES
    (
        (SELECT article_id from rows),
        'en',
        'Article about something',
        'Today we talk about something'
    );