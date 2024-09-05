create role "service" LOGIN;

GRANT connect on database site2 to "service";

GRANT select, insert, update on table translate_entities to "service";
GRANT select, insert, update on table translate_keys to "service";
GRANT select, insert, update on table translate_lang to "service";

