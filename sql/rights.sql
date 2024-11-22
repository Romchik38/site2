create role "apache" LOGIN;

GRANT connect on database site2 to "apache";

GRANT select, insert, update on table translate_entities to "apache";
GRANT select, insert, update on table translate_keys to "apache";
GRANT select, insert, update on table translate_lang to "apache";
GRANT select, insert, update on table links, links_translates to "apache";

GRANT select, insert, update on table 
    article, article_translates, article_category 
    to "apache";

GRANT select, insert, update on table 
    category, category_translates
    to "apache";

GRANT select, insert, update on table 
    person, person_translates
    to "apache";

GRANT select, insert, update on table img, img_translates to "apache";