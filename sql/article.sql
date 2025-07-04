CREATE table article 
(
    identifier text UNIQUE NOT NULL PRIMARY KEY,
    active boolean NOT NULL DEFAULT false,
    author_id int NOT NULL REFERENCES author (identifier) ON UPDATE CASCADE,
    img_id int REFERENCES img (identifier) ON UPDATE CASCADE,
    audio_id int REFERENCES audio (identifier) ON UPDATE CASCADE,
    created_at timestamp NOT NULL DEFAULT current_timestamp,
    updated_at timestamp NOT NULL DEFAULT current_timestamp,
    views int NOT NULL CHECK (views >= 0),
    CONSTRAINT views_check check (views >=0)
);

CREATE table article_translates 
(
    article_id text NOT NULL REFERENCES article (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
    language text NOT NULL REFERENCES language (identifier) ON UPDATE CASCADE,
    name text NOT NULL UNIQUE,
    short_description NOT NULL text,
    description NOT NULL text,
    updated_at timestamp NOT NULL DEFAULT current_timestamp,
    CONSTRAINT pk_article_translates PRIMARY KEY (article_id, language)
);

CREATE table article_category 
(
    article_id text NOT NULL REFERENCES article (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
    category_id text NOT NULL REFERENCES category (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT pk_article_category PRIMARY KEY (article_id, category_id)
    article_category_category_id_fkey
);
