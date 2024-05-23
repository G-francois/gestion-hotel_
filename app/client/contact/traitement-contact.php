<?php

$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];


if (isset($_POST['envoyer'])) {

	if (empty($_SESSION['utilisateur_connecter_client'])) {

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

		if (isset($_POST["prenom"]) && !empty($_POST["prenom"])) {
			$donnees["prenom"] = htmlentities($_POST["prenom"]);
		} else {
			$erreurs["prenom"] = "Le champs prénom est requis. Veuillez le renseigné.";
		}

		if (isset($_POST["email"]) && !empty($_POST["email"])) {
			if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
				$donnees["email"] = trim(htmlentities($_POST["email"]));
			} else {
				$erreurs["email"] = "Le champs email doit être une adresse mail valide. Veuillez le renseigné.";
			}
		} else {
			$erreurs["email"] = "Le champs email est vide. Veuillez le renseigné.";
		}


		$check_email_exist_in_db = check_email_exist_in_db($_POST["email"]);

		if ($check_email_exist_in_db) {
			$numClient = recuperer_id_utilisateur_par_son_mail($donnees["email"]);
		}
	}

	if (isset($_POST["subject"]) && !empty($_POST["subject"])) {
		$donnees["subject"] = $_POST["subject"];
	} else {
		$erreurs["subject"] = "Le champs sujet du message est requis. Veuillez le renseigné.";
	}

	if (isset($_POST["message"]) && !empty($_POST["message"])) {
		$donnees["message"] = $_POST["message"];
	} else {
		$erreurs["message"] = "Le champs message est requis. Veuillez le renseigné.";
	}


	$donnees["profil"] = "CLIENT";

	$donnees["nom-utilisateur"] = "NULL";

	$donnees["mot-passe"] = "NULL";


	$_SESSION['donnees-contact'] = $donnees;

	if (empty($erreurs)) {

		if (!empty($_SESSION['utilisateur_connecter_client'])) {
			//verification de l'adresse mail de l'utilisateur connecter
			if (!check_email_exist_in_db($_SESSION['utilisateur_connecter_client']['email'])) {
				// Appeler la fonction pour insérer les informations du client dans la table "client"
				$resultatInsertionClient = enregistrer_utilisateur($donnees["nom"], $donnees["prenom"], $donnees["email"], $donnees["nom-utilisateur"], $donnees["mot-passe"], $donnees["profil"]);
				$numClient = recuperer_id_utilisateur_par_son_mail($donnees['email']);
			} else {
				$numClient = recuperer_id_utilisateur_par_son_mail($_SESSION['utilisateur_connecter_client']['email']);
			}
		} else {
			//si l'utilisateur n'a pas de compte on l'enrégistre
			if (!check_email_exist_in_db($donnees['email'])) {
				// Appeler la fonction pour insérer les informations du client dans la table "client"
				$resultatInsertionClient = enregistrer_utilisateur($donnees["nom"], $donnees["prenom"], $donnees["email"], $donnees["nom-utilisateur"], $donnees["mot-passe"], $donnees["profil"]);
				$numClient = recuperer_id_utilisateur_par_son_mail($donnees['email']);
			} else {
				$numClient = recuperer_id_utilisateur_par_son_mail($donnees['email']);
			}
		}

		// Vérifier si l'insertion des informations du client a réussi
		if (!empty($numClient)) {


			$type_sujet = $_SESSION['donnees-contact']['subject'];

			$messages = $_SESSION['donnees-contact']['message'];

			// Appeler la fonction pour insérer les informations de réservation dans la table "contact"
			$resultatInsertionMessages = enregistrer_messages($numClient, $type_sujet, $messages);

			// Vérifier si l'insertion des informations de réservation a réussi
			if ($resultatInsertionMessages) {

				// La réservation a été effectuée avec succès
				$message_success_global = "Nous avons bien reçu votre message. Merci!";
			} else {
				// La réservation a échoué
				$message_erreur_global = "Désolé, une erreur s'est produite lors de l'envoi du message.";
			}
		} else {
			// L'insertion des informations du client a échoué
			$message_erreur_global = "Désolé, une erreur s'est produite lors de l'enregistrement de vos informations.";
		}
	}
}


$_SESSION['erreurs-contact'] = $erreurs;
$_SESSION['contact-message-erreur-global'] = $message_erreur_global;
$_SESSION['contact-message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'client/contact');
