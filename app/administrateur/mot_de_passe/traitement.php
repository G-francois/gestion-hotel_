<?php

use Random\Engine\Secure;

$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];


if (!empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $donnees["email"] = $_POST["email"];
} else {
    $erreurs["email"] = "Le champs email est requis. Veuillez le renseigné.";
}

$_SESSION['donnees-utilisateur-admin'] = $donnees;
$_SESSION['verification-erreurs-admin'] = $erreurs;


if (empty($erreurs)) {

    if (check_email_exist_in_db($_POST["email"])) {
        $id_utilisateur = recuperer_id_utilisateur_par_son_mail($_POST['email']);

        if (verifier_profil_administrateur($id_utilisateur)) {
            $_SESSION['id_user'] = $id_utilisateur;
            $message_success_global = "Vous pouvez effectuer la modification de votre mot de passe à présent";
            header('location: ' . PATH_PROJECT . 'administrateur/mot_de_passe/new_mot_passe');
        } else {
            header('location: ' . PATH_PROJECT . 'administrateur/mot_de_passe/index');
            $message_erreur_global = "Oups ! Vous n'avez pas les droits d'administrateur.";
        }
    } else {
        header('location: ' . PATH_PROJECT . 'administrateur/mot_de_passe/index');
        $message_erreur_global = "Oups ! Une erreur s'est produite lors de la vérification de l'adresse mail de l'utilisateur.";
    }
} elseif (!isset($erreurs['email'])) {
    header('location: ' . PATH_PROJECT . 'administrateur/mot_de_passe/index');
    $message_erreur_global = "Oups ! Une erreur s'est produite lors de la vérification de l'adresse mail de l'utilisateur.";
}

$_SESSION['inscription-message-erreur-global'] = $message_erreur_global;
$_SESSION['inscription-message-success-global'] = $message_success_global;
