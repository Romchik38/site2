FROM postgres:17

COPY scripts/site2.sql scripts/database.sql /dump/
COPY scripts/database.sql /docker-entrypoint-initdb.d/
COPY dict /usr/share/postgresql/17/tsearch_data