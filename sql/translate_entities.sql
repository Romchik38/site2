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
    ('root.page_name', 'uk', 'Домашня сторінка'),
    ('server-error.message', 'en', 'Sorry, we have an error on our side. Please try again later'), 
    ('server-error.message', 'uk', 'Вибачте, нажаль сталася помилка на стороні серверу. Спробуйте повторити запит пізніше'),
    ('root.about', 'en', 'About Page'),
    ('root.about', 'uk', 'Сторінка про компанію'),
    ('root.contacts', 'en', 'Contacts Page'),
    ('root.contacts', 'uk', 'Наші контакти'),
    ('footer.copyright', 'en', 'Copyright'),
    ('footer.copyright', 'uk', 'Авторське право'),
    ('footer.by_romanenko', 'en', 'by Romanenko Serhii'),
    ('footer.by_romanenko', 'uk', 'належить Романенко Сергію'),
    --header
    ('header.logo', 'en', 'Logo'),
    ('header.logo', 'uk', 'Логотип'),
    ('header.phone_number', 'en', 'Phone number'),
    ('header.phone_number', 'uk', 'Контактний телефон'),
    ('header.sing_in', 'en', 'Sing in'),
    ('header.sing_in', 'uk', 'Увійти'),
    ('header.register', 'en', 'Register'),
    ('header.register', 'uk', 'Зареєструватися')
;

