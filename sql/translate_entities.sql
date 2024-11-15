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
    ('article.page_name', 'en', 'Materials on administrative law'),
    ('article.page_name', 'uk', 'Матеріли на тему адміністративного права'),
    ('article.description', 'en', 'We offer the latest materials analyzing legislative acts, court decisions, or procedures that regulate the activities of public authorities and their interaction with citizens. Such articles explain legal norms, their application, and their impact on social relations.'),
    ('article.description', 'uk', 'Ми пропонуємо найсвіжіші матеріали, що аналізують законодавчі акти, судові рішення або процедури, які регулюють діяльність органів державної влади та взаємодію з громадянами. Такі статті пояснюють норми права, їх застосування та вплив на суспільні відносини.'),
    ('article.h2.publications', 'en', 'Publications'),
    ('article.h2.publications', 'uk', 'Публікації'),
    ('article.read', 'en', 'read'),
    ('article.read', 'uk', 'читати'),
    ('article.view.seeall', 'en', 'see all'),
    ('article.view.seeall', 'uk', 'подивитись усі'),
    ('article.view.photo-by', 'en', 'Photo By'),
    ('article.view.photo-by', 'uk', 'Фото зроблено'),
    ('article.view.by', 'en', 'By'),
    ('article.view.by', 'uk', 'Автор'),
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
    ('header.link.sitemap', 'en', 'Sitemap'),
    ('header.link.sitemap', 'uk', 'Мапа сайту'),
    --footer
    ('footer.copyright', 'en', 'Copyright'),
    ('footer.copyright', 'uk', 'Авторське право'),
    ('footer.by_romanenko', 'en', 'by Romanenko Serhii'),
    ('footer.by_romanenko', 'uk', 'належить Романенко Сергію'),
    --service
    ('read-length-formatter.a-few-minutes', 'en', 'a few minutes'),
    ('read-length-formatter.a-few-minutes', 'uk', 'декілька хвилин'),
    ('read-length-formatter.min', 'en', 'min'),
    ('read-length-formatter.min', 'uk', 'хв'),
    ('read-length-formatter.hour', 'en', 'h'),
    ('read-length-formatter.hour', 'uk', 'год'),
    ('read-length-formatter.day', 'en', 'd'),
    ('read-length-formatter.day', 'uk', 'доба')
;
