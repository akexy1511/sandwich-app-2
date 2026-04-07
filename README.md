# Sandwich Web App

## Description
Sandwich Web App est une application web conçue pour faciliter la commande de sandwichs dans un environnement professionnel ou éducatif, tel qu'une entreprise ou une école. Les utilisateurs peuvent consulter les sandwichs disponibles, passer des commandes pour des jours spécifiques de la semaine (lundi, mardi, jeudi, vendredi), et gérer leurs comptes. L'application inclut des fonctionnalités administratives pour gérer les utilisateurs, les commandes et les paiements, ainsi que la génération de QR codes pour identifier les commandes.

L'objectif principal est de simplifier le processus de commande de repas, en permettant aux utilisateurs de commander à l'avance et aux administrateurs de suivre les commandes et les paiements efficacement.

---

## Fonctionnalités principales

### Pour les utilisateurs
- **Inscription et connexion** : Création de compte via `signup.php` et connexion via `login.php`.
- **Consultation des sandwichs** : Affichage des sandwichs disponibles sur la page d'accueil (`index.php`) et détails via `sandwich.php`.
- **Passation de commandes** : Sélection d'un sandwich, choix du jour (lundi, mardi, jeudi, vendredi), option crudités, et validation de la commande.
- **Gestion des commandes** : Visualisation des commandes passées via `commandes.php`, avec statut de paiement.
- **Paiement** : Processus de paiement via `paiement.php` et traitement via `paiement-process.php`.
- **Déconnexion** : Via `logout.php`.

### Pour les administrateurs
- **Tableau de bord** : Accès via `admin.php` pour voir les statistiques (utilisateurs, commandes, revenus).
- **Gestion des utilisateurs** : Via `admin-users.php`.
- **Gestion des sandwichs** : Via `admin-sandwichs.php`.
- **Gestion des commandes** : Via `admin-commandes.php`, avec possibilité de créer, modifier ou supprimer des commandes.
- **Génération de QR codes** : Pour identifier les commandes via `qr.php`.

### Fonctionnalités techniques
- **Base de données** : Stockage des utilisateurs, commandes, sandwichs, paiements et transactions.
- **Authentification** : Gestion des sessions utilisateur.
- **QR codes** : Génération pour suivi des commandes.
- **Responsive design** : Utilisation de CSS pour une interface adaptée aux mobiles et ordinateurs.

---

## Technologies utilisées
- **Backend** : PHP
- **Base de données** : MySQL (fichier SQL fourni : `sandwich-web-app-db.sql`)
- **Frontend** : HTML, CSS (fichiers dans `assets/css/`)
- **JavaScript** : Pour interactions dynamiques (dans `public/assets/js/`)
- **Bibliothèques** : Utilisation de bibliothèques pour QR codes (bacon-qr-code, endroid/qr-code)
- **Serveur** : Compatible avec XAMPP ou similaires pour développement local

---

## Installation et configuration

### Prérequis
- Serveur web avec PHP (version 7.4 ou supérieure)
- MySQL ou MariaDB
- XAMPP recommandé pour développement local

### Étapes d'installation
1. **Cloner ou télécharger le projet** : Placez les fichiers dans le répertoire web (ex. `htdocs/sandwich-app-2` pour XAMPP).

2. **Configurer la base de données** :
   - Créer une base de données MySQL nommée `sandwich`.
   - Importer le fichier `sandwich-web-app-db.sql` pour créer les tables et données initiales.

3. **Configurer la connexion** :
   - Modifier `includes/database.php` pour ajuster les paramètres de connexion à la base de données (hôte, utilisateur, mot de passe).

4. **Configurer les sandwichs** :
   - Les données des sandwichs sont stockées dans `sandwiches.json`. Modifiez ce fichier pour ajouter ou changer les sandwichs disponibles.

5. **Démarrer le serveur** :
   - Lancer XAMPP et accéder à l'application via `http://localhost/sandwich-app-2`.

### Configuration supplémentaire
- Assurez-vous que les permissions des fichiers permettent l'écriture si nécessaire (ex. pour les logs).
- Pour la génération de QR codes, installez les dépendances via Composer si nécessaire : `composer require bacon/bacon-qr-code endroid/qr-code`.

---

## Structure du projet
```
sandwich-app-2/
├── admin-commandes.php      # Gestion admin des commandes
├── admin-sandwichs.php      # Gestion admin des sandwichs
├── admin-users.php          # Gestion admin des utilisateurs
├── admin.php                # Tableau de bord admin
├── commande-creer.php       # Création de commande
├── commande-modifier.php    # Modification de commande
├── commande-supprimer.php   # Suppression de commande
├── commandes.php            # Liste des commandes utilisateur
├── index.php                # Page d'accueil
├── login.php                # Connexion
├── logout.php               # Déconnexion
├── paiement-process.php     # Traitement paiement
├── paiement.php             # Page paiement
├── qr.php                   # Génération QR codes
├── sandwich.php             # Détails sandwich
├── sandwiches.json          # Données sandwichs
├── signup.php               # Inscription
├── sandwich-web-app-db.sql  # Script base de données
├── assets/
│   └── css/
│       └── style.css        # Styles CSS
├── includes/
│   ├── auth.php             # Authentification
│   ├── database.php         # Connexion DB
│   ├── footer.php           # Pied de page
│   └── header.php           # En-tête
└── public/
    └── assets/
        ├── img/             # Images
        └── js/              # Scripts JS
```

---

## Contribution
Pour contribuer au projet :
- Forkez le repository.
- Créez une branche pour vos modifications.
- Soumettez une pull request avec une description claire des changements.

---

## Licence
Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.

---

## Contact
Pour toute question ou support, contactez l'équipe de développement.
- **probleme.php** : Gestion des erreurs ou signalement de problèmes.
- **sandwiches.json** : Données des sandwichs.
- **style.css** et **commande.css** : Fichiers de style.

### Dossier `sandwich/sandwich_detail/`
- **data.php** : Fournit des données sur les sandwichs.
- **sandwich.php** : Affiche les détails d'un sandwich spécifique.
- **detail.css** : Fichier de style pour la page de détails.

### Dossier `vendor/`
- Contient les dépendances PHP gérées par Composer :
  - **bacon-qr-code** : Bibliothèque pour générer des QR codes.
  - **endroid/qr-code** : Autre bibliothèque pour les QR codes.
  - **composer/** : Fichiers générés par Composer pour l'autoloading.

---

## Technologies utilisées
- **PHP** : Langage principal pour la logique serveur.
- **Composer** : Gestionnaire de dépendances PHP.
- **JSON** : Format utilisé pour stocker des données (ex. : `sandwiches.json`).
- **Bibliothèques QR Code** :
  - `bacon-qr-code`
  - `endroid/qr-code`

---

## Installation

### Prérequis
- Serveur web local (ex. : XAMPP, WAMP).
- PHP installé.
- Composer installé.

### Étapes
1. Clonez le dépôt dans votre serveur local :
   ```bash
<<<<<<< HEAD
   git clone <url-du-repo>```

### Installation

=======
   git clone <url-du-repo>

### Installation
>>>>>>> 6ec1b836a3949b908b1e84973fc4ba8eec9af4f6
1. **Placez le projet dans le dossier racine de votre serveur web**
   - Exemple : `htdocs` pour XAMPP.

2. **Installez les dépendances avec Composer** :
   ```bash
   composer install
   ```

3. **Importez le fichier SQL dans votre base de données** :
   - Ouvrez votre outil de gestion de base de données (ex. : phpMyAdmin).
   - Créez une nouvelle base de données.
   - Importez le fichier `sandwich_projet-po_cyril.sql`.

4. **Configurez la connexion à la base de données dans `db.php`**.

5. **Lancez l'application dans votre navigateur** :
   ```
   http://localhost/sandwich-web-app/sandwich/index.php
<<<<<<< HEAD
   ```
=======
   ```
>>>>>>> 6ec1b836a3949b908b1e84973fc4ba8eec9af4f6
