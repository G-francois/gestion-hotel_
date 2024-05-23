<?php
// Initialisation des variables de session et des variables de données
$_SESSION['suppression-erreurs'] = "";
$_SESSION['donnees-utilisateur'] = [];
$donnees = [];
$erreurs = [];

// Vérifie si l'action est de supprimer l'utilisateur
if (isset($_POST['suppression'])) {

	// Vérifie si le mot de passe fourni correspond au mot de passe de l'utilisateur connecté
	if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_client']['id'])) {

		// Supprime l'utilisateur de la base de données
		if (supprimer_utilisateur($_SESSION['utilisateur_connecter_client']['id'])) {

			// Détruit la session pour l'utilisateur après la suppression
			session_destroy();

			// Redirige vers la page d'accueil après la suppression de l'utilisateur
			header('location:' . PATH_PROJECT . 'client/acceuil');
		} else {
			// Stocke un message d'erreur si la suppression a échoué
			$_SESSION['suppression-erreurs'] = "La suppression a échoué. Veuillez réessayer.";
			// Redirige vers la page de profil en cas d'échec de la suppression
			header('location:' . PATH_PROJECT . 'client/profil');
		}
	} else {
		// Stocke un message d'erreur si la suppression a échoué en raison d'un mot de passe incorrect
		$_SESSION['suppression-erreurs'] = "La suppression a échoué. Veuillez vérifier votre mot de passe et réessayer.";
		// Redirige vers la page de profil en cas d'échec de la suppression
		header('location:' . PATH_PROJECT . 'client/profil');
	}
} else {
	// Stocke un message d'erreur si la désactivation a échoué
	$_SESSION['desactivation-erreurs'] = "La désactivation a échoué. Veuillez réessayer.";
	// Redirige vers la page de profil en cas d'échec de la désactivation
	header('location:' . PATH_PROJECT . 'client/profil');
}
