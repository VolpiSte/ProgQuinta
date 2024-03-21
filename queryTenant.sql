CREATE Table Sex (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    sex VARCHAR(255) NOT NULL,
    tenant_id INTEGER -- Aggiunto per il multitenancy
);

CREATE TABLE Pronoun (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    pronoun VARCHAR(255) NOT NULL,
    tenant_id INTEGER -- Aggiunto per il multitenancy
);

CREATE TABLE Role (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    role INTEGER NOT NULL,
    description VARCHAR(255),
    tenant_id INTEGER -- Aggiunto per il multitenancy
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
    tenant_id INTEGER, -- Aggiunto per il multitenancy
    FOREIGN KEY (sex, tenant_id) REFERENCES Sex(id, tenant_id),
    FOREIGN KEY (pronoun, tenant_id) REFERENCES Pronoun(id, tenant_id),
    FOREIGN KEY (role, tenant_id) REFERENCES Role(id, tenant_id)
);

CREATE TABLE Post (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    photo VARCHAR(255),
    file VARCHAR(255), 
    text TEXT NOT NULL,
    account_id INTEGER,
    tenant_id INTEGER, -- Aggiunto per il multitenancy
    FOREIGN KEY (account_id, tenant_id) REFERENCES Account(id, tenant_id) ON DELETE CASCADE
);

CREATE TABLE Likes (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    post_id INTEGER, 
    account_id INTEGER,
    tenant_id INTEGER, -- Aggiunto per il multitenancy
    FOREIGN KEY (post_id, tenant_id) REFERENCES Post(id, tenant_id) ON DELETE CASCADE,
    FOREIGN KEY (account_id, tenant_id) REFERENCES Account(id, tenant_id) ON DELETE CASCADE
);

CREATE TABLE Comment (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    text TEXT NOT NULL, 
    post_id INTEGER,
    account_id INTEGER, 
    tenant_id INTEGER, -- Aggiunto per il multitenancy
    FOREIGN KEY (post_id, tenant_id) REFERENCES Post(id, tenant_id) ON DELETE CASCADE, 
    FOREIGN KEY (account_id, tenant_id) REFERENCES Account(id, tenant_id) ON DELETE CASCADE
);

CREATE TABLE Verify (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    account_id INTEGER UNIQUE,
    verification_code VARCHAR(8) NOT NULL,
    expiration_date DATETIME NOT NULL,
    tenant_id INTEGER, -- Aggiunto per il multitenancy
    FOREIGN KEY (account_id, tenant_id) REFERENCES Account(id, tenant_id) ON DELETE CASCADE
);

CREATE TABLE Tenant (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    UNIQUE (name)
);