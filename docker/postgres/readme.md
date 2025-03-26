# Postgres readme

1. A database *site2* will be created auto
2. Inside posgres container use command `psql -U postgres -d site2 < /dump/site2.sql` to create tables and fill data
3. Use `pg_dump -U postgres site2 > /home/postgres/site2.sql` to create a copy of the database
4. Create a file `app/config/private/database.php` with code:

    ```php
    <?php

    declare(strict_types=1);

    return 'host=postgres dbname=site2 user=postgres password=Change_it';
    ```

5. Do not forget change password `Change_it` in the file above and in the docker config
