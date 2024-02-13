
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
   cp .envCopy .env
   ```
3. Lancer les services  sur votre machine locale:
   ```bash
   docker compose up
   ```
4. Accéder à postgre :
   ```bash
   docker exec -it containerPostgre psql -U nom_utilisateur -d nom_de_bdd
   ```

### CSS

 ```bash
cd .\www\easycook-vite\
npm i
```

