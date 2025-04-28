# Postgres readme

## Install

1. The database *site2* will be created auto
2. Inside posgres container use command `psql -U postgres -d site2 < /dump/site2.sql` to create tables and fill data
3. Create a file `app/config/private/database.php` with code:

    ```php
    <?php

    declare(strict_types=1);

    return [
        'database.postgres.connect.main' => 'host=postgres dbname=site2 user=postgres password=Change_it'
    ];
    ```

4. Do not forget change password `Change_it` in the file above and in the docker config
5. Change admin user passwords from table `admin_users` manually. See domain model `AdminUser` how password verifies to create hashes.

## Dump

Use `pg_dump -U postgres site2 > /home/postgres/site2.sql` to create a copy of the database
