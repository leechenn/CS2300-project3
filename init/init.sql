
CREATE TABLE user (
  user_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  user_name TEXT NOT NULL UNIQUE,
  user_password TEXT NOT NULL,
  user_session TEXT UNIQUE
);

CREATE TABLE image (
  image_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  user_id INTEGER NOT NULL,
  upload_date TEXT NOT NULL,
  image_name TEXT NOT NULL,
  file_name TEXT NOT NULL,
  file_ext TEXT NOT NULL,
  image_description TEXT,
  CONSTRAINT fk_user
  FOREIGN KEY(user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE tag (
  tag_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  tag_name TEXT NOT NULL UNIQUE
);

CREATE TABLE tag_image (
  tag_id INTEGER NOT NULL,
  image_id INTEGER NOT NULL,
  PRIMARY KEY(tag_id, image_id),
  CONSTRAINT fk_tag
  FOREIGN KEY(tag_id) REFERENCES tag(tag_id) ON DELETE CASCADE,
  CONSTRAINT fk_image
  FOREIGN KEY(image_id) REFERENCES image(image_id) ON DELETE CASCADE
);


/* seed data */
INSERT INTO user (user_name, user_password) VALUES ('chen', '$2y$10$BwOs1mePY6SUiM8ADayt2Oj8bMCZDWCgx6QW/aqWfcaqtHR2SHOmS');
-- password:lc1993124
INSERT INTO user (user_name, user_password) VALUES ('yun', '$2y$10$4ViqEdlsgLNyOhE7rDp2GuGsZ4BtfggyVLHX/eynXxJTq8rn/ccPO');
-- password:sqy123

INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (1,'2018-3-27','sunset','1.jpg', 'jpg', 'enjoy the sunset when back from NanJing to my home');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (1,'2018-3-27','lotus','2.jpg', 'jpg', 'lotus');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (1,'2018-3-27','grand canyon','3.jpg', 'jpg', 'grand canyon view in national park');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (1,'2018-3-27','death valley','4.jpg', 'jpg', 'lonely death valley');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (1,'2018-3-27','brothers','5.jpg', 'jpg', 'Cancun with my friends');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (1,'2018-3-27','road 1','6.jpg', 'jpg', 'road one driving');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (1,'2018-3-27','Antelope Canyon','7.jpg', 'jpg', 'catch this strange and beautiful color');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (1,'2018-3-27','maple forest','8.jpg', 'jpg', 'wish this couple love forever');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','Mayday','9.jpg', 'jpg', 'Mayday concert in NanJing');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','beach','10.jpg', 'jpg', 'white beach in Thailand');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','line','11.jpg', 'jpg', 'line');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','new year','12.jpg', 'jpg', 'welcome new year 2017');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','flower','13.jpg', 'jpg', 'flowers');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','light','14.jpg', 'jpg', 'light in dark');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','thai','15.jpg', 'jpg', 'my lovely back');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','wen huan road','16.jpg', 'jpg', 'Wenhuan road, all memory here in NanJing');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','moon','17.jpg', 'jpg', 'catch the moon at Mid-Autumn Festival');
INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (2,'2018-3-27','lake','18.jpg', 'jpg', 'peaceful lake');
INSERT INTO tag(tag_name) VALUES ('canyon');
INSERT INTO tag(tag_name) VALUES ('road');
INSERT INTO tag(tag_name) VALUES ('concert');
INSERT INTO tag(tag_name) VALUES ('flower');
INSERT INTO tag(tag_name) VALUES ('beach');
INSERT INTO tag(tag_name) VALUES ('nature');
INSERT INTO tag(tag_name) VALUES ('singer');
INSERT INTO tag(tag_name) VALUES ('girl');
INSERT INTO tag(tag_name) VALUES ('friend');
INSERT INTO tag(tag_name) VALUES ('night');
INSERT INTO tag(tag_name) VALUES ('portrait');
INSERT INTO tag(tag_name) VALUES ('light');
INSERT INTO tag(tag_name) VALUES ('sea');
INSERT INTO tag(tag_name) VALUES ('moon');
INSERT INTO tag(tag_name) VALUES ('sunset');
INSERT INTO tag(tag_name) VALUES ('love');
INSERT INTO tag(tag_name) VALUES ('lake');
INSERT INTO tag(tag_name) VALUES ('boat');
INSERT INTO tag_image(image_id,tag_id) VALUES (1,15);
INSERT INTO tag_image(image_id,tag_id) VALUES (2,4);
INSERT INTO tag_image(image_id,tag_id) VALUES (2,6);
INSERT INTO tag_image(image_id,tag_id) VALUES (3,1);
INSERT INTO tag_image(image_id,tag_id) VALUES (3,6);
INSERT INTO tag_image(image_id,tag_id) VALUES (4,1);
INSERT INTO tag_image(image_id,tag_id) VALUES (4,6);
INSERT INTO tag_image(image_id,tag_id) VALUES (5,5);
INSERT INTO tag_image(image_id,tag_id) VALUES (5,9);
INSERT INTO tag_image(image_id,tag_id) VALUES (5,13);
INSERT INTO tag_image(image_id,tag_id) VALUES (6,2);
INSERT INTO tag_image(image_id,tag_id) VALUES (6,11);
INSERT INTO tag_image(image_id,tag_id) VALUES (7,1);
INSERT INTO tag_image(image_id,tag_id) VALUES (7,6);
INSERT INTO tag_image(image_id,tag_id) VALUES (8,6);
INSERT INTO tag_image(image_id,tag_id) VALUES (8,16);
INSERT INTO tag_image(image_id,tag_id) VALUES (9,3);
INSERT INTO tag_image(image_id,tag_id) VALUES (9,7);
INSERT INTO tag_image(image_id,tag_id) VALUES (10,5);
INSERT INTO tag_image(image_id,tag_id) VALUES (10,6);
INSERT INTO tag_image(image_id,tag_id) VALUES (10,13);
INSERT INTO tag_image(image_id,tag_id) VALUES (12,2);
INSERT INTO tag_image(image_id,tag_id) VALUES (13,4);
INSERT INTO tag_image(image_id,tag_id) VALUES (14,10);
INSERT INTO tag_image(image_id,tag_id) VALUES (14,12);
INSERT INTO tag_image(image_id,tag_id) VALUES (15,8);
INSERT INTO tag_image(image_id,tag_id) VALUES (16,2);
INSERT INTO tag_image(image_id,tag_id) VALUES (17,14);
INSERT INTO tag_image(image_id,tag_id) VALUES (17,10);
INSERT INTO tag_image(image_id,tag_id) VALUES (17,12);
INSERT INTO tag_image(image_id,tag_id) VALUES (18,17);
INSERT INTO tag_image(image_id,tag_id) VALUES (18,18);
