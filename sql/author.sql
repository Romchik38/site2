CREATE table author
(
    identifier serial NOT NULL PRIMARY KEY,
    name text NOT NULL,
    active boolean NOT NULL DEFAULT false
);

CREATE table
    author_translates (
        author_id int NOT NULL REFERENCES author (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON UPDATE CASCADE,
        description text DEFAULT NULL,
        CONSTRAINT pk_author_translates PRIMARY KEY (author_id, language)
    );

INSERT INTO author (identifier, name) VALUES
    (,)
;

INSERT INTO author_translates (author_id, language, description) VALUES
    (,'en',),
    (,'uk',)
;

