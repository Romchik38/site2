CREATE table
    img (
        identifier serial NOT NULL PRIMARY KEY,
        name text not NULL,
        author_id int NOT NULL REFERENCES person (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
        path text NOT NULL
    );

CREATE table
    img_translates (
        img_id int NOT NULL REFERENCES img (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON UPDATE CASCADE ON DELETE CASCADE,
        description text NOT NULL,
        CONSTRAINT pk_img_translates PRIMARY KEY (img_id, language)
    );

INSERT INTO img (identifier, name, author_id, path) VALUES
    (1, 'simplification-of-the-drivers-license-examination-process', 1, 'articles/simplification-of-the-drivers-license-examination-process/1.webp')
;
