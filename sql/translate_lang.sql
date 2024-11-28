CREATE table translate_lang
(
    language text PRIMARY KEY,
    active boolean NOT NULL DEFAULT false
);

INSERT INTO translate_lang (language) VALUES
    ('en'), 
    ('uk')
;