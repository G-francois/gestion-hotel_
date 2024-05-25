<?php

// Initialisation des variables de session
$_SESSION['enregistrer-erreurs'] = [];
$_SESSION['donnees-utilisateur'] = [];
$donnees = [];
$erreurs = [];

// Vérification des champs de mot de passe et de confirmation de mot de passe
if (isset($_POST["mot-passe"])) {
	$password = trim($_POST["mot-passe"]);
	$retapezMotPasse = trim($_POST["retapez-mot-passe"]);

	// Vérifie si le champ du mot de passe est vide
	if (empty($password)) {
		$erreurs["mot-passe"] = "Le champ du mot de passe est vide. Veuillez le renseigner.";
	} // Vérifie si la longueur du mot de passe est inférieure à 8 caractères
	elseif (strlen($password) < 8) {
		$erreurs["mot-passe"] = "Le champ doit contenir au moins 8 caractères. Les espaces ne sont pas pris en compte.";
	} // Vérifie si le champ de confirmation du mot de passe est vide
	elseif (empty($retapezMotPasse)) {
		$erreurs["retapez-mot-passe"] = "Entrez votre mot de passe à nouveau.";
	} // Vérifie si les mots de passe saisis correspondent
	elseif ($password != $retapezMotPasse) {
		$erreurs["retapez-mot-passe"] = "Mot de passe erroné. Entrez le mot de passe du champ précédent.";
	} else {
		$donnees["mot-passe"] = htmlentities($password);
	}
}

// Stocke les données de l'utilisateur dans la variable de session
$_SESSION['donnees-utilisateur'] = $donnees;

// Vérifie s'il n'y a pas d'erreurs dans les données
if (empty($erreurs)) {
	// Met à jour le mot de passe dans la base de données
	if (mise_a_jour_mot_passe($_SESSION['id_user'], $donnees["mot-passe"])) {
		// Détruit la session et redirige vers la page de connexion
		session_destroy();
		$_SESSION['validation-mot-passe-success'] = "Votre mot de passe a été modifié avec succès. Vous pouvez vous connectez maintenant.";
		header('location:' . PATH_PROJECT . 'client/connexion');
	} else {
		$_SESSION['enregistrer-erreurs'] = $erreurs;
		header('location: ' . PATH_PROJECT . 'client/mot_de_passe/nouveau_mot_passe');
	}
} else {
	$_SESSION['enregistrer-erreurs'] = $erreurs;
	header('location: ' . PATH_PROJECT . 'client/mot_de_passe/nouveau_mot_passe');
}
