# Fotorum
## Descrizione
Webapp di diffusione e condivisione di informazioni/preset e tecniche di fotografia e videografia <br>
## Problema che risolve 
Dubbi e consigli su foto e video
## Tecnologie usate
* HTML
* JavaScript
* MySQL
* php
  
## Funzionalità 
* Creazione/eliminazione account
* Modifica account
* Gestione password
* Creazione/eliminazione post
* Aggiunta/rimozione like al post
* Aggiungi/rimuovi commento

* Account
    - [ ] Gestione Account
        - [ ] Crea
        - [ ] Posta
        - [ ] Modifica
            - [ ] Descrizione
        - [ ] Gestione Password
            - [ ] Crea
            - [ ] Password Dimenticata (servizio recupero password)
        - [ ] Elimina
* Post
    - [ ] Gestione Post
        - [ ] Crea
            - [ ] Descrizione
        - [ ] File (foto/video)
        - [ ] Modifica
        - [ ] Aggiungi Preset
        - [ ] Rimuovi Preset
        - [ ] Elimina
        - [ ] Likes
        - [ ] Aggiungi likes
        - [ ] Rimuovi likes
* Commento
    - [ ] Gestione Commento
        - [ ] Crea
        - [ ] Elimina

## Entità
* Account (fotografo/Videografo)
    * nickName (PK)
    * nome
    * cognome 
    * password
    * dataDiNascita
    * località
    * sesso 
    * n° likes
    * lavoro
    * n° post
 
* Post
    * id_post (PK)
    * account
    * file (foto/video)
    * likes
    * commenti
    * preset 

* Commento
    * id_commento (PK)
    * post
    * account

* Like
    * id_like (PK)
    * account

# Schema E/R
![PerMasturbianni](https://github.com/VolpiSte/ProgQuinta/assets/101709267/b2eb8cbe-e316-4c6d-a6e2-cc361534efea)

# Schema Relazionale
Account (<ins>nickName</ins>, nome, cognome, password, dataDiNascita, località, sesso, lavoro, n°likes, n°Post) <br>
Post (<ins>id_post</ins>, file, preset, <u>account_nickname</ins>) <br>
Commento (<ins>id_commento</ins>, <ins>post_id_post</ins>, <ins>account_nickname</ins>) <br>
Like (<ins>id_like</ins>, <ins>account_nickname</ins>) <br>

# Mockup
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/9bebc9cd-a83b-454e-a622-d8565fa3110d)
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/471cd905-7c9e-4a5b-9ed6-da39b0ec7b98)
![image](https://github.com/VolpiSte/ProgQuinta/assets/101709267/3aa77d3f-5cfe-415b-8251-56b0e5c9b734)
