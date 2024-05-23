<?php

$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];

// Vérification de l'existence du mot de passe
if (check_password_exist($_POST['password'], $_SESSION['utilisateur_connecter_client']['id'])) {

	// Vérification et récupération des champs du formulaire
	if (isset($_POST["subject"]) && !empty($_POST["subject"])) {
		$donnees["subject"] = $_POST["subject"];
	} else {
		$erreurs["subject"] = "Le champ sujet du message est requis. Veuillez le renseigner.";
	}

	if (isset($_POST["message"]) && !empty($_POST["message"])) {
		$donnees["message"] = $_POST["message"];
	} else {
		$erreurs["message"] = "Le champ message est requis. Veuillez le renseigner.";
	}

	// Vérification si des champs sont vides
	if (empty($donnees['subject']) || empty($donnees['message'])) {
		$message_erreur_global = 'Une erreur est survenue. Il se peut que des informations manquent pour certains repas que vous avez soumis. Un repas soumis doit avoir un nom et un prix.';
	}

	// Si les champs ne sont pas vides et qu'aucune erreur globale n'a été rencontrée, mise à jour du message
	if (!empty($donnees['subject']) && !empty($donnees['message']) && empty($message_erreur_global)) {

		$id = $_POST['message_id'];
		$type_sujet = $donnees["subject"];
		$messages = $donnees["message"];

		$mise_a_jour_message = modifier_messages($id, $type_sujet, $messages);

		if ($mise_a_jour_message) {
			// Le message a été effectué avec succès
			$message_success_global = "Le message a été modifié avec succès.";
		} else {
			// La mise à jour du message a échoué
			$message_erreur_global = "Désolé, une erreur s'est produite lors de la modification du message.";
		}
	}
} else {
	// Mot de passe incorrect
	$message_erreur_global = "La modification a échoué. Vérifiez votre mot de passe et réessayez.";
}

// Stockage des données dans les variables de session
$_SESSION['donnees-contact'] = $donnees;
$_SESSION['erreurs-contact'] = $erreurs;

// Redirection vers la page de liste des messages avec un message de succès ou d'erreur
$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'client/liste_des_messages');
