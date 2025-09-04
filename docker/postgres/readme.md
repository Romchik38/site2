# Postgres readme

## Install

1. The database `site2` will be created auto via `docker compose up -d --build`
2. `Inside` the postgres container use command `psql -U postgres -d site2 < /dump/site2.sql` to create tables and fill data.
3. Create a dir `private` inside `app/config/` and add a file with code:

    ```php
    <?php

    declare(strict_types=1);

    return [
        'database.postgres.connect.main' => 'host=postgres dbname=site2 user=postgres password=Change_it'
    ];
    ```

4. Do not forget change password `Change_it` in the file above and in the docker config

5. Change admin user passwords from table `admin_users` manually. See domain model `AdminUser` how password verifies to create hashes. Read [admin docs](./../../doc/admin/readme.md)

6. Dictionary [files](./dict/) will be copied auto.

7. If `uk` search doesn't find anything expected run sql script `sql/uk-dict/dictionary.sql`
    `psql -U postgres -d site2 < dictionary.sql`

## Dump

Use `pg_dump -U postgres site2 > /home/postgres/site2.sql` to create a copy of the database.

## Dict help

How to create dictionaries from *dict/*. Dictionaries were generated on July 2025. If you need the latest version, go to links below and follow steps.

- [dict_uk](https://github.com/brown-uk/dict_uk)
- [howto](https://github.com/brown-uk/dict_uk/tree/master/distr/postgresql)

1. Clone the repository

2. Run ./gradlew expand

3. Navigate to cd distr/hunspell/ and run ../../gradlew hunspell

4. Copy the files and follow everything from the howto (see #3):

    ```bash
    sudo cp build/hunspell/uk_UA.aff /usr/share/pgsql/tsearch_data/uk_ua.affix  
    sudo cp build/hunspell/uk_UA.dic /usr/share/pgsql/tsearch_data/uk_ua.dict  
    sudo cp ../postgresql/ukrainian.stop /usr/share/pgsql/tsearch_data/ukrainian.stop  
    ```

   Path `/usr/share/pgsql/tsearch_data` is relevant in `Fedora42`.

5. Verify:

    ls /usr/share/pgsql/tsearch_data | grep uk  

6. Connect to the specific database and run everything needed to create the configuration