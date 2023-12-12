<?php

$donnees = []; // Initialise un tableau pour stocker les données
$message_erreur_global = ""; // Initialise une variable pour stocker un éventuel message d'erreur global
$message_success_global = ""; // Initialise une variable pour stocker un éventuel message de succès global
$erreurs = []; // Initialise un tableau pour stocker les erreurs

$num_cmd = $_POST['commande_id']; // Récupère l'identifiant de la commande à supprimer

if (isset($_POST['supprimer'])) {

    // Vérifie si le mot de passe est correct
    if (check_password_exist($_POST['password'], $_SESSION['utilisateur_connecter_client']['id'])) {
        // Appelle la fonction de suppression de commande
        if (supprimer_commande($num_cmd)) {
            $message_success_global = "La suppression de la commande a été effectuée avec succès.";
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

// Redirige vers la page de liste des commandes
header('location: ' . PATH_PROJECT . 'client/liste_des_commandes');
