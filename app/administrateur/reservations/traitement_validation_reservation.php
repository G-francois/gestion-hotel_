<?php
$donnees = [];
$erreurs = [];
$message_erreur_global = "";
$message_success_global = "";



// Vérifier si le numéro de réservation est fourni
if (!empty($_POST["num_res"])) {
    $donnees["num_res"] = $_POST["num_res"];
    $numRes = $donnees["num_res"];
    // die(var_dump($numRes));
    // Appeler la fonction pour vérifier l'existence de num_res dans la table "reservation"
    $reservationExiste = verifier_existence_num_res($donnees["num_res"]);

    $donneesReservation = recuperer_donnees_reservation_par_num_res($numRes);
    // die(var_dump($donneesReservation));

    $clientID = !empty($donneesReservation['num_clt']) ? $donneesReservation['num_clt'] : null;
    // die(var_dump($clientID));
    
    if (!$reservationExiste) {
        $erreurs["num_res"] = "Le numéro de réservation n'existe pas.";
    } elseif (!verifier_appartenance_reservation($numRes, $clientID)) {
        // La réservation existe, mais ne correspond pas au client connecté
        $erreurs["num_res"] = "Le numéro de réservation ne vous appartient pas.";
    }
} else {
    $erreurs["num_res"] = "Le champ numéro de réservation est requis. Veuillez le renseigner.";
}


// Appeler la fonction d'activation de l'utilisateur
if (activer_reservation($numRes)) {
    $message_success_global = "La réservation est activer avec succès !";
} else {
    $message_erreur_global = "Oups ! Une erreur s'est produite lors de l'activation de la reservatio n.";
}

$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('Location: ' . PATH_PROJECT . 'administrateur/reservations/liste-reservations');
