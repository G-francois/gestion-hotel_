<?php

// Initialise les variables de session pour les erreurs de désactivation et les données utilisateur
$_SESSION['desactivation-erreurs'] = "";
$_SESSION['donnees-utilisateur'] = [];

// Initialise les tableaux de données et d'erreurs
$donnees = [];
$erreurs = [];

// Vérifie si l'action est de désactiver le compte utilisateur
if (isset($_POST['desactivation'])) {

    // Vérifie si le mot de passe fourni correspond au mot de passe de l'utilisateur connecté
    if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_client']['id'])) {
        // Désactive l'utilisateur dans la base de données
        if (desactiver_utilisateur($_SESSION['utilisateur_connecter_client']['id'])) {
            // Détruit la session après la désactivation de l'utilisateur
            session_destroy();
            // Redirige l'utilisateur vers la page d'accueil après la désactivation
            header('location:' . PATH_PROJECT . 'client/acceuil');
        } else {
            // Stocke un message d'erreur en cas d'échec de la désactivation et redirige vers la page de profil
            $_SESSION['desactivation-erreurs'] = "La désactivation a échoué. Veuillez réessayer.";
            header('location:' . PATH_PROJECT . 'client/profil');
        }
    } else {
        // Stocke un message d'erreur en cas de mot de passe incorrect et redirige vers la page de profil
        $_SESSION['desactivation-erreurs'] = "La désactivation a échoué. Veuillez vérifier votre mot de passe et réessayer.";
        header('location:' . PATH_PROJECT . 'client/profil');
    }
} else {
    // Gère le cas où l'action de désactivation n'est pas définie correctement
    $_SESSION['desactivation-erreurs'] = "La désactivation a échoué. Veuillez réessayer.";
    header('location:' . PATH_PROJECT . 'client/profil');
}
