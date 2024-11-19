CREATE table
    category (identifier text UNIQUE NOT NULL);

CREATE table
    category_translates (
        category_id text NOT NULL REFERENCES category (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON UPDATE CASCADE ON DELETE CASCADE,
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
    ('traffic');

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
        'traffic',
        'en',
        'Traffic law',
        'Traffic law refers to the regulations and rules established by authorities to ensure the safe and efficient movement of vehicles and pedestrians on roads'
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
        'traffic',
        'uk',
        'Законодавство про дорожній рух',
        'Все про закони про дорожній рух які стосуються правил і норм, встановлених владою для забезпечення безпеки та ефективного руху транспортних засобів і пішоходів на дорогах'
    );

COMMIT;