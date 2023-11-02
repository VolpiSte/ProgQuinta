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
        - [ ] Crea
        - [ ] Posta
        - [ ] Modifica
            - [ ] Descrizione
            - [ ] Foto profilo
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
          - [ ] Scrivi
        - [ ] Elimina

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
    * preset 

* Commento
    * id_commento (PK)
    * post
    * account
    * testo

* Like
    * id_like (PK)
    * account

# Schema E/R
![fatto](https://github.com/VolpiSte/ProgQuinta/assets/101709267/39f6936a-030b-4883-bdc1-5bcb03a74872)


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
