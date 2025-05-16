create role "apache" LOGIN;
GRANT connect on database site2 to "apache";

GRANT select, insert, update on table admin_roles, admin_users, admin_users_with_roles to "apache";
GRANT select, insert, update on table article, article_translates, article_category to "apache";
GRANT select, insert, update on table audio, audio_translates to "apache";
GRANT select, insert, update on table author, author_translates to "apache";
GRANT select, insert, update on table category, category_translates to "apache";
GRANT select, insert, update on table img, img_translates to "apache";
GRANT select, insert, update on table img_cache to "apache";
GRANT select, insert, update on table language to "apache";
GRANT select, insert, update on table links, links_translates to "apache";
GRANT select, insert, update on table translate_entities to "apache";
GRANT select, insert, update on table translate_keys to "apache";
