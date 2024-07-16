
# README

## Utilisation du fichier `docker-compose copy.yml`


### Prérequis

- Assurez-vous d'avoir Docker et Docker Compose installés sur votre machine. 

### Instructions

1. Clonez ce dépôt sur votre machine locale :
   ```bash
   git clone https://github.com/Pinappll/EasyCook.git
   ```
2. Copiez le fichier .envCopy :
   ```bash
   cd wwww
   cp .envCopy .env
   cd .envCopy ../.env
   ```
3. Remplir le fichier .env
3. Lancer les services  sur votre machine locale:
   ```bash
   docker compose up -d
   ```
4. Installation du site :
   - remplir les champs du formulaire
   - pour récupérer l'hote
   - ```bash
     docker inspect easycook-db-1
     ```

### CSS

 ```bash
cd .\www\easycook-vite\
npm i
npm build
```

