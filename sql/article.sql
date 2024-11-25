CREATE table
    article (
        identifier text UNIQUE NOT NULL,
        active boolean DEFAULT false,
        author_id int NOT NULL REFERENCES person (identifier) ON UPDATE CASCADE,
        img_id int REFERENCES img (identifier) ON UPDATE CASCADE
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
INSERT INTO article (identifier, author_id) VALUES 
    ('article-1', 1),
    ('article-2', 1),
    ('article-3', 1),
    ('article-4', 1),
    ('article-5', 1),
    ('article-6', 1),
    ('article-7', 1),
    ('article-8', 1),
    ('article-9', 1),
    ('article-10', 1),
    ('article-11', 1),
    ('article-12', 1),
    ('article-13', 1),
    ('article-14', 1),
    ('article-15', 1),
    ('article-16', 1),
    ('article-17', 1),
    ('article-18', 1),
    ('article-19', 1),
    ('article-20', 1),
    ('article-21', 1)
;
INSERT INTO article (identifier, author_id, img_id) VALUES  
    ('simplification-of-the-drivers-license-examination-process', 1, 1)
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
    ('simplification-of-the-drivers-license-examination-process', 'en', 'Simplification of the driver''s license examination process', 'The process of obtaining a driver''s license has also changed for future drivers. From now on, candidates can take the theoretical exam without mandatory attendance at driving school courses. This reduces the financial burden on candidates and allows them to prepare for exams independently. However, practical training remains an important step that must be completed before obtaining a driver''s license.', '<p>Important amendments to Ukraine''s traffic rules, which came into effect in 2024, aim to increase road safety and reduce the number of accidents. One of the key innovations is the mandatory use of daytime running lights outside populated areas throughout the year. Previously, drivers were only required to use running lights in the autumn-winter period (from October 1 to May 1), but now this rule is in effect year-round. The decision is aimed at making vehicles more visible to other road users regardless of weather conditions or lighting levels.</p><h2>The Importance of Using Running Lights</h2><p>Headlights reduce the risk of accidents by improving the visibility of cars on the road, especially in poor weather conditions such as rain or fog. Lighting devices help quickly identify approaching vehicles, especially on roads with heavy traffic. Thus, the decision to make running lights mandatory outside the city year-round is fully justified. According to research, the visibility of a car with headlights on can improve the reaction of other drivers and pedestrians by 20-25%, reducing the risk of collisions.</p><h2>Rule Compliance Check</h2><p>The new requirements stipulate that the police can now monitor compliance with this rule on roads outside populated areas. Drivers who ignore this requirement face fines. Since the continuous use of running lights is becoming mandatory, additional control by the police is expected, along with the installation of new surveillance cameras capable of recording violations remotely.</p>'),
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
    ('simplification-of-the-drivers-license-examination-process', 'uk', 'Спрощення процесу складання іспитів на права', 'Для майбутніх водіїв процес отримання прав також зазнав змін. Відтепер кандидати можуть складати теоретичний іспит без обов’язкового відвідування курсів в автошколах. Це зменшує фінансове навантаження на кандидатів і дозволяє їм готуватися до екзаменів самостійно. Однак практична підготовка залишається важливим етапом, який необхідно пройти перед отриманням посвідчення водія.', '<p>У 2024 році в Україні було запроваджено зміни, які спрощують процес складання іспитів на отримання водійських прав. Основне нововведення полягає в тому, що тепер кандидати у водії можуть складати теоретичний іспит без обов''язкового навчання в автошколі. Це значне полегшення для тих, хто має базові знання з правил дорожнього руху та здатний самостійно підготуватися до іспиту.</p><h2>Мета змін</h2> Зміни спрямовані на зменшення фінансового навантаження на громадян, адже навчання в автошколах може бути досить витратним. Наразі багато громадян мають можливість навчатися самостійно за допомогою онлайн-ресурсів або спеціалізованих додатків для вивчення ПДР. Скасування обов’язкових курсів у автошколах також робить процес отримання прав більш доступним, особливо для людей з обмеженими фінансовими можливостями або тих, хто не має часу на відвідування навчальних закладів.</p> <p>Особливості нового підходу У нових правилах передбачено, що кандидати можуть самостійно обирати метод підготовки до теоретичного іспиту. Однак вимоги до практичних навичок залишаються незмінними, і для отримання права керувати транспортним засобом необхідно пройти практичне навчання в автошколі та скласти відповідний іспит. Це дозволяє зберегти необхідний рівень безпеки на дорогах, адже управління транспортом вимагає не лише знань теорії, але й певного рівня практичної підготовки під наглядом інструктора.</p> <h2>Економія часу та ресурсів</h2> <p>Введення можливості самопідготовки до теоретичного іспиту також скорочує час, необхідний для отримання водійських прав. Раніше кандидати були зобов’язані відвідувати курси в автошколах, які могли тривати кілька місяців. Тепер же, якщо людина вже володіє знаннями або швидко засвоює матеріал, вона може скласти іспит значно швидше. Це дозволяє уникнути довгих черг в автошколах та забезпечує більш оперативний процес отримання водійського посвідчення.</p> <h2>Виклики нової системи</h2> <p>Проте спрощення вимог до теоретичного навчання може мати як позитивні, так і негативні наслідки. Деякі експерти вважають, що недостатня підготовка теоретичної частини може призвести до підвищеного ризику на дорогах. Незважаючи на це, держава розраховує на відповідальність майбутніх водіїв, а також на розвиток сучасних інструментів для самостійного навчання. Зокрема, розроблено численні додатки та онлайн-платформи, які дозволяють ефективно та якісно готуватися до теоретичних іспитів.</p><h2>Відгуки громадськості</h2> <p>Зміни в процесі підготовки до іспитів викликали різні реакції в суспільстві. Багато людей вважають, що спрощення умов навчання полегшить доступ до водійських прав і позитивно вплине на мобільність громадян. Водночас є й ті, хто висловлює занепокоєння через можливість зниження загального рівня знань серед нових водіїв. У відповідь на це Міністерство внутрішніх справ заявляє, що система буде постійно контролюватися, а кількість аварій з вини новачків буде аналізуватися, щоб оцінити ефективність нових правил.</p><h2>Очікувані результати</h2> <p>Запроваджені зміни можуть сприяти не лише зменшенню витрат часу і коштів для майбутніх водіїв, але й зниженню навантаження на автошколи та підвищенню доступності водійських прав для широкого кола громадян. Доступність та демократизація навчання на права, зокрема, дозволяють розширити коло тих, хто може законно керувати транспортним засобом, не вдаючись до послуг дорогих курсів. Завдяки цьому у майбутньому очікується підвищення загального рівня мобільності в країні, що особливо актуально для регіонів, де якісні автошколи можуть бути обмежені або недоступні. Таким чином, спрощення процесу складання теоретичних іспитів у 2024 році можна вважати кроком до більш доступного і демократичного процесу отримання водійських прав в Україні.</p>')
;

INSERT INTO article_category VALUES
    ('article-1', 'category-1'),
    ('article-1', 'category-2'),
    ('simplification-of-the-drivers-license-examination-process', 'traffic'),
    ('article-2', 'category-2'),
    ('article-3','category-1'),
    ('article-4','category-1'),
    ('article-5','category-2'),
    ('article-6','category-2'),
    ('article-7','category-2'),
    ('article-8','traffic'),
    ('article-9','traffic'),
    ('article-10','traffic'),
    ('article-11','category-1'),
    ('article-12','category-1'),
    ('article-13','category-2'),
    ('article-14','category-2'),
    ('article-15','category-1'),
    ('article-16','category-2'),
    ('article-17','category-1'),
    ('article-18','traffic'),
    ('article-19','traffic'),
    ('article-20','category-2'),
    ('article-21','category-2')
;
COMMIT;

--getById query - ./article/getById.sql