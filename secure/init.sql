BEGIN TRANSACTION;

CREATE TABLE images (
	id	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    file_name TEXT NOT NULL,
    file_ext TEXT NOT NULL,
 	album_name	TEXT NOT NULL,
    artist TEXT NOT NULL,
    source TEXT
);

    -- To Pimp a Butterfly: https://pitchfork.com/reviews/albums/20390-to-pimp-a-butterfly/
    -- Rodeo: https://www.amazon.com/Rodeo-Travis-Scott/dp/B013LTUKBU
    -- Coloring Book: https://pitchfork.com/reviews/albums/21909-coloring-book/
    -- The Life of Pablo: https://en.wikipedia.org/wiki/The_Life_of_Pablo
    -- Culture: https://genius.com/albums/Migos/Culture
    -- LUV is Rage 2: https://genius.com/albums/Lil-uzi-vert/Luv-is-rage-2
    -- Astroworld: https://genius.com/albums/Travis-scott/Astroworld
    -- Scorpion: https://genius.com/albums/Drake/Scorpion
    -- Death Race for Love: https://genius.com/albums/Juice-wrld/Death-race-for-love
    -- So Much Fun: https://genius.com/albums/Young-thug/So-much-fun
    -- Eternal Atake: https://genius.com/albums/Lil-uzi-vert/Eternal-atake
    -- Music to be Murdered By: https://genius.com/albums/Eminem/Music-to-be-murdered-by

INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('astroworld', '.jpg', 'Astroworld', 'Travis Scott','https://genius.com/albums/Travis-scott/Astroworld');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('coloringbook', '.jpg', 'Coloring Book', 'Chance the Rapper','https://pitchfork.com/reviews/albums/21909-coloring-book/');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('culture', '.jpg', 'Culture', 'Migos', 'https://genius.com/albums/Migos/Culture');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('drfl', '.jpg', 'Death Race for Love', 'Juice WRLD', 'https://genius.com/albums/Juice-wrld/Death-race-for-love');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('ea', '.jpg', 'Eternal Atake', 'Lil Uzi Vert','https://genius.com/albums/Lil-uzi-vert/Eternal-atake');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('luvisrage2', '.png', 'LUV is Rage 2', 'Lil Uzi Vert','https://genius.com/albums/Lil-uzi-vert/Luv-is-rage-2');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('mtbmb', '.jpg', 'Music to Be Murdered By', 'Eminem','https://genius.com/albums/Eminem/Music-to-be-murdered-by');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('pablo', '.jpg', 'The Life of Pablo', 'Kanye West','https://en.wikipedia.org/wiki/The_Life_of_Pablo');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('rodeo', '.jpg', 'Rodeo', 'Travis Scott','https://www.amazon.com/Rodeo-Travis-Scott/dp/B013LTUKBU');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('scorpion', '.jpg', 'Scorpion', 'Drake','https://genius.com/albums/Drake/Scorpion');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('somuchfun', '.png', 'So Much Fun', 'Young Thug','https://genius.com/albums/Young-thug/So-much-fun');
INSERT INTO images (file_name, file_ext, album_name, artist, source) VALUES ('tpab', '.jpg', 'To Pimp a Butterfly', 'Kendrick Lamar','https://pitchfork.com/reviews/albums/20390-to-pimp-a-butterfly/');

CREATE TABLE tags (
	id	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    name TEXT NOT NULL
);

INSERT INTO tags (name) VALUES ('2015'); --1
INSERT INTO tags (name) VALUES ('2016'); --2
INSERT INTO tags (name) VALUES ('2017'); --3
INSERT INTO tags (name) VALUES ('2018'); --4
INSERT INTO tags (name) VALUES ('2019'); --5
INSERT INTO tags (name) VALUES ('2020'); --6

INSERT INTO tags (name) VALUES ('Melodic rap'); --7
INSERT INTO tags (name) VALUES ('Lyrical rap');  --8
INSERT INTO tags (name) VALUES ('Trap'); --9
INSERT INTO tags (name) VALUES ('Pop rap'); --10

INSERT INTO tags (name) VALUES ('Award winning'); --11
INSERT INTO tags (name) VALUES ('#1 Debut'); --12

CREATE TABLE image_tags (
	id	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    image_id INTEGER NOT NULL,
    tag_id INTEGER NOT NULL
);

INSERT INTO image_tags (image_id, tag_id) VALUES ('1','4');
INSERT INTO image_tags (image_id, tag_id) VALUES ('1','7');
INSERT INTO image_tags (image_id, tag_id) VALUES ('1','10');
INSERT INTO image_tags (image_id, tag_id) VALUES ('1','11');
INSERT INTO image_tags (image_id, tag_id) VALUES ('1','12');

INSERT INTO image_tags (image_id, tag_id) VALUES ('2','2');
INSERT INTO image_tags (image_id, tag_id) VALUES ('2','7');
INSERT INTO image_tags (image_id, tag_id) VALUES ('2','10');
INSERT INTO image_tags (image_id, tag_id) VALUES ('2','11');

INSERT INTO image_tags (image_id, tag_id) VALUES ('3','3');
INSERT INTO image_tags (image_id, tag_id) VALUES ('3','7');
INSERT INTO image_tags (image_id, tag_id) VALUES ('3','9');
INSERT INTO image_tags (image_id, tag_id) VALUES ('3','12');

INSERT INTO image_tags (image_id, tag_id) VALUES ('4','5');
INSERT INTO image_tags (image_id, tag_id) VALUES ('4','7');
INSERT INTO image_tags (image_id, tag_id) VALUES ('4','12');

INSERT INTO image_tags (image_id, tag_id) VALUES ('5','6');
INSERT INTO image_tags (image_id, tag_id) VALUES ('5','7');
INSERT INTO image_tags (image_id, tag_id) VALUES ('5','8');
INSERT INTO image_tags (image_id, tag_id) VALUES ('5','9');
INSERT INTO image_tags (image_id, tag_id) VALUES ('5','12');

INSERT INTO image_tags (image_id, tag_id) VALUES ('6','3');
INSERT INTO image_tags (image_id, tag_id) VALUES ('6','7');
INSERT INTO image_tags (image_id, tag_id) VALUES ('6','8');
INSERT INTO image_tags (image_id, tag_id) VALUES ('6','9');
INSERT INTO image_tags (image_id, tag_id) VALUES ('6','12');

INSERT INTO image_tags (image_id, tag_id) VALUES ('7','6');
INSERT INTO image_tags (image_id, tag_id) VALUES ('7','8');
INSERT INTO image_tags (image_id, tag_id) VALUES ('7','12');

INSERT INTO image_tags (image_id, tag_id) VALUES ('8','2');
INSERT INTO image_tags (image_id, tag_id) VALUES ('8','8');
INSERT INTO image_tags (image_id, tag_id) VALUES ('8','12');

INSERT INTO image_tags (image_id, tag_id) VALUES ('9','1');
INSERT INTO image_tags (image_id, tag_id) VALUES ('9','7');

INSERT INTO image_tags (image_id, tag_id) VALUES ('10','4');
INSERT INTO image_tags (image_id, tag_id) VALUES ('10','10');
INSERT INTO image_tags (image_id, tag_id) VALUES ('10','11');
INSERT INTO image_tags (image_id, tag_id) VALUES ('10','12');

INSERT INTO image_tags (image_id, tag_id) VALUES ('11','5');
INSERT INTO image_tags (image_id, tag_id) VALUES ('11','7');
INSERT INTO image_tags (image_id, tag_id) VALUES ('11','12');

INSERT INTO image_tags (image_id, tag_id) VALUES ('12','1');
INSERT INTO image_tags (image_id, tag_id) VALUES ('12','8');
INSERT INTO image_tags (image_id, tag_id) VALUES ('12','11');
INSERT INTO image_tags (image_id, tag_id) VALUES ('12','12');

COMMIT;
