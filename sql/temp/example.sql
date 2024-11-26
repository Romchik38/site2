--IMG
INSERT INTO img (identifier, name, author_id, path) VALUES
    (3, 'evidence-in-administrative-offense-cases-key-aspects', 1, 'articles/dokazi-po-spravi/dokazi-po-spravi-1080.webp')
;

INSERT INTO img_translates (img_id, language, description) VALUES
    ('3', 'en', 'Evidence in Administrative Offense Cases: Key Aspects'),
    ('3', 'uk', 'Докази по справі про адміністративне правопорушення: ключові аспекти')
;

--ARTICLE
UPDATE article 
    set active = 't', 
        img_id = 3,
        identifier = 'evidence-in-administrative-offense-cases-key-aspects'
WHERE identifier = 'article-1'
;

--ARTICLE TRANSLATES
UPDATE article_translates 
    set name = 'Evidence in Administrative Offense Cases: Key Aspects', 
        short_description = 'Definition and Types of Evidence, Evidence Collection Process, Evaluation.',
        description = ''
WHERE article_id = 'evidence-in-administrative-offense-cases-key-aspects'
    AND language = 'en'
;

UPDATE article_translates 
    set name = 'Докази по справі про адміністративне правопорушення: ключові аспекти', 
        short_description = 'Докази у справі про адміністративне правопорушення є основним інструментом для встановлення об’єктивної істини та прийняття законного і обґрунтованого рішення.',
        description = ''
WHERE article_id = 'evidence-in-administrative-offense-cases-key-aspects'
    AND language = 'uk'
;

--AUDIO
INSERT INTO article_audio_translates (article_id, language, description, path) VALUES
    ('evidence-in-administrative-offense-cases-key-aspects', 'en', 'Evidence in Administrative Offense Cases: Key Aspects', 'articles/evidence-in-administrative-offense-cases-key-aspects/en-evidence-in-administrative-offense-cases-key-aspects.mp3'),
    ('evidence-in-administrative-offense-cases-key-aspects', 'uk', 'Докази по справі про адміністративне правопорушення: ключові аспекти', 'articles/evidence-in-administrative-offense-cases-key-aspects/uk-evidence-in-administrative-offense-cases-key-aspects.mp3')
;