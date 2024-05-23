<?php

// Initialisation des variables
$donnees = []; // Tableau pour stocker les données de formulaire
$message_erreur_global = ""; // Message d'erreur global pour la connexion
$message_success_global = ""; // Message de succès global pour la connexion
$erreurs = []; // Tableau pour stocker les erreurs de formulaire
$_SESSION['donnees-utilisateur'] = []; // Initialisation des données utilisateur en session

// Vérification et stockage du champ "email-nom-utilisateur"
if (isset($_POST["email-nom-utilisateur"]) && !empty($_POST["email-nom-utilisateur"])) {
	$donnees["email-nom-utilisateur"] = trim(htmlentities($_POST["email-nom-utilisateur"]));
} else {
	$erreurs["email-nom-utilisateur"] = "Le champ email ou nom d'utilisateur est requis. Veuillez le renseigner.";
}

// Vérification et stockage du champ "mot-passe"
if (isset($_POST["mot-passe"]) && !empty($_POST["mot-passe"])) {
	$donnees["mot-passe"] = trim(htmlentities($_POST['mot-passe']));
} else {
	$erreurs["mot-passe"] = "Le champ mot de passe est requis. Veuillez le renseigner.";
}

// Stockage des données utilisateur dans la session
$_SESSION['donnees-utilisateur'] = $donnees;

// Vérification des éventuelles erreurs de formulaire
if (empty($erreurs)) {
	// Vérification si l'utilisateur existe dans la base de données
	$user = check_if_user_exist($donnees["email-nom-utilisateur"], $donnees["mot-passe"], "CLIENT");
	// Si l'utilisateur existe, le connecter et rediriger vers la page de liste des réservations
	if (!empty($user)) {
		$_SESSION['utilisateur_connecter_client'] = $user;
		header('location:' . PATH_PROJECT . 'client/liste_des_reservations');
		exit;
	} else {
		$message_erreur_global = "L'adresse email ou le mot de passe est incorrect. Veuillez réessayer.";
	}
} else {
	$_SESSION['connexion-erreurs'] = $erreurs;
}

// Stockage des messages d'erreur et de succès dans la session
$_SESSION['connexion-message-erreur-global'] = $message_erreur_global;
$_SESSION['connexion-message-success-global'] = $message_success_global;

// Redirection vers la page de connexion
header('location: ' . PATH_PROJECT . 'client/connexion');
