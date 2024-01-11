CREATE TABLE Account (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(42),
    surname VARCHAR(26),
    nickname VARCHAR(255) UNIQUE CHECK (CHAR_LENGTH(nickname) >= 4),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(128),
    salt VARCHAR(255),
    dateBorn DATE,
    location VARCHAR(255),
    sex VARCHAR(255),
    work VARCHAR(255),
    role INTEGER DEFAULT 0,
    photo VARCHAR(255) NULL,
    verified BOOLEAN DEFAULT FALSE
);
    
CREATE TABLE Post (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    photo VARCHAR(255),
    file VARCHAR(255) NULL, 
    text TEXT,
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
    text TEXT, 
    post_id INTEGER,
    account_id INTEGER, 
    FOREIGN KEY (post_id) REFERENCES Post(id), 
    FOREIGN KEY (account_id) REFERENCES Account(id)
);

CREATE TABLE Verify (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    account_id INTEGER UNIQUE,
    verification_code VARCHAR(8),
    expiration_date DATETIME,
    FOREIGN KEY (account_id) REFERENCES Account(id)
);
