CREATE table translate_keys
(
    key text PRIMARY KEY
);

INSERT INTO translate_keys (key) VALUES
    --global
    ('global.language'),
    --controller
    ('root.page_name'),
    ('server-error.message'),
    ('root.about'),
    ('root.contacts'),
    ('404.h1'),
    ('404.p'),
    --header
    ('header.logo'),
    ('header.sing_in'),
    ('header.subscribe'),
    --footer
    ('footer.copyright'),
    ('footer.by_romanenko')
;

