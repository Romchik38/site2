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
    ('article.view.similar'),
    ('article.view.continue.reading'),
    ('article.view.month.January'),
    ('article.view.month.February'),
    ('article.view.month.March'),
    ('article.view.month.April'),
    ('article.view.month.May'),
    ('article.view.month.June'),
    ('article.view.month.July'),
    ('article.view.month.August'),
    ('article.view.month.September'),
    ('article.view.month.October'),
    ('article.view.month.November'),
    ('article.view.month.December'),
    ('article.category'),
    ('root.page_name'),
    ('root.about'),
    ('root.contacts'),
    ('server-error.header'),
    ('server-error.message'),
    ('server-error-example.page_name'),
    ('sitemap.page_name'),
    ('sitemap.description'),
    ('404.header'),
    ('404.message'),
    ('404.page_name'),
    ('404.description'),
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

