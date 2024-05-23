<?php

// Initialisation des variables de session
$_SESSION['photo-erreurs'] = "";
$_SESSION['donnees-utilisateur'] = [];

// Initialisation des variables locales
$donnees = $_SESSION['utilisateur_connecter_client'];
$erreurs = [];
$new_data = [];

// Récupération de l'ID de l'utilisateur pour créer le chemin du dossier d'images
$idUtilisateur = $_SESSION['utilisateur_connecter_client']['nom_utilisateur'];

$dossierImage = "public/images/";

if (!is_dir($dossierImage . "upload/")) {
	// Création du dossier "upload" s'il n'existe pas
	mkdir($dossierImage . "upload/");
}

// Vérifier si le dossier Utilisateurs existe, sinon le creer
$dossierUtilisateurs = $dossierImage . "upload/Utilisateurs/";
if (!is_dir($dossierUtilisateurs)) {
	mkdir($dossierUtilisateurs);
}


// Vérifier si le dossier username existe dans le dossier repas, sinon le creer
$dossierUsername = $dossierUtilisateurs . $idUtilisateur . "/";
if (!is_dir($dossierUsername)) {
	mkdir($dossierUsername);
}

// Le chemin de destination pour enregistrer l'image
$image_path = $dossierUsername . $_FILES["image"]["name"];


// Initialisation de la variable de session 'donnees-utilisateur' à un tableau vide
$_SESSION['donnees-utilisateur'] = $new_data;

// die(var_dump($donnees));

// Vérification de la soumission du formulaire
if (isset($_POST['change_photo'])) {

	// Vérification de l'existence du mot de passe via une fonction 'check_password_exist'
	if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_client']['id'])) {

		// Vérification de l'existence du fichier et de son poids
		if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
			if ($_FILES["image"]["size"] <= 3000000) {

				// Récupération des informations du fichier
				$file_name = $_FILES["image"]["name"];
				$file_info = pathinfo($file_name);
				$file_ext = $file_info["extension"];
				$allowed_ext = ["png", "jpg", "jpeg", "gif"];

				// Vérification de l'extension du fichier
				if (in_array(strtolower($file_ext), $allowed_ext)) {

					// Déplacement du fichier téléchargé vers le dossier de l'utilisateur
					move_uploaded_file($_FILES['image']['tmp_name'], $dossierUsername . basename($_FILES['image']['name']));
					$profiledonnees["image"] = PATH_PROJECT . $dossierUsername . basename($_FILES['image']['name']);

					// Mise à jour de l'avatar de l'utilisateur
					if (mise_a_jour_avatar($_SESSION['utilisateur_connecter_client']['id'], $profiledonnees["image"])) {

						// Récupération et mise à jour des informations utilisateur
						$new_user_data = recuperer_mettre_a_jour_informations_utilisateur($_SESSION['utilisateur_connecter_client']['id']);

						if (!empty($new_user_data)) {
							$_SESSION['utilisateur_connecter_client'] = $new_user_data;
							header('location: ' . PATH_PROJECT . 'client/profil');
						}
					} else {
						$_SESSION['photo-erreurs'] = "La mise à jour de l'image a échoué.";
						header('location:' . PATH_PROJECT . 'client/profil');
					}
				} else {
					$_SESSION['photo-erreurs'] = "L'extension de votre image n'est pas prise en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";
					header('location:' . PATH_PROJECT . 'client/profil');
				}
			} else {
				$_SESSION['photo-erreurs'] = "Fichier trop lourd. Poids maximum autorisé : 3mo";
				header('location:' . PATH_PROJECT . 'client/profil');
			}
		} else {
			$profiledonnees["image"] = $donnees["avatar"];
		}
	} else {
		$_SESSION['photo-erreurs'] = "La mise à jour a échoué. Vérifiez votre mot de passe et réessayez.";
	}
}

header('location:' . PATH_PROJECT . 'client/profil');
