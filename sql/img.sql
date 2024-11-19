CREATE table
    img (
        identifier serial NOT NULL PRIMARY KEY,
        name text not NULL,
        author_id int NOT NULL REFERENCES person (identifier) ON DELETE CASCADE ON UPDATE CASCADE
    );

CREATE table
    img_translates (
        img_id int NOT NULL REFERENCES img (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON UPDATE CASCADE ON DELETE CASCADE,
        description text NOT NULL,
        CONSTRAINT pk_img_translates PRIMARY KEY (img_id, language)
    );
