CREATE table admin_users
(
    identifier serial NOT NULL PRIMARY KEY,
    user_name text UNIQUE NOT NULL,
    password text NOT NULL,
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

INSERT INTO admin_users (identifier, user_name, password, active, email)
    VALUES 
    (
        1,
        'admin', 
        --123
        '$2y$10$HtXhkHrQmpd8Tq094NTOheWg5Idx74np2EkU7/SU32218zQZFhTPm',
        't',
        'admin@localhost'
    ),
    (
        2,
        'admin2', 
        --1234
        '2y$10$4DkPGEKbUgpVRPoTIOjNve8hlRCW3/FXbg1x.Lh.QwLFYowlbQML2',
        't',
        'admin2@localhost'
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