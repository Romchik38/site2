create role "service" LOGIN;

GRANT connect on database site2 to "service";

GRANT select, insert, update on table translate_entities to "service";
GRANT select, insert, update on table translate_keys to "service";
GRANT select, insert, update on table translate_lang to "service";
GRANT select, insert, update on table links, links_translates to "service";

GRANT select, insert, update on table 
    article, article_translates, article_category 
    to "service";

GRANT select, insert, update on table 
    category, category_translates
    to "service";
