<?php

// Importation de la classe Secure du package Random\Engine

$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];


// Vérifie la présence et la validité de l'adresse e-mail
if (!empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
	$donnees["email"] = $_POST["email"];
} else {
	$erreurs["email"] = "Le champs email est requis. Veuillez le renseigner.";
}

// Stocke les données et les erreurs dans les variables de session
$_SESSION['donnees-utilisateur'] = $donnees;
$_SESSION['verification-erreurs'] = $erreurs;

// Vérifie s'il n'y a pas d'erreurs dans les données
if (empty($erreurs)) {

	// Vérifie si l'e-mail existe dans la base de données
	if (check_email_exist_in_db($_POST["email"])) {
		// Génère un jeton unique pour la réinitialisation du mot de passe
		$token = uniqid("");
		$id_utilisateur = recuperer_id_utilisateur_par_son_mail($donnees['email']);

		$_SESSION['email-utilisateur'] = $id_utilisateur;

		// Insère le jeton de réinitialisation dans la base de données
		if (!insertion_token($id_utilisateur, 'NOUVEAU_MOT_DE_PASSE', $token)) {
			$message_erreur_global = "La vérification de l'adresse mail s'est effectuée avec succès mais une erreur est survenue lors de la génération de la clé de modification de mot de passe. Veuillez contacter un administrateur.";
		} else {
			$objet = 'Modification de mot de passe';

			// Démarre la temporisation de sortie
			ob_start();
			// Inclut le fichier HTML dans le tampon
			include 'app/client/mot_de_passe/message_mail_password.php';
			// Récupère le contenu du tampon
			$template_mail = ob_get_contents();
			// Arrête et vide la temporisation de sortie
			ob_end_clean();

			// Envoie l'e-mail contenant le lien de réinitialisation du mot de passe
			if (send_email($donnees["email"], $objet, $template_mail)) {
				$donnees['email'] = ($_POST["email"]);
				// Création du cookie contenant l'e-mail pour la réinitialisation du mot de passe
				setcookie(
					"mot_passe",
					json_encode($donnees['email']),
					time() + 365 * 24 * 36000, // expiration time
					'/', // path
					null, // domain
					true, // secure
					true // httponly
				);
				$message_success_global = "La vérification de l'adresse mail s'est effectuée avec succès. Veuillez consulter votre adresse mail pour mettre un nouveau mot de passe.";
			} else {
				$message_erreur_global = "La vérification de l'adresse mail s'est effectuée avec succès mais une erreur est survenue lors de l'envoi du mail de validation de votre compte. Veuillez contacter un administrateur.";
			}
		}
	} else {
		$message_erreur_global = "Oups ! Une erreur s'est produite lors de la vérification de l'adresse mail de l'utilisateur.";
	}
} elseif (!isset($erreurs['email'])) {
	$message_erreur_global = "Oups ! Une erreur s'est produite lors de la vérification de l'adresse mail de l'utilisateur.";
}

// Stocke les messages d'erreur et de succès dans les variables de session et redirige vers la page appropriée
$_SESSION['inscription-message-erreur-global'] = $message_erreur_global;
$_SESSION['inscription-message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'client/mot_de_passe/index');
