CREATE table category
(
        identifier text UNIQUE NOT NULL,
        active boolean NOT NULL DEFAULT false
    );

CREATE table
    category_translates (
        category_id text NOT NULL REFERENCES category (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON UPDATE CASCADE ON DELETE CASCADE,
        name text NOT NULL UNIQUE,
        description text NOT NULL,
        --?
        CONSTRAINT pk_articles_translates PRIMARY KEY (category_id, language)
    );
