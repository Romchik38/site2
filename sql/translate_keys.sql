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
    ('article.h2.publications'),
    ('article.read'),
    ('article.view.seeall'),
    ('article.view.photo-by'),
    ('article.view.by'),
    ('root.page_name'),
    ('root.about'),
    ('root.contacts'),
    ('server-error.header'),
    ('server-error.message'),
    ('404.header'),
    ('404.message'),
    --header
    ('header.logo'),
    ('header.sing_in'),
    ('header.subscribe'),
    ('header.link.sitemap'),
    --footer
    ('footer.copyright'),
    ('footer.by_romanenko'),
    --service
    ('read-length-formatter.a-few-minutes'),
    ('read-length-formatter.min'),
    ('read-length-formatter.hour'),
    ('read-length-formatter.day')
;

