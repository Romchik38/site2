CREATE table
    category (
        identifier text UNIQUE NOT NULL
    );

CREATE table
    category_translates (
        category_id text NOT NULL REFERENCES category (identifier) ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON DELETE CASCADE,
        name text NOT NULL UNIQUE,
        description text NOT NULL,
        CONSTRAINT pk_articles_translates PRIMARY KEY (category_id, language)
    );

BEGIN;
INSERT INTO category VALUES
    ('category-1')
;
INSERT INTO category_translates VALUES
    (
        'category-1', 
        'en',
        'Some category 1',
        'Category 1 represents articles ...'
    )
;
COMMIT;