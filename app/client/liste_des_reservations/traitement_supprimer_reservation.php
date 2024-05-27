<?php
$_SESSION['suppression-erreurs'] = "";
$_SESSION['donnees-utilisateur'] = [];

$message_erreur_global = "";
$message_success_global = "";

$donnees = [];
$erreurs = [];

// Récupération de l'ID de la réservation et du type de chambre
$num_res = $_POST['reservation_id'];

// die(var_dump($num_res));
// Vérification de la demande de suppression
if (isset($_POST['supprimer'])) {

	// Vérification de l'existence du mot de passe
	if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_client']['id'])) {

		$liste_chambres_reservations = recuperer_liste_chambres_reservations($num_res);

		//die(var_dump($liste_chambres_reservations));

		foreach ($liste_chambres_reservations as $_chambre) {
			mettre_a_jour_statut_chambre_reserver($_chambre['num_chambre'], 1);
		}

		// Suppression definitive des accompagnateurs, chambre reservations et la réservation
		if (supprimer_accompagnateur_administrateur($num_res) && supprimer_chambre_reservations($num_res) && supprimer_reservations_administrateur($num_res)) {


			$message_success_global = "La suppression de la réservation a été effectuée avec succès.";
		} else {
			$message_erreur_global = "La suppression a échoué. Veuillez réessayer.";
		}
	} else {
		$message_erreur_global = "La suppression a échoué. Veuillez vérifier votre mot de passe et réessayer.";
	}
} else {
	$message_erreur_global = "La suppression a échoué. Veuillez réessayer.";
}

// Stockage des messages dans les variables de session et redirection vers la page de liste des réservations
$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'client/liste_des_reservations');
