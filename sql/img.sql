CREATE table
    img (
        identifier serial NOT NULL PRIMARY KEY,
        active boolean NOT NULL DEFAULT false,
        name text not NULL,
        author_id int NOT NULL REFERENCES author (identifier) ON UPDATE CASCADE,
        path text NOT NULL
    );

CREATE table
    img_translates (
        img_id int NOT NULL REFERENCES img (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
        language text NOT NULL REFERENCES language (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
        description text NOT NULL,
        CONSTRAINT pk_img_translates PRIMARY KEY (img_id, language)
    );

INSERT INTO img (identifier, name, author_id, path) VALUES
    (1, 'simplification-of-the-drivers-license-examination-process', 1, 'articles/simplification-of-the-drivers-license-examination-process/1.webp')
;

INSERT INTO img_translates (img_id, language, description) VALUES
    ('1', 'en', 'Simplification of the drivers license examination process last year'),
    ('1', 'uk', 'Минулого року спрощено процедуру іспиту на отримання водійських прав')
;

INSERT INTO img (identifier, name, author_id, path) VALUES
    (, '', , '')
;
