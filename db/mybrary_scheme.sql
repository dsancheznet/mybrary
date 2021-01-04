BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS `users` (
	`username`	TEXT NOT NULL,
	`md5pass`	TEXT NOT NULL,
	`role`	INTEGER NOT NULL,
	`avatar`	TEXT,
	`name`	TEXT,
	PRIMARY KEY(`username`)
);
CREATE TABLE IF NOT EXISTS `tags2books` (
	`book`	INTEGER NOT NULL,
	`tag`	INTEGER NOT NULL
);
CREATE TABLE IF NOT EXISTS `tags` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`caption`	INTEGER NOT NULL UNIQUE
);
CREATE TABLE IF NOT EXISTS `books` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`uuid`	TEXT NOT NULL UNIQUE,
	`isbn`	TEXT UNIQUE,
	`title`	TEXT UNIQUE,
	`summary`	TEXT,
	`author`	TEXT,
	`type`	TEXT,
	`uploader`	TEXT NOT NULL
);
INSERT INTO users (username, md5pass, role, avatar, name) VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 7, '072-police-officer-1.svg', 'System Administrator');
INSERT INTO "tags2books" VALUES (1,1);
INSERT INTO "tags" VALUES (1,'🇬🇧');
INSERT INTO "books" VALUES (1,'00000000-0000-0000-0000-0000000000EN',NULL,'mybrary User Manual v0.2','#### mybrary user and administration reference manual.

You may delete this file if you are familiar with the use of mybrary.

English version.','D.Sánchez','pdf','admin');
COMMIT;
