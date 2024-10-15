CREATE table
    links (
        -- link with id 0 is a default parent link and shouldn't be displayed
        -- so 0 can't be in menu_to_links.link_id
        link_id serial PRIMARY KEY,
        name text NOT NULL UNIQUE,
        description text NOT NULL,
        url text[] UNIQUE
    );

CREATE table
    links_translates (
        link_id int NOT NULL REFERENCES links (link_id) ON DELETE CASCADE,
        language text NOT NULL REFERENCES translate_lang (language) ON DELETE CASCADE,
        CONSTRAINT pk_links_translates PRIMARY KEY (link_id, language)
    );

INSERT INTO links (link_id, name, description, url)
    VALUES (0, 'default', 'default', '{}');

BEGIN;
    INSERT INTO links (link_id, name, description, url)
        VALUES 
            (1, 'Home', 'Home Page', '{"en"}'),
            (2, 'Головна', 'Головна сторінка', '{"uk"}')
    ;
    INSERT INTO links_translates (link_id, language)
        VALUES
            (1, 'en'),
            (1, 'uk')
    ;
COMMIT;

--EXAMPLE
SELECT links.link_id, links.name, links.description, links.url
    FROM links, links_translates
    WHERE links.link_id = links_translates.link_id AND
        links_translates.language = 'en'
;