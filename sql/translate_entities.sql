CREATE table translate_entities
(
    entity_id serial PRIMARY KEY, 
    key text REFERENCES translate_keys ( key ) ON DELETE CASCADE,
    language text REFERENCES translate_lang ( language ) ON DELETE CASCADE,
    phrase text NOT NULL,
    CONSTRAINT uq_translate_entities UNIQUE ( key, language )
);

--Examples
INSERT INTO translate_entities (key, language, phrase) VALUES
    ('root.page_name', 'en', 'Home page'), 
    ('root.page_name', 'uk', 'Домашня сторінка')
;