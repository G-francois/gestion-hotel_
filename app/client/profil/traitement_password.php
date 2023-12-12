<?php

$donnees = [];
$erreurs = [];

// Vérifie si l'action est de changer le mot de passe
if (isset($_POST['change_password'])) {

    // Vérifie si le champ du nouveau mot de passe est renseigné
    if (isset($_POST["newpassword"]) && !empty($_POST["newpassword"])) {
        $donnees["newpassword"] = $_POST["newpassword"];
    } else {
        $erreurs["newpassword"] = "Le champ du nouveau mot de passe est requis. Veuillez le renseigner.";
    }

    // Vérifie si le champ du nouveau mot de passe est renseigné et si le champ du mot de passe retapé est vide
    if (isset($_POST["newpassword"]) && !empty($_POST["newpassword"]) && strlen($_POST["newpassword"]) >= 8 && empty($_POST["renewpassword"])) {
        $erreurs["renewpassword"] = "Entrez votre mot de passe à nouveau.";
    }

    // Vérifie si le mot de passe retapé est différent du nouveau mot de passe saisi
    if ((isset($_POST["renewpassword"]) && !empty($_POST["renewpassword"]) && strlen($_POST["newpassword"]) >= 8 && $_POST["renewpassword"] != $_POST["newpassword"])) {
        $erreurs["renewpassword"] = "Mot de passe erroné. Entrez le mot de passe du champ précédent.";
    }

    // Vérifie si le nouveau mot de passe est renseigné et si le mot de passe retapé correspond au nouveau mot de passe
    if ((isset($_POST["newpassword"]) && !empty($_POST["newpassword"]) && strlen($_POST["newpassword"]) >= 8 && $_POST["renewpassword"] == $_POST["newpassword"])) {
        $donnees["newpassword"] = $_POST['newpassword'];
    }

    // Vérifie si le mot de passe fourni correspond au mot de passe de l'utilisateur connecté
    if (!check_password_exist($_POST['password'], $_SESSION['utilisateur_connecter_client']['id'])) {
        $erreurs["password"] = "Mot de passe incorrect. Veuillez réessayer.";
    }
}

// Vérifie s'il n'y a pas d'erreurs
if (empty($erreurs)) {
    // Met à jour le mot de passe de l'utilisateur dans la base de données
    if (mise_a_jour_mot_passe($_SESSION['utilisateur_connecter_client']['id'], $donnees["newpassword"])) {
        // Détruit la session après la mise à jour du mot de passe
        session_destroy();
        // Redirige vers la page de connexion après la mise à jour du mot de passe
        header('location:' . PATH_PROJECT . 'client/connexion');
    } else {
        // Stocke les erreurs s'il y a eu un problème lors de la mise à jour du mot de passe
        $_SESSION['changement-erreurs'] = $erreurs;
        // Redirige vers la page de profil en cas de problème lors de la mise à jour du mot de passe
        header('location:' . PATH_PROJECT . 'client/profil');
    }
} else {
    // Stocke les erreurs s'il y a eu des erreurs dans les champs saisis
    $_SESSION['changement-erreurs'] = $erreurs;
    // Redirige vers la page de profil en cas d'erreurs dans les champs saisis
    header('location:' . PATH_PROJECT . 'client/profil');
}
