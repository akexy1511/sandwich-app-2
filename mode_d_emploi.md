# Mode d'Emploi - Sandwich Web App

Bienvenue dans le mode d'emploi de l'application Sandwich Web App ! Cette application vous permet de commander facilement vos sandwichs pour la semaine. Suivez ce guide pour utiliser toutes les fonctionnalités.

## Table des matières
1. [Inscription et connexion](#inscription-et-connexion)
2. [Navigation dans l'application](#navigation-dans-lapplication)
3. [Consulter les sandwichs](#consulter-les-sandwichs)
4. [Passer une commande](#passer-une-commande)
5. [Gérer mes commandes](#gérer-mes-commandes)
6. [Paiement](#paiement)
7. [Fonctionnalités supplémentaires](#fonctionnalités-supplémentaires)
8. [Conseils et astuces](#conseils-et-astuces)
9. [Support](#support)

## Inscription et connexion

### Créer un compte
1. Accédez à la page d'accueil de l'application.
2. Cliquez sur le lien "Créer un compte" ou allez directement sur `signup.php`.
3. Remplissez le formulaire avec :
   - Votre adresse email
   - Un mot de passe sécurisé
   - Confirmez votre mot de passe
4. Cliquez sur "S'inscrire".
5. Vous recevrez une confirmation et pourrez vous connecter.

### Se connecter
1. Sur la page d'accueil ou via le lien "Se connecter", allez sur `login.php`.
2. Entrez votre email et mot de passe.
3. Cliquez sur "Se connecter".
4. Vous serez redirigé vers votre tableau de bord.

### Se déconnecter
- Cliquez sur le lien "Déconnexion" en haut de la page pour quitter votre session.

## Navigation dans l'application

L'application est composée de plusieurs pages principales :
- **Accueil** (`index.php`) : Liste des sandwichs disponibles
- **Mes commandes** (`commandes.php`) : Historique et gestion de vos commandes
- **Détails sandwich** (`sandwich.php`) : Informations détaillées sur un sandwich spécifique
- **Paiement** (`paiement.php`) : Processus de paiement des commandes

Le menu de navigation en haut de page vous permet d'accéder facilement à ces sections.

## Consulter les sandwichs

1. Sur la page d'accueil, vous verrez la liste des sandwichs disponibles.
2. Chaque sandwich affiche :
   - Son nom
   - Une image illustrative
   - Un emoji représentatif
3. Cliquez sur un sandwich pour voir ses détails :
   - Ingrédients
   - Prix
   - Jours disponibles pour la commande

## Passer une commande

1. Depuis la page d'accueil ou les détails d'un sandwich, sélectionnez le sandwich souhaité.
2. Sur la page de détails (`sandwich.php`), choisissez :
   - Le jour de livraison (lundi, mardi, jeudi ou vendredi)
   - Si vous voulez des crudités (optionnel)
3. Vérifiez les contraintes horaires :
   - Commandes possibles jusqu'à 11h20 le jour même
   - Pour les vendredis après 16h, les commandes passent à la semaine suivante
4. Cliquez sur "Commander" pour valider.
5. La commande sera enregistrée et visible dans "Mes commandes".

**Note** : Une seule commande par jour est autorisée.

## Gérer mes commandes

1. Accédez à "Mes commandes" via le menu.
2. Vous verrez un tableau avec :
   - Jour de livraison
   - Nom du sandwich
   - Option crudités
   - Statut de paiement
   - Actions disponibles
3. Pour chaque commande :
   - Vous pouvez la modifier si elle n'est pas encore payée
   - La supprimer si nécessaire
   - Voir le QR code pour identification

## Paiement

1. Dans "Mes commandes", identifiez les commandes non payées.
2. Cliquez sur "Payer" pour accéder au processus de paiement.
3. Suivez les instructions pour :
   - Sélectionner les commandes à payer
   - Entrer les informations de paiement
   - Confirmer la transaction
4. Une fois payé, le statut passera à "Payé".

**Note** : Le paiement est sécurisé et traite les transactions via des méthodes intégrées.

## Fonctionnalités supplémentaires

### QR Codes
- Chaque commande génère un QR code unique.
- Utilisez-le pour identifier votre commande lors de la récupération.
- Accessible via "Mes commandes" > "Voir QR".

### Notifications
- L'application peut envoyer des rappels pour les commandes à venir.
- Vérifiez votre email pour les confirmations.

## Conseils et astuces

- **Planifiez à l'avance** : Commandez tôt dans la semaine pour éviter les ruptures.
- **Vérifiez les horaires** : Les commandes sont limitées par jour et heure.
- **Mettez à jour vos commandes** : Modifiez-les avant le paiement si nécessaire.
- **Gardez vos identifiants** : Notez votre email et mot de passe pour un accès facile.
- **Utilisez le QR code** : Pour une récupération rapide de votre sandwich.

## Support

Si vous rencontrez des problèmes :
- Vérifiez que vous utilisez un navigateur compatible (Chrome, Firefox, Safari, Edge).
- Assurez-vous d'avoir une connexion internet stable.
- Contactez l'administrateur via l'email admin@cepes.be pour assistance.

Pour les administrateurs, consultez la section admin de l'application pour gérer utilisateurs et commandes.

---

*Ce mode d'emploi est destiné aux utilisateurs finaux. Pour les développeurs ou administrateurs système, consultez le README.md principal.*