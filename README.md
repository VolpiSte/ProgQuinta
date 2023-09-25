# Fotorum
Webapp di diffusione e condivisione di informazioni/preset e tecniche di fotografia e videografia <br>
## Problema che risolve 
Dubbi e consigli su foto e video
## Tecnologie usate
* HTML
* JavaScript
* MySQL
* php
## Funzionalità & Attributi
* Utente
    - [ ] Gestione Account
        - [ ] Create
        - [ ] Posts
        - [ ] Edit
            - [ ] Descrizione
        - [ ] Gestione Password
            - [ ] Crea
            - [ ] Passw Dimenticata (servizio recupero password)
        - [ ] Delete
* Post
    - [ ] Gestione Post
        - [ ] Create
            - [ ] Descrizione
        - [ ] Foto/Video
        - [ ] Edit
        - [ ] AddPreset
        - [ ] DeletePreset
        - [ ] Delete
        - [ ] Likes
        - [ ] Add likes
        - [ ] Remove likes
* Commento
    - [ ] Gestione Commento
        - [ ] Create
        - [ ] Likes
        - [ ] Delete

## Entità
* Artista (fotografo/Videografo)
    * nickName (pu)
    * nome
    * cognome 
    * password
    * dataDiNascita
    * località
    * sesso (gender idk)
    * likes
    * lavoro
    * grafico avanzamento (se lavoro)
    * n° post
 
* Post
    * utente
    * likes
    * commenti
    * preset (if you want)

* Commento
    * utente
    * likes
