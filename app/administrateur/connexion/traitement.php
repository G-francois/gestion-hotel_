<?php

$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];

if (!empty($_POST["email-nom-utilisateur"])) {

    $donnees["email-nom-utilisateur"] = $_POST["email-nom-utilisateur"];
} else {

    $erreurs["email-nom-utilisateur"] = "Le champs email ou nom utilisateur est requis. Veuillez le renseigné.";
}

if (!empty($_POST["mot-passe"])) {

    $donnees["mot-passe"] = trim(htmlentities($_POST['mot-passe']));
} else {

    $erreurs["mot-passe"] = "Le champs mot de passe est requis. Veuillez le renseigné.";
}

$_SESSION['donnees-utilisateur-admin'] = $donnees;

if (empty($erreurs)) {

    $user = check_if_user_exist($donnees["email-nom-utilisateur"], $donnees["mot-passe"], "ADMINISTRATEUR");

    if (!empty($user)) {

        $_SESSION["utilisateur_connecter_admin"] = $user;

        header('location:' . PATH_PROJECT . 'administrateur/reservations/liste-reservations');

        exit;
    } else {
        $message_erreur_global = "L'adresse email ou le mot de passe est incorrecte. Veuillez réssayer.";
    }
} else {
    $_SESSION['connexion-erreurs-admin'] = $erreurs;
}

$_SESSION['connexion-message-erreur-global'] = $message_erreur_global;

$_SESSION['connexion-message-success-global'] = $message_success_global;

header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
