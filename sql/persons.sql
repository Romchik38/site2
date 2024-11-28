CREATE table person
(
    identifier serial NOT NULL PRIMARY KEY,
    active boolean NOT NULL DEFAULT false
);

CREATE table
    person_translates (
        person_id int NOT NULL REFERENCES person (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON UPDATE CASCADE ON DELETE CASCADE,
        first_name text NOT NULL,
        last_name text NOT NULL,
        middle_name text DEFAULT NULL,
        CONSTRAINT pk_person_translates PRIMARY KEY (person_id, language)
    );

INSERT INTO person (identifier) VALUES
    (1), (2), (3)
;

INSERT INTO person_translates (person_id, language, first_name, last_name) VALUES
    (1, 'en', 'Dmitro', 'Snigirev'), 
    (2, 'en', 'Ivan', 'Zatyajniy'), 
    (3, 'en', 'Serhii', 'Kolenko'),
    (1, 'uk', 'Дмитро', 'Снігірьов'), 
    (2, 'uk', 'Іван', 'Затяжний'), 
    (3, 'uk', 'Сергій', 'Kolenko')
;

-----------