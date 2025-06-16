CREATE table banner 
(
    identifier serial NOT NULL PRIMARY KEY,
    active boolean NOT NULL DEFAULT false,
    name text NOT NULL,
    img_id int REFERENCES img (identifier) ON UPDATE CASCADE
);