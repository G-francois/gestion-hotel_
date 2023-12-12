## Context
L’hôtel « Sous les cocotiers » vous fait appel pour automatiser sa gestion. Le domaine d’étude couvre les réservations, occupation des chambres, la consommation et la facturation. Une réservation est faite pour plusieurs chambres par un client qui peut être accompagné de plusieurs autres personnes. Les dates d’occupation et de fin d’occupation des chambres pour une même réservation varient d’une chambre à une autre. Pour chaque réservation, les accompagnateurs sont numérotés de 1 à N. Chaque chambre appartient à un type donné et toutes les chambres d’un même type ont le même prix. Une chambre est occupée par une ou plusieurs personnes pour une réservation. Le client qui a fait la réservation et qui doit payer la facture est le client principal et les autres sont les accompagnateurs.

## Pré-requis : 

- PHP : 
- Mysql : 
- Composer : 


## Étapes de déploiement : 

- Installer les dépendances du projet via la commande : composer install.

- Créer une base de données.

- Importer le ficher de la base de données situé dans le dossier : base-de-donnees/gestion-hotel.sql.

- Configurer la constante PATH_PROJECT dans le fichier index.php a la racine du projet en spécifiant le path de votre projet a partir du répertoire web. 
Exemple : C:\wamp64\www\gestion-hotel. Ma constante PROJECT aura comme valeur : /gestion-hotel/

- Configurer les constantes DATABASE_HOST, DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD dans le fichier index.php a la racine du projet en spécifiant les informations de la base de données.

- Configurer les constantes MAIL_ADDRESS, MAIL_PASSWORD dans le fichier index.php a la racine du projet en spécifiant les informations de l'émetteur des mails dans l'application.

- Lancer le projet avec la commande : php -S localhost:8081

- Déployer votre projet en accédant a l'url suivant : http://ocalhost:8081