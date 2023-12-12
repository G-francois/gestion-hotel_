<?php

$_SESSION['photo-erreurs'] = "";

$_SESSION['donnees-utilisateur'] = [];

$donnees = [];

$erreurs = [];



if (isset($_POST['supprimer_photo'])) {

    if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_recept']['id'])) {

        if (mise_a_jour_avatar($_SESSION['utilisateur_connecter_recept']['id'], 'no_image')) {

            $new_user_data = recuperer_mettre_a_jour_informations_utilisateur($_SESSION['utilisateur_connecter_recept']['id']);

            if (!empty($new_user_data)) {

                $_SESSION['utilisateur_connecter_recept'] = $new_user_data;
            }
        }
    } else {
        $_SESSION['suppression-erreurs'] = "La suppression de la photo à echouer. Vérifier votre mot de passe et réessayez.";
    }
}


header('location:' . PATH_PROJECT . 'receptionniste/dashboard/profil');
