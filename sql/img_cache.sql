CREATE TABLE img_cache
(
    key text NOT NULL PRIMARY KEY,
    data text NOT NULL,
    type text NOT NULL CHECK ( type IN ('webp'))
);