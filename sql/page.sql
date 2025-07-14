CREATE table page 
(
    id serial NOT NULL PRIMARY KEY,
    url text UNIQUE NOT NULL,
    active boolean NOT NULL DEFAULT false
);

CREATE table page_translates 
(
    page_id int NOT NULL REFERENCES page (id) ON DELETE CASCADE ON UPDATE CASCADE,
    language text NOT NULL REFERENCES language (identifier) ON UPDATE CASCADE,
    name text NOT NULL UNIQUE,
    short_description text NOT NULL,
    description text NOT NULL,
    CONSTRAINT pk_page_translates PRIMARY KEY (page_id, language)
);

INSERT INTO page (url) VALUES ('test-page');

INSERT INTO page_translates (page_id, language, name, short_description, description)
    VALUES 
    (
        1,
        'en',
        'Test Page',
        'Test short description',
        'Test description'
    ),
    (
        1,
        'uk',
        'Тестова сторінка',
        'Тестовий корткий опис',
        'Тестовий опис'
    )
;