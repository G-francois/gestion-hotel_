
<?php

$_SESSION['desactivation-erreurs'] = "";

$_SESSION['donnees-utilisateur-admin'] = [];

$donnees = [];

$erreurs = [];

if (isset($_POST['desactivation'])) {

    if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_admin']['id'])) {
        if (desactiver_utilisateur($_SESSION['utilisateur_connecter_admin']['id'])) {
            session_destroy();
            header('location:' . PATH_PROJECT . 'administrateur/connexion/index');
        } else {
            $_SESSION['desactivation-erreurs'] = "La désactivation à échouer. Veuillez réessayez.";
        }
    } else {
        $_SESSION['desactivation-erreurs'] = "La désactivation à échouer. Vérifier votre mot de passe et réessayez.";
    }
} else {
    $_SESSION['desactivation-erreurs'] = "La désactivation à échouer. Veuillez réessayez.";
}

header('location:' . PATH_PROJECT . 'administrateur/dashboard/profil');