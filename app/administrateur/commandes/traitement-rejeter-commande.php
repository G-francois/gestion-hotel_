<?php
$donnees = [];
$erreurs = [];
$message_erreur_global = "";
$message_success_global = "";

// Récupérer l'ID du client connecté depuis la session
$clientConnecteID = $_SESSION['utilisateur_connecter_client']['id'];

// Vérifier si le numéro de réservation est fourni
if (isset($_POST["num_res"]) && !empty($_POST["num_res"])) {
    $donnees["num_res"] = $_POST["num_res"];
} else {
    $erreurs["num_res"] = "Le champ numéro de réservation est requis. Veuillez le renseigner.";
}

$num_res = $donnees["num_res"];
$donneesReservation = recuperer_donnee_reservation_par_son_id($num_res);

$clientConnecteID = !empty($donneesReservations['num_clt']) ? $donneesReservations['num_clt'] : null;

die(var_dump($donneesReservation));



// Vérifier si le numéro de commande est fourni
if (isset($_POST["num_cmd"]) && !empty($_POST["num_cmd"])) {
    $donnees["num_cmd"] = $_POST["num_cmd"];
    $num_cmd = $donnees["num_cmd"];

    // Appeler la fonction pour vérifier l'existence de num_res dans la table "reservation"
    $commandeExiste = verifier_existence_num_res($donnees["num_cmd"]);

    $donneesReservation = recuperer_donnees_reservation_par_num_res($num_res);

    if (!$commandeExiste) {
        $erreurs["num_cmd"] = "Le numéro de réservation n'existe pas.";
    } elseif (!verifier_appartenance_reservation($numRes, $clientConnecteID)) {
        // La réservation existe, mais ne correspond pas au client connecté
        $erreurs["num_cmd"] = "Le numéro de réservation ne vous appartient pas.";
    }
} else {
    $erreurs["num_res"] = "Le champ numéro de réservation est requis. Veuillez le renseigner.";
}

$liste_chambres_reservations = recuperer_liste_chambres_reservations($numRes);

//die(var_dump($liste_chambres_reservations));

foreach ($liste_chambres_reservations as $_chambre) {
    mettre_a_jour_statut_chambre_reserver($_chambre['num_chambre'], 1);
}

// Appeler la fonction d'activation de l'utilisateur
if (rejeter_reservation($numRes)) {
    $message_success_global = "La réservation a été rejeter avec succès !";
} else {
    $message_erreur_global = "Oups ! Une erreur s'est produite lors de l'activation de la reservatio n.";
}

$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('Location: ' . PATH_PROJECT . 'administrateur/reservations/liste-reservations');
