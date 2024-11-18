CREATE table
    category (identifier text UNIQUE NOT NULL);

CREATE table
    category_translates (
        category_id text NOT NULL REFERENCES category (identifier) ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON DELETE CASCADE,
        name text NOT NULL UNIQUE,
        description text NOT NULL,
        CONSTRAINT pk_articles_translates PRIMARY KEY (category_id, language)
    );

BEGIN;

INSERT INTO
    category
VALUES
    ('category-1'),
    ('category-2'),
    ('category-3');

INSERT INTO
    category_translates
VALUES
    (
        'category-1',
        'en',
        'Some category 1',
        'Category 1 represents articles ...'
    ),
    (
        'category-2',
        'en',
        'Some category 2',
        'Category 2 represents articles ...'
    ),
    (
        'category-3',
        'en',
        'Some category 3',
        'Category 3 represents articles ...'
    ),
    (
        'category-1',
        'uk',
        'Якась категорія 1',
        'Категорія 1 містить матеріали з ...'
    ),
    (
        'category-2',
        'uk',
        'Якась категорія 2',
        'Категорія 2 містить матеріали з ...'
    ),
    (
        'category-3',
        'uk',
        'Якась категорія 3',
        'Категорія 3 містить матеріали з ...'
    );

COMMIT;