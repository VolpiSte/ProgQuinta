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

* Utente
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
* Utente (fotografo/Videografo)
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
    * utente
    * file (foto/video)
    * likes
    * commenti
    * preset 

* Commento
    * id_commento (PK)
    * post
    * utente

* Like
    * id_like (PK)
    * utente

# Schema E/R
![PerMasturbianni](https://github.com/VolpiSte/ProgQuinta/assets/101709267/b2eb8cbe-e316-4c6d-a6e2-cc361534efea)

# Schema Relazionale
Utente (_nickName_ , nome, cognome, password, dataDiNascita, località, sesso, lavoro, n°likes, n°Post)
Post (_id_post_, file, preset, _utente_nickname_)
Commento (_id_commento_, _post_id_post_, _utente_nickname_)
Like (_id_like_, _utente_nickname_)
