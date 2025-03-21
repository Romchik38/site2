CREATE table language
(
    identifier text PRIMARY KEY,
    active boolean NOT NULL DEFAULT false
);

INSERT INTO language (identifier) VALUES
    ('en'), 
    ('uk')
;