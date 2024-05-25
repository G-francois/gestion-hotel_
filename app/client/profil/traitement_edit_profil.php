<?php

// Initialise les variables de session pour les erreurs de sauvegarde et les données utilisateur
$_SESSION['sauvegarder-erreurs'] = "";
$_SESSION['donnees-utilisateur'] = [];

// Initialise les tableaux de données et d'erreurs
$donnees = $_SESSION['utilisateur_connecter_client'];
$new_data = [];
$erreurs = [];

// Vérifie si l'action est de sauvegarder les modifications du profil utilisateur
if (isset($_POST['sauvegarder'])) {

	// Vérifie si le mot de passe fourni correspond au mot de passe de l'utilisateur connecté
	if (check_password_exist(($_POST['password']), $donnees['id'])) {

		// Vérifie et met à jour les champs de nom, prénom, téléphone et nom d'utilisateur s'ils sont modifiés
		if (!empty($_POST['nom']) && $_POST['nom'] != $donnees['nom']) {
			$new_data['nom'] = strtoupper(htmlentities($_POST['nom']));
		} else {
			if (empty($_POST['nom'])) {
				$erreurs["nom"] = "Le champ nom ne doit pas être vide.";
			} else {
				$new_data['nom'] = $donnees['nom'];
			}
		}

		// Vérifie et met à jour les champs de prénom s'ils sont modifiés
		if (!empty($_POST['prenom']) && $_POST['prenom'] != $donnees['prenom']) {
			$new_data['prenom'] = ucfirst(htmlentities($_POST['prenom']));
		} else {
			if (empty($_POST['prenom'])) {
				$erreurs["prenom"] = "Le champ prénom ne doit pas être vide.";
			} else {
				$new_data['prenom'] = $donnees['prenom'];
			}
		}

		// Vérifie et met à jour le champ de téléphone s'il est modifié et respecte les critères requis
		if (!empty($_POST['telephone'])) {
			$telephone = trim(htmlentities($_POST['telephone']));
			if (strlen($telephone) == 8 && ctype_digit($telephone)) {
				if ($telephone != $donnees['telephone']) {
					$new_data['telephone'] = $telephone;
				} else {
					$new_data['telephone'] = $donnees['telephone'];
				}
			} else {
				$erreurs["telephone"] = "Le champ téléphone doit contenir 8 chiffres.";
			}
		} else {
			$erreurs["telephone"] = "Le champ téléphone ne doit pas être vide.";
		}

		// Vérifie et met à jour le champ de nom d'utilisateur s'il est modifié
		if (!empty($_POST['nom_utilisateur']) && $_POST['nom_utilisateur'] != $donnees['nom_utilisateur']) {
			$new_data['nom_utilisateur'] = ($_POST['nom_utilisateur']);
		} else {
			if (empty($_POST['nom_utilisateur'])) {
				$erreurs["nom_utilisateur"] = "Le champ nom_utilisateur ne doit pas être vide.";
			} else {
				$new_data['nom_utilisateur'] = $donnees['nom_utilisateur'];
			}
		}

		// Stocke les nouvelles données utilisateur dans la session
		$_SESSION['donnees-utilisateur'] = $new_data;

		// Vérifie s'il n'y a pas d'erreurs de validation
		if (empty($erreurs)) {
			// Met à jour les informations de l'utilisateur dans la base de données
			if (mettre_a_jour_informations_utilisateur(
				$donnees['id'],
				$new_data['nom'],
				$new_data['prenom'],
				$new_data['telephone'],
				$new_data['nom_utilisateur']
			)) {
				// Récupère les nouvelles données de l'utilisateur après la mise à jour
				$new_user_data = recuperer_mettre_a_jour_informations_utilisateur($donnees['id']);

				// Vérifie si les nouvelles données de l'utilisateur sont valides
				if (!empty($new_user_data)) {
					$_SESSION['success'] = "Modification(s) effectuée(s) avec succès";
					$_SESSION['utilisateur_connecter_client'] = $new_user_data;
				} else {
					$_SESSION['sauvegarder-erreurs'] = "La modification a échoué. Veuillez réessayer.";
				}
			} else {
				$_SESSION['sauvegarder-erreurs'] = "La mise à jour a échoué. Veuillez réessayer.";
			}
		} else {
			$_SESSION['erreurs'] = $erreurs;
		}
	} else {
		$_SESSION['sauvegarder-erreurs'] = "La modification a échoué. Veuillez vérifier votre mot de passe et réessayer.";
	}
} else {
	$_SESSION['sauvegarder-erreurs'] = "Veuillez appuyer sur le bouton sauvegarder.";
}

// Redirige vers la page de profil après le traitement
header('location:' . PATH_PROJECT . 'client/profil');
