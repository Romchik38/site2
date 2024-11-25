CREATE TABLE img_cache
(
    key text NOT NULL PRIMARY KEY,
    data text NOT NULL,
    type text NOT NULL CHECK ( type IN ('webp')),
    created_at timestamp NOT NULL DEFAULT current_timestamp
);