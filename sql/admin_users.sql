CREATE table admin_users
(
    identifier serial NOT NULL PRIMARY KEY,
    user_name text UNIQUE NOT NULL,
    password text NOT NULL,
    active boolean NOT NULL DEFAULT false,
    person_id int REFERENCES person (identifier) ON UPDATE CASCADE ON DELETE CASCADE,
    email text UNIQUE NOT NULL
);

