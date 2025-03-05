# Postgres readme

1. A database *site2* will be created auto
2. Inside posgres container use command `psql -U postgres -d site2 < /dump/site2.sql` to create tables and fill data
3. Use `pg_dump -U postgres site2 > /home/postgres/site2.sql` to create a copy of the database
