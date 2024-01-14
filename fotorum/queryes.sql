CREATE Table Sex (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    sex VARCHAR(255) NOT NULL
);

CREATE TABLE Pronoun (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    pronoun VARCHAR(255) NOT NULL
);

CREATE TABLE Role (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    role INTEGER NOT NULL,
    description VARCHAR(255)
);

CREATE TABLE Account (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(42),
    surname VARCHAR(26),
    nickname VARCHAR(255) UNIQUE CHECK (length(nickname) >= 4),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(128),
    salt VARCHAR(255),
    dateBorn DATE,
    sex INTEGER,
    pronoun INTEGER,
    location VARCHAR(255),
    work VARCHAR(255),
    role INTEGER,
    photo VARCHAR(255),
    verified BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (sex) REFERENCES Sex(id),
    FOREIGN KEY (pronoun) REFERENCES Pronoun(id),
    FOREIGN KEY (role) REFERENCES Role(id)
);

CREATE TABLE Post (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    photo VARCHAR(255),
    file VARCHAR(255), 
    text TEXT NOT NULL,
    account_id INTEGER,
    FOREIGN KEY (account_id) REFERENCES Account(id) ON DELETE CASCADE
);

CREATE TABLE Likes (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    post_id INTEGER, 
    account_id INTEGER,
    FOREIGN KEY (post_id) REFERENCES Post(id) ON DELETE CASCADE,
    FOREIGN KEY (account_id) REFERENCES Account(id) ON DELETE CASCADE
);

CREATE TABLE Comment (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    text TEXT NOT NULL, 
    post_id INTEGER,
    account_id INTEGER, 
    FOREIGN KEY (post_id) REFERENCES Post(id) ON DELETE CASCADE, 
    FOREIGN KEY (account_id) REFERENCES Account(id) ON DELETE CASCADE
);

CREATE TABLE Verify (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    account_id INTEGER UNIQUE,
    verification_code VARCHAR(8) NOT NULL,
    expiration_date DATETIME NOT NULL,
    FOREIGN KEY (account_id) REFERENCES Account(id) ON DELETE CASCADE
);

INSERT INTO Role (role, description) VALUES (0, 'user'), (1, 'admin'), (2, 'Admin'), (3, 'blocked'), (4, 'banned');
INSERT INTO Sex (sex) VALUES ('male'), ('female'), ('other');
INSERT INTO Pronoun (pronoun) 
VALUES 
('I'), ('me'), ('my'), ('mine'), ('myself'),
('we'), ('us'), ('our'), ('ours'), ('ourselves'),
('you'), ('your'), ('yours'), ('yourself'),
('thou'), ('thee'), ('thine'), ('thyself'),
('yo'), ('you all'),
('ye'),
('he'), ('him'), ('his'), ('himself'),
('she'), ('her'), ('hers'), ('herself'),
('it'), ('its'), ('itself'),
('they'), ('them'), ('their'), ('theirs'), ('themself'), ('themselves'),
('one'), ('oneself'),
('ae'), ('aer'), ('aerself'),
('co'), ('cos'), ('coself'),
('e'), ('em'), ('eir'), ('eirs'), ('emself'),
('ey'), ('eirself'),
('fae'), ('faer'), ('faerself'),
('fey'), ('fem'), ('feir'), ('feirs'), ('femself'),
('hu'), ('hum'), ('hus'), ('humself'),
('hy'), ('hym'), ('hys'), ('hymself'),
('kie'), ('kir'), ('kirs'), ('kirself'),
('mer'), ('mers'), ('merself'),
('ne'), ('nem'), ('nir'), ('nirs'), ('nemself'),
('nyself'), ('nirself'),
('nee'), ('ner'), ('ners'), ('nerself'),
('peh'), ('pehm'), ('pehs'), ('pehself'),
('per'), ('pers'), ('perself'),
('sie'), ('hir'), ('hirs'), ('hirself'),
('te'), ('tir'), ('tes'), ('tirself'),
('tey'), ('tem'), ('ter'), ('ters'), ('temself'),
('thon'), ('thons'), ('thonself'),
('ve'), ('ver'), ('vis'), ('verself'),
('xe'), ('xem'), ('xyr'), ('xyrs'), ('xemself'),
('ze'), ('zir'), ('zirs'), ('zirself');