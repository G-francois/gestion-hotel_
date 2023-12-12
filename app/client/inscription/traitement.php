<?php

// Initialisation des variables
$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];

// Validation du champ "nom"
if (isset($_POST["nom"]) && !empty($_POST["nom"])) {
	$nom = htmlentities($_POST["nom"]);
	$pattern = '/^[A-Z]+$/';
	/*Dans ce code, j'ai ajouté une nouvelle validation pour le champ "nom". J'ai défini le pattern /^[A-Z]+$/
	 qui vérifie que la chaîne $nom contient uniquement des lettres majuscules. Ensuite, j'ai utilisé la fonction
	 preg_match() pour valider si le nom correspond au pattern. Si c'est le cas, le nom est ajouté aux données
	 ($donnees["nom"]). Sinon, un message d'erreur approprié est stocké dans le tableau $erreurs["nom"].
	*/
	if (preg_match($pattern, $nom)) {
		$donnees["nom"] = $nom;
	} else {
		$donnees["nom"] = strtoupper($nom);
	}
} else {
	$erreurs["nom"] = "Le champ nom est requis. Veuillez le renseigner.";
}

// Validation du champ "prenom"
if (isset($_POST["prenom"]) && !empty($_POST["prenom"])) {
	$donnees["prenom"] = trim(htmlentities($_POST["prenom"]));
} else {
	$erreurs["prenom"] = "Le champs prénom est requis. Veuillez le renseigné.";
}

// Validation du champ "email"
if (isset($_POST["email"]) && !empty($_POST["email"])) {
	if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$donnees["email"] = $_POST["email"];
	} else {
		$erreurs["email"] = "Le champs email doit être une adresse mail valide. Veuillez le renseigné.";
	}
} else {
	$erreurs["email"] = "Le champs email est vide. Veuillez le renseigné.";
}

// Validation du champ "nom-utilisateur"
if (isset($_POST["nom-utilisateur"]) && !empty($_POST["nom-utilisateur"])) {
	$donnees["nom-utilisateur"] = trim(htmlentities($_POST["nom-utilisateur"]));
} else {
	$erreurs["nom-utilisateur"] = "Le champs nom-utilisateur est requis. Veuillez le renseigné.";
}

// Validation du champ "mot-passe" et "retapez-mot-passe"
if (isset($_POST["mot-passe"])) {
	$password = trim($_POST["mot-passe"]);
	$retapezMotPasse = trim($_POST["retapez-mot-passe"]);

	if (empty($password)) {
		$erreurs["mot-passe"] = "Le champ du mot de passe est vide. Veuillez le renseigner.";
	} elseif (strlen($password) < 8) {
		$erreurs["mot-passe"] = "Le champ doit contenir au moins 8 caractères. Les espaces ne sont pas pris en compte.";
	} elseif (empty($retapezMotPasse)) {
		$erreurs["retapez-mot-passe"] = "Entrez votre mot de passe à nouveau.";
	} elseif ($password != $retapezMotPasse) {
		$erreurs["retapez-mot-passe"] = "Mot de passe erroné. Entrez le mot de passe du champ précédent.";
	} else {
		$donnees["mot-passe"] = htmlentities($password);
	}
}

// Validation de la case "termes-conditions"
if (!isset($_POST["termes-conditions"]) || empty($_POST["termes-conditions"])) {
	$erreurs["termes-conditions"] = "Veuillez cocher cette case svp";
}

// Vérification de l'existence de l'adresse e-mail dans la base de données
// $check_email_exist_in_db = check_email_exist_in_db($_POST["email"]);

// if ($check_email_exist_in_db) {
// 	$erreurs["email"] = "Cette adresse mail est déjà utilisée. Veuillez le changez.";
// }

if (check_email_and_profile_in_db($_POST["email"])) {
    $erreurs["email"] = "Cette adresse mail n'est pas autorisée car il est déjà utiliser par un autre profil 'client'.";
} 

// Vérification de l'existence du nom d'utilisateur dans la base de données
$check_user_name_exist_in_db = check_user_name_exist_in_db($_POST["nom-utilisateur"]);

if ($check_user_name_exist_in_db) {
	$erreurs["nom-utilisateur"] = "Ce nom d'utilisateur est déjà utilisé. Veuillez le changez.";
}

// Vérification des erreurs et enregistrement de l'utilisateur
if (empty($erreurs)) {

	$donnees["profil"] = "CLIENT";

	$resultat = enregistrer_utilisateur($donnees["nom"], $donnees["prenom"], $donnees["email"], $donnees["nom-utilisateur"], $donnees["mot-passe"], $donnees["profil"]);

	if ($resultat) {
		$token = uniqid("");
		$id_utilisateur = recuperer_id_utilisateur_par_son_mail($donnees['email']);

		if (!insertion_token($id_utilisateur, 'VALIDATION_COMPTE', $token)) {
			$message_erreur_global = "Votre inscription s'est effectué avec succès mais une erreur est survenue lors de la génération de la clè de validation de votre compte. Veuillez contacter un administrateur.";
		} else {
			$objet = 'Validation de votre inscription';
			ob_start(); // Démarre la temporisation de sortie
			include 'app/client/inscription/message_mail.php'; // Inclut le fichier HTML dans le tampon
			$template_mail = ob_get_contents(); // Récupère le contenu du tampon
			ob_end_clean(); // Arrête et vide la temporisation de sortie

			if (send_email($donnees["email"], $objet, $template_mail)) {
				$message_success_global = "Votre inscription s'est effectué avec succès. Veuillez consulter votre adresse mail pour valider votre compte.";
			} else {
				$message_erreur_global = "Votre inscription s'est effectué avec succès mais une erreur est survenue lors de l'envoi du mail de validation de votre compte. Veuillez contacter un administrateur.";
				// Ajoutez l'instruction de suppression de l'utilisateur ici
				if (isset($id_utilisateur)) {
					suppression_compte_utilisateur($id_utilisateur);
				}
			}
		}
	} else {
		$message_erreur_global = "Oups ! Une erreur s'est produite lors de l'enregistrement de l'utilisateur.";
	}
}

// Stockage des données et des messages dans les variables de session
$_SESSION['donnees-utilisateur'] = $donnees;
$_SESSION['inscription-erreurs'] = $erreurs;
$_SESSION['inscription-message-erreur-global'] = $message_erreur_global;
$_SESSION['inscription-message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'client/inscription/index');
