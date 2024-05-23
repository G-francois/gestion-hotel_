<?php

$donnees = []; // Initialise un tableau pour stocker les données
$erreurs = []; // Initialise un tableau pour stocker les erreurs
$messages = $_POST['message_id']; // Récupère l'identifiant du message à supprimer depuis la requête POST

if (isset($_POST['supprimer'])) { // Vérifie si le formulaire de suppression a été soumis

	if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_client']['id'])) { // Vérifie si le mot de passe est correct

		if (supprimer_messages($messages)) { // Supprime le message avec l'identifiant spécifié
			$message_success_global = "La suppression du message a été effectuée avec succès.";
		} else {
			$message_erreur_global = "La suppression a échoué. Veuillez réessayer.";
		}
	} else {
		$message_erreur_global = "La suppression a échoué. Vérifiez votre mot de passe et réessayez.";
	}
} else {
	$message_erreur_global = "La suppression a échoué. Veuillez réessayer.";
}

// Stocke les messages de succès et d'erreur dans les variables de session
$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;

// Redirige vers la page de liste des messages
header('location: ' . PATH_PROJECT . 'client/liste_des_messages');
