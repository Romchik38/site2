CREATE table banner 
(
    identifier serial NOT NULL PRIMARY KEY,
    active boolean NOT NULL DEFAULT false,
    name text NOT NULL,
    img_id int NOT NULL REFERENCES img (identifier) ON UPDATE CASCADE
);

-- for use in view repository
SELECT banner.identifier,
    banner.active,
    banner.name,
    banner.img_id,
    img.active as image_active,
    img_translates.description as image_description
FROM banner,
    img,
    img_translates
WHERE banner.img_id = img.identifier AND
    img_translates.language = $1 AND
    img_translates.img_id = img.identifier