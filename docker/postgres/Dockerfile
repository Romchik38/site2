FROM postgres:latest

COPY scripts/site2.sql scripts/database.sql /dump/
COPY scripts/database.sql /docker-entrypoint-initdb.d/