CREATE table translate_keys
(
    key text PRIMARY KEY
);

INSERT INTO translate_keys (key) VALUES
    --global
    ('global.language'),
    --controller
    ('article.page_name'),
    ('article.description'),
    ('root.page_name'),
    ('server-error.header'),
    ('server-error.message'),
    ('root.about'),
    ('root.contacts'),
    ('404.header'),
    ('404.message'),
    --header
    ('header.logo'),
    ('header.sing_in'),
    ('header.subscribe'),
    --footer
    ('footer.copyright'),
    ('footer.by_romanenko')
;

