<?php

// Initialisation des variables de session et des variables de données
$_SESSION['photo-erreurs'] = "";
$_SESSION['donnees-utilisateur'] = [];
$donnees = [];
$erreurs = [];

// Vérifie si l'action est de supprimer une photo
if (isset($_POST['supprimer_photo'])) {

	// Vérifie si le mot de passe fourni correspond au mot de passe de l'utilisateur connecté
	if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_client']['id'])) {

		// Met à jour l'avatar de l'utilisateur avec 'Aucune_image'
		if (mise_a_jour_avatar($_SESSION['utilisateur_connecter_client']['id'], 'Aucune_image')) {

			// Récupère les nouvelles informations de l'utilisateur après la mise à jour
			$new_user_data = recuperer_mettre_a_jour_informations_utilisateur($_SESSION['utilisateur_connecter_client']['id']);

			// Vérifie si les nouvelles données de l'utilisateur ne sont pas vides
			if (!empty($new_user_data)) {

				// Met à jour les informations de l'utilisateur dans la session
				$_SESSION['utilisateur_connecter_client'] = $new_user_data;
			}
		}
	} else {
		// Stocke un message d'erreur si la suppression de la photo a échoué en raison d'un mot de passe incorrect
		$_SESSION['suppression-erreurs'] = "La suppression de la photo a échoué. Veuillez vérifier votre mot de passe et réessayer.";
		// Redirige vers la page de profil en cas d'échec de suppression
		header('location:' . PATH_PROJECT . 'client/profil');
	}
}

// Redirige toujours vers la page de profil après l'exécution des opérations
header('location:' . PATH_PROJECT . 'client/profil');
