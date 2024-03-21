# Fotorum
Target: Persone che vogliono migliorare le tecniche di fotografia/videografia e che in generale si incuriosiscono a questo mondo
Problema che risolve: Persona che non ha idea o ha idee non del tutto chiare su come Fotografare/Videografare un qualsiasi momento personale/pubblico

## Descrizione
Webapp di diffusione e condivisione di informazioni/preset e tecniche di fotografia e videografia <br>

## Problema che risolve 
Dubbi e consigli su foto e video

## Tecnologie usate
* HTML
* JavaScript
* MySQL
* php
* Send Grid
  
## Funzionalità 
* Creazione/eliminazione account
* Modifica account (informazioni, foto profilo)
* Gestione password
* Creazione/eliminazione post
* Aggiunta/rimozione like al post
* Aggiungi/rimuovi commento
* Ricerca Account
* Visualizzazione Account altrui
* Viusalizzazione foto
* Visualizzazione post (personale e altrui)
* Scaricare preset

* Account
    - [ ] Gestione Account
        - [x] Crea
        - [x] Posta
        - [x] Modifica
            - [x] Descrizione
            - [x] Foto profilo
        - [x] Gestione Password
            - [x] Verifica
            - [x] Password Dimenticata (servizio recupero password)
        - [ ] Elimina
* Post
    - [ ] Gestione Post
        - [x] Crea
            - [x] Descrizione
        - [x] File (foto/video)
        - [x] Modifica
        - [x] Aggiungi Preset
        - [ ] Rimuovi Preset
        - [x] Elimina
        - [ ] Likes
* Commento
    - [ ] Gestione Commento
        - [ ] Crea
          - [ ] Scrivi
        - [ ] Elimina
* Likes
    - [ ] Gestione Like
      - [ ] Aggiungi
      - [ ] Rimuovi
## Entità
* Account (fotografo/Videografo)
    * nickName (PK)
    * nome
    * cognome
    * email
    * password
    * dataDiNascita
    * località
    * sesso
    * lavoro
    * n° likes
    * n° post
    * fotoProfilo
 
* Post
    * id_post (PK)
    * account
    * file (foto/video)
    * likes
    * commenti
    * preset (file di impostazioni sulle specifiche di un'immagine)

* Commento
    * id_commento (PK)
    * post
    * account
    * testo

* Like
    * id_like (PK)
    * account

# Schema E/R
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/09a2e11c-c0de-47dd-a9cd-1ed75284e4c5)



# Schema Relazionale
Account (<ins>nickName</ins>, nome, cognome, email, password, dataDiNascita, località, sesso, lavoro, n°likes, n°Post, fotoProfilo) <br>
Post (<ins>id_post</ins>, file, preset, descrizione, <ins>account_nickname</ins>) <br>
Commento (<ins>id_commento</ins>, <ins>post_id_post</ins>, <ins>account_nickname</ins>, testo) <br>
Like (<ins>id_like</ins>, <ins>id_post</ins>, <ins>account_nickname</ins>) <br>

# Mockup
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/d015c208-8c0c-44a0-94e5-40324bdb37ea)
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/d997f905-613b-484c-b405-e1fbdadee422)
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/b6e1315b-208b-4f8b-9422-3886730f75bd)
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/eabee6f7-522e-449f-8341-0862aad180b0)
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/4d9cbbfa-7334-49d0-86dd-534f6af02708)
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/51c09af7-66f0-4a46-9f23-cbb888db8af8)
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/75a31dee-d88a-41b4-a70c-e4ed72cf6fee)
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/3aa77d3f-5cfe-415b-8251-56b0e5c9b734)

# PER FARLO FUNZIONARE
- Avere XAMPP in locale
- Creare un database nominato "fotorum"
- usare il .sql e creare le tabelle
- Poi puoi utilizzare tutte le funzionalità che ho implementato


# Crea tabelle all'interno del database (phpMyAdmin in XAMPP)
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
    photo BLOB,
    file BLOB NULL, 
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
