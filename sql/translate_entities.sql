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
    --global
    ('global.language', 'en', 'English'),
    ('global.language', 'uk', 'Українська'),
    --controller
    ('root.page_name', 'en', 'Home page'), 
    ('root.page_name', 'uk', 'Домашня сторінка'),
    ('root.about', 'en', 'About Page'),
    ('root.about', 'uk', 'Сторінка про компанію'),
    ('root.contacts', 'en', 'Contacts Page'),
    ('root.contacts', 'uk', 'Наші контакти'),    
    ('server-error.header', 'en', 'Server error page'),
    ('server-error.header', 'uk', 'Сторінка помилки серверу'),
    ('server-error.message', 'en', 'Sorry, we have an error on our side. Please try again later'), 
    ('server-error.message', 'uk', 'Вибачте, нажаль сталася помилка на стороні серверу. Спробуйте повторити запит пізніше'),
    ('404.header', 'en', 'The requested page was not found on our server'),
    ('404.header', 'uk', 'Запрошена сторінка не знайдена на нашому сервері'),
    ('404.message', 'en', 'Please check the request and try again'),
    ('404.message', 'uk', 'Будь ласка, перевірте адресну строку та спробуйте знову'),
    --header
    ('header.logo', 'en', 'Lawshield'),
    ('header.logo', 'uk', 'Правощит'),
    ('header.sing_in', 'en', 'Sing in'),
    ('header.sing_in', 'uk', 'Увійти'),
    ('header.subscribe', 'en', 'Subscribe'),
    ('header.subscribe', 'uk', 'Підписатися'),
    --footer
    ('footer.copyright', 'en', 'Copyright'),
    ('footer.copyright', 'uk', 'Авторське право'),
    ('footer.by_romanenko', 'en', 'by Romanenko Serhii'),
    ('footer.by_romanenko', 'uk', 'належить Романенко Сергію')
;

