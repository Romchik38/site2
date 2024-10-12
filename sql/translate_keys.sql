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
    --footer
    ('footer.copyright'),
    ('footer.by_romanenko'),
    --header
    ('header.logo'),
    ('header.phone_number'),
    ('header.sing_in'),
    ('header.register')
;

