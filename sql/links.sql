CREATE table
    links (
        -- link with id 0 is a default parent link and shouldn't be displayed
        -- so 0 can't be in menu_to_links.link_id
        link_id serial PRIMARY KEY,
        path text[] UNIQUE
    );

CREATE table
    links_translates (
        link_id int NOT NULL REFERENCES links (link_id) ON DELETE CASCADE,
        language text NOT NULL REFERENCES language (identifier) ON DELETE CASCADE,
        name text NOT NULL UNIQUE,
        description text NOT NULL,
        CONSTRAINT pk_links_translates PRIMARY KEY (link_id, language)
    );

INSERT INTO links (link_id, path)
    VALUES (0, '{}');

INSERT INTO links (link_id, path) VALUES 
        (1, '{"root"}'),
        (2, '{"root", "about"}'),
        (3, '{"root", "sitemap"}'),
        (4, '{"root", "server-error-example"}'),
        (5, '{"root", "article"}')
;

INSERT INTO links_translates (link_id, language, name, description)
    VALUES
        (1, 'en', 'Home', 'Home Page'),
        (1, 'uk', 'Головна', 'Головна сторінка'),
        (2, 'en', 'About', 'About Page'),
        (2, 'uk', 'Про компанію', 'Сторінка про компанію'),
        (3, 'en', 'Sitemap', 'Sitemap Page - all links on one page'),
        (3, 'uk', 'Мапа сайту', 'Мапа сайту - усі посилання на одній сторінці'),
        (4, 'en', 'Server error example', 'Server error example page'),
        (4, 'uk', 'Приклад помилки серверу', 'Приклад сторінки помилки серверу'),
        (5, 'en', 'Article', 'Article page'),
        (5, 'uk', 'Матеріли', 'Матеріли на тему адміністративного права')
;

--EXAMPLE
SELECT links.path, links_translates.*
    FROM links, links_translates
        WHERE links.link_id = links_translates.link_id AND
            links_translates.language = 'en'
;