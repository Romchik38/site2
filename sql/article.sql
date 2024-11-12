CREATE table
    article (
        identifier text UNIQUE NOT NULL,
        active boolean DEFAULT false
    );

CREATE table
    article_translates (
        article_id text NOT NULL REFERENCES article (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON DELETE CASCADE ON UPDATE CASCADE,
        name text NOT NULL UNIQUE,
        short_description NOT NULL text,
        description NOT NULL text,
        created_at timestamp NOT NULL DEFAULT current_timestamp,
        updated_at timestamp NOT NULL DEFAULT current_timestamp,
        CONSTRAINT pk_article_translates PRIMARY KEY (article_id, language)
    );

CREATE table
    article_category (
        article_id text NOT NULL REFERENCES article (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
        category_id text NOT NULL REFERENCES category (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT pk_article_category PRIMARY KEY (article_id, category_id)
    );

BEGIN;
INSERT INTO article (identifier) VALUES 
    ('article-1'),
    ('article-2'),
    ('article-3'),
    ('article-4'),
    ('article-5'),
    ('article-6'),
    ('article-7'),
    ('article-8'),
    ('article-9'),
    ('article-10'),
    ('article-11'),
    ('article-12'),
    ('article-13'),
    ('article-14'),
    ('article-15'),
    ('article-16'),
    ('article-17'),
    ('article-18'),
    ('article-19'),
    ('article-20'),
    ('article-21'),
    ('article-22')
;
INSERT INTO article_translates (article_id, language, name, short_description, description)
    VALUES
    ('article-1', 'en', 'Article about something', 'short description here - art 1', 'Today we talk about something'),
    ('article-2', 'en', 'Second article about that', 'short description here - art 2', 'Tomorrow we will talk about that'),
    ('article-1', 'uk', 'Короткий опись для матеріалу 1', 'Матеріал про щось', 'Сьогодні ми поговоримо про щось'),
    ('article-2', 'uk', 'Друга стаття про це', 'короткий опис тут - ст.2', 'Завтра ми про це поговоримо')
    ('article-3', 'en', 'Article 3 name', 'Article 3 short description', 'Article 3 description'),
    ('article-4', 'en', 'Article 4 name', 'Article 4 short description', 'Article 4 description'),
    ('article-5', 'en', 'Article 5 name', 'Article 5 short description', 'Article 5 description'),
    ('article-6', 'en', 'Article 6 name', 'Article 6 short description', 'Article 6 description'),
    ('article-7', 'en', 'Article 7 name', 'Article 7 short description', 'Article 7 description'),
    ('article-8', 'en', 'Article 8 name', 'Article 8 short description', 'Article 8 description'),
    ('article-9', 'en', 'Article 9 name', 'Article 9 short description', 'Article 9 description'),
    ('article-10', 'en', 'Article 10 name', 'Article 10 short description', 'Article 10 description'),
    ('article-11', 'en', 'Article 11 name', 'Article 11 short description', 'Article 11 description'),
    ('article-12', 'en', 'Article 12 name', 'Article 12 short description', 'Article 12 description'),
    ('article-13', 'en', 'Article 13 name', 'Article 13 short description', 'Article 13 description'),
    ('article-14', 'en', 'Article 14 name', 'Article 14 short description', 'Article 14 description'),
    ('article-15', 'en', 'Article 15 name', 'Article 15 short description', 'Article 15 description'),
    ('article-16', 'en', 'Article 16 name', 'Article 16 short description', 'Article 16 description'),
    ('article-17', 'en', 'Article 17 name', 'Article 17 short description', 'Article 17 description'),
    ('article-18', 'en', 'Article 18 name', 'Article 18 short description', 'Article 18 description'),
    ('article-19', 'en', 'Article 19 name', 'Article 19 short description', 'Article 19 description'),
    ('article-20', 'en', 'Article 20 name', 'Article 20 short description', 'Article 20 description'),
    ('article-21', 'en', 'Article 21 name', 'Article 21 short description', 'Article 21 description'),
    ('article-22', 'en', 'Article 22 name', 'Article 22 short description', 'Article 22 description'),
    ('article-3', 'uk', 'Матеріал 3 им''я', 'Матеріал 3 короткий опис', 'Матеріал 3 повний опис'),
    ('article-4', 'uk', 'Матеріал 4 им''я', 'Матеріал 4 короткий опис', 'Матеріал 4 повний опис'),
    ('article-5', 'uk', 'Матеріал 5 им''я', 'Матеріал 5 короткий опис', 'Матеріал 5 повний опис'),
    ('article-6', 'uk', 'Матеріал 6 им''я', 'Матеріал 6 короткий опис', 'Матеріал 6 повний опис'),
    ('article-7', 'uk', 'Матеріал 7 им''я', 'Матеріал 7 короткий опис', 'Матеріал 7 повний опис'),
    ('article-8', 'uk', 'Матеріал 8 им''я', 'Матеріал 8 короткий опис', 'Матеріал 8 повний опис'),
    ('article-9', 'uk', 'Матеріал 9 им''я', 'Матеріал 9 короткий опис', 'Матеріал 9 повний опис'),
    ('article-10', 'uk', 'Матеріал 10 им''я', 'Матеріал 10 короткий опис', 'Матеріал 10 повний опис'),
    ('article-11', 'uk', 'Матеріал 11 им''я', 'Матеріал 11 короткий опис', 'Матеріал 11 повний опис'),
    ('article-12', 'uk', 'Матеріал 12 им''я', 'Матеріал 12 короткий опис', 'Матеріал 12 повний опис'),
    ('article-13', 'uk', 'Матеріал 13 им''я', 'Матеріал 13 короткий опис', 'Матеріал 13 повний опис'),
    ('article-14', 'uk', 'Матеріал 14 им''я', 'Матеріал 14 короткий опис', 'Матеріал 14 повний опис'),
    ('article-15', 'uk', 'Матеріал 15 им''я', 'Матеріал 15 короткий опис', 'Матеріал 15 повний опис'),
    ('article-16', 'uk', 'Матеріал 16 им''я', 'Матеріал 16 короткий опис', 'Матеріал 16 повний опис'),
    ('article-17', 'uk', 'Матеріал 17 им''я', 'Матеріал 17 короткий опис', 'Матеріал 17 повний опис'),
    ('article-18', 'uk', 'Матеріал 18 им''я', 'Матеріал 18 короткий опис', 'Матеріал 18 повний опис'),
    ('article-19', 'uk', 'Матеріал 19 им''я', 'Матеріал 19 короткий опис', 'Матеріал 19 повний опис'),
    ('article-20', 'uk', 'Матеріал 20 им''я', 'Матеріал 20 короткий опис', 'Матеріал 20 повний опис'),
    ('article-21', 'uk', 'Матеріал 21 им''я', 'Матеріал 21 короткий опис', 'Матеріал 21 повний опис'),
    ('article-22', 'uk', 'Матеріал 22 им''я', 'Матеріал 22 короткий опис', 'Матеріал 22 повний опис')
;

INSERT INTO article_category VALUES
    ('article-1', 'category-1'),
    ('article-1', 'category-2')
;
COMMIT;

--getById query - ./article/getById.sql