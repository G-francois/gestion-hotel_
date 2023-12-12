
<?php

$_SESSION['desactivation-erreurs'] = "";

$_SESSION['donnees-utilisateur'] = [];

$donnees = [];

$erreurs = [];

if (isset($_POST['desactivation'])) {

    if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_recept']['id'])) {
        if (desactiver_utilisateur($_SESSION['utilisateur_connecter_recept']['id'])) {
            session_destroy();
            header('location:' . PATH_PROJECT . 'receptionniste/connexion/index');
        } else {
            $_SESSION['desactivation-erreurs'] = "La desactivation à echouer. Veuiller réessayez.";
        }
    } else {
        $_SESSION['desactivation-erreurs'] = "La desactivation à echouer. Vérifier votre mot de passe et réessayez.";
    }
} else {
    $_SESSION['desactivation-erreurs'] = "La desactivation à echouer. Veuiller réessayez.";
}

header('location:' . PATH_PROJECT . 'receptionniste/dashboard/profil');