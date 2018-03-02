# Netflix - Bazerque Florian / Carabin Vincent

## Installation

Une fois l'installation classique de symfony ainsi que la base de données créée, execute les commandes suivantes pour importer les fichiers csv.

```
php bin/console import:category:csv
```

```
php bin/console import:movie:csv
```

```
php bin/console import:user:csv
```

```
php bin/console import:usermovie:csv
```

### Compte admin :
```
username : admin
password : admin 
```

### Compte utilisateur : 

```
username : goeffrey
password : test 
```

```
username : vincent
password : test 
```

```
username : florian
password : test 
```

## Fonctionnalités du site

- Inscription / Connexion utilisateur (ROLE_USER)
- Faire une recherche d'un film 
- Lister les films par catégories
- Afficher le détail du film 
- Regarder un film
- Modifier les paramètres / préférences utilisateur
- Ajouter / supprimer un film de la liste "à regarder plus tard"
- CRUD catégorie de film
- CRUD film
- Gestion des utilisateurs (ajout / suppression)
- Import massif de film
- ROLE_ADMIN