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
## Funzionalità & Attributi
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
        - [ ] Likes
        - [ ] Elimina

## Entità
* Artista (fotografo/Videografo)
    * nickName (public)
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
    * file (foto/video)
    * likes
    * commenti
    * preset (if you want)

* Commento
    * utente
    * likes
