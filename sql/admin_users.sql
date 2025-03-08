CREATE table admin_users
(
    identifier serial NOT NULL PRIMARY KEY,
    username text UNIQUE NOT NULL,
    password_hash text NOT NULL,
    active boolean NOT NULL DEFAULT false,
    email text UNIQUE NOT NULL
);


CREATE table admin_roles
(
    identifier serial NOT NULL PRIMARY KEY,
    name text NOT NULL UNIQUE,
    description text NOT NULL
);

CREATE table admin_users_with_roles
(
    user_id int NOT NULL REFERENCES admin_users (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
    role_id int NOT NULL REFERENCES admin_roles (identifier) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT pk_admin_users_roles PRIMARY KEY (user_id, role_id)
);

INSERT INTO admin_users (identifier, username, password_hash, active, email)
    VALUES 
    (
        1,
        'admin', 
        '$2y$10$wyrush/aig9nQd3DVZvjuudH/FOIA.II2k1y64ZlYlbodcM8jK5sC',
        't',
        'admin@example.com'
    ),
    (
        2,
        'admin2', 
        '$2y$10$imdQM8v2LJ.G2la8xIcSSuyypMX8UWf63JncAgIAdJzI2Ioe/Wk2K',
        't',
        'admin2@example.com'
    )
;

INSERT INTO admin_roles (identifier, name, description)
    VALUES 
    (1, 'ADMIN_ROOT', 'Can do anything'), 
    (2, 'ADMIN_LOGIN', 'Can login into');
;

INSERT INTO admin_users_with_roles (user_id, role_id)
    VALUES (1, 1), (2, 2)
;