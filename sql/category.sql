CREATE table category
(
        identifier text UNIQUE NOT NULL,
        active boolean NOT NULL DEFAULT false
    );

CREATE table
    category_translates (
        category_id text NOT NULL REFERENCES category (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
        language text NOT NULL REFERENCES language (identifier) ON UPDATE CASCADE,
        name text NOT NULL UNIQUE,
        description text NOT NULL,
        CONSTRAINT pk_category_translates PRIMARY KEY (category_id, language)
    );


