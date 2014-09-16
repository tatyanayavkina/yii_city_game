
CREATE TABLE tbl_city (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstLetter CHAR(8) NOT NULL,
    name VARCHAR(128) NOT NULL,
    lastLetter CHAR(8) NOT NULL,
);

CREATE TABLE tbl_game (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    lastStepDate DATA NOT NULL
);

CREATE TABLE tbl_gamestep (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    gameId INTEGER NOT NULL,
    cityId INTEGER NOT NULL,
    stepNumber INTEGER NOT NULL,
    CONSTRAINT  game FOREIGN KEY (gameId) REFERENCES tbl_game(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT  city FOREIGN KEY (cityId) REFERENCES tbl_city(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('м','москва','а');
INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('а','анапа','а');
INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('с','саранск','к');
INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('к','киев','в');
INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('в','вологда','а');
INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('р','рига','а');
INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('в','воронеж','ж');
INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('ж','житомир','р');
INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('я','ярославль','л');
INSERT INTO tbl_city (firstLetter,name,lastLetter) VALUES ('л','липецк','к');
