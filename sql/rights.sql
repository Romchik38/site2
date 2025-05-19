create role "apache" LOGIN;
GRANT connect on database site2 to "apache";

GRANT select, insert, update, delete on table admin_roles, admin_users, admin_users_with_roles to "apache";
GRANT select, insert, update, delete on table article, article_translates, article_category to "apache";
GRANT select, insert, update, delete on table audio, audio_translates to "apache";
GRANT select, insert, update, delete on table author, author_translates to "apache";
GRANT select, insert, update, delete on table category, category_translates to "apache";
GRANT select, insert, update, delete on table img, img_translates to "apache";
GRANT select, insert, update, delete on table img_cache to "apache";
GRANT select, insert, update, delete on table language to "apache";
GRANT select, insert, update, delete on table links, links_translates to "apache";
GRANT select, insert, update, delete on table translate_entities to "apache";
GRANT select, insert, update, delete on table translate_keys to "apache";
