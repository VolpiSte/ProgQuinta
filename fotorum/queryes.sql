CREATE TABLE Account (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(42),
    surname VARCHAR(26),
    nickname VARCHAR(255) UNIQUE CHECK (CHAR_LENGTH(nickname) >= 4),
    email VARCHAR(255) UNIQUE,
    password TEXT,
    dateBorn DATE,
    location VARCHAR(255),
    sex INTEGER,
    work VARCHAR(255),
    role INTEGER 0,
    photo VARCHAR(255) NULL,
    tempCode VARCHAR(8),
    dataCode DATETIME NULL,
    validate BOOLEAN
);
    
CREATE TABLE Post (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    photo BLOB,
    file BLOB, 
    testo TEXT,
    account_id INTEGER,
    FOREIGN KEY (account_id) REFERENCES Account(id)
);

CREATE TABLE Likes (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    post_id INTEGER, 
    FOREIGN KEY (post_id) REFERENCES Post(id)
);

CREATE TABLE Comment (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    texto TEXT, 
    post_id INTEGER,
    account_id INTEGER, 
    FOREIGN KEY (post_id) REFERENCES Post(id), 
    FOREIGN KEY (account_id) REFERENCES Account(id)
);

/*
Unici 2 tipi di file accettati (forse uno .zip)
.xmp
.lrtemplate
*/