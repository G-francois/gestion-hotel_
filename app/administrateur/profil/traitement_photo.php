<?php

$_SESSION['photo-erreurs-admin'] = "";

$_SESSION['donnees-utilisateur-admin'] = [];

$donnees = [];

$erreurs = [];

$idUtilisateur = $_SESSION['utilisateur_connecter_admin']['nom_utilisateur'];

$dossierImage = "public/images/";

$dossierUtilisateur = $dossierImage . "upload/" . $idUtilisateur . "/";

$dossierImage = "public/images/";

if (!is_dir($dossierImage . "upload/")) {
    // Création du dossier "upload" s'il n'existe pas
    mkdir($dossierImage . "upload/");
}

// Vérifier si le dossier Utilisateurs existe, sinon le creer
$dossierUtilisateurs = $dossierImage . "upload/Utilisateurs/";
if (!is_dir($dossierUtilisateurs)) {
    mkdir($dossierUtilisateurs);
}


// Vérifier si le dossier categorie existe dans le dossier repas, sinon le creer
$dossierUsername = $dossierUtilisateurs . $idUtilisateur . "/";
if (!is_dir($dossierUsername)) {
    mkdir($dossierUsername);
}

// Le chemin de destination pour enregistrer l'image
$image_path = $dossierUsername . $_FILES["image"]["name"];


if (isset($_POST['change_photo'])) {

    if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_admin']['id'])) {

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

            if ($_FILES["image"]["size"] <= 3000000) {

                $file_name = $_FILES["image"]["name"];

                $file_info = pathinfo($file_name);

                $file_ext = $file_info["extension"];

                $allowed_ext = ["png", "jpg", "jpeg", "gif"];

                if (in_array(strtolower($file_ext), $allowed_ext)) {

                    move_uploaded_file($_FILES['image']['tmp_name'], $dossierUsername . basename($_FILES['image']['name']));

                    $profiledonnees["image"] = PATH_PROJECT . $dossierUsername . basename($_FILES['image']['name']);

                    if (mise_a_jour_avatar($_SESSION['utilisateur_connecter_admin']['id'], $profiledonnees["image"])) {

                        $new_user_data = recuperer_mettre_a_jour_informations_utilisateur( $_SESSION['utilisateur_connecter_admin']['id']);

                        if (!empty($new_user_data)) {

                            $_SESSION['utilisateur_connecter_admin'] = $new_user_data;

                            header('location: ' . PATH_PROJECT . 'administrateur/dashboard/profil');
                        }
                    } else {

                        $_SESSION['photo-erreurs-admin'] = "La mise à jour de l'image à echouer.";
                    }
                } else {
                    $_SESSION['photo-erreurs-admin'] = "L'extension de votre image n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";
                }
            } else {
                $_SESSION['photo-erreurs-admin'] = "Fichier trop lourd. Poids maximum autorisé : 3mo";
            }
        } else {

            $profiledonnees["image"] = $donnees[0]["image_profil"];
        }
    } else {
        $_SESSION['photo-erreurs-admin'] = "La mise à jour à echouer. Vérifier votre mot de passe et réessayez.";
        
    }
}

header('location:' . PATH_PROJECT . 'administrateur/dashboard/profil');