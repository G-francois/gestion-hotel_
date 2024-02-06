<?php
$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];


if (isset($_POST["nom_repas"]) && !empty($_POST["nom_repas"])) {
    $donnees["nom_repas"] = $_POST["nom_repas"];
} else {
    $erreurs["nom_repas"] = "Le champs nom du repas est requis. Veuillez le renseigné.";
}

if (isset($_POST["descriptions"]) && !empty($_POST["descriptions"])) {
    $donnees["descriptions"] = $_POST["descriptions"];
} else {
    $erreurs["descriptions"] = "Le champs description est requis. Veuillez le renseigné.";
}

if (isset($_POST["pu_repas"]) && !empty($_POST["pu_repas"])) {
    $donnees["pu_repas"] = $_POST["pu_repas"];
} else {
    $erreurs["pu_repas"] = "Le champs prix unitaire est requis. Veuillez le renseigné.";
}

if (isset($_POST["categorie"]) && !empty($_POST["categorie"])) {
    $donnees["categorie"] = $_POST["categorie"];
} else {
    $erreurs["categorie"] = "Le champ categorie est requis. Veuillez le renseigner.";
}

// Vérifier si une image a été téléchargée
if (isset($_FILES["image"]) && !empty($_FILES["image"]["name"])) {

    if ($_FILES["image"]["size"] > 3000000) {
        $erreurs["image"] = "La taille de l'image est supérieure à 3 Mo. Veuillez télécharger une image plus petite.";
    } else {
        $dossierImage = "public/images/";

        // Vérifier si le dossier repas existe, sinon le creer
        $dossierRepas = $dossierImage . "repas/";
        if (!is_dir($dossierRepas)) {
            mkdir($dossierRepas);
        }

        // Vérifier si le dossier categorie existe dans le dossier repas, sinon le creer
        $dossierCategorie = $dossierRepas . $donnees["categorie"] . "/";
        if (!is_dir($dossierCategorie)) {
            mkdir($dossierCategorie);
        }

        // Le chemin de destination pour enregistrer l'image
        $image_path = $dossierCategorie . $_FILES["image"]["name"];

        // Vérifier le type de fichier (vous pouvez ajouter d'autres vérifications si nécessaire)
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_extensions)) {
            // Déplacer le fichier téléchargé vers le dossier de destination
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
                // Ajoutez PATH_PROJECT au chemin de l'image
                $image_path_with_project = PATH_PROJECT . $image_path;
                $donnees["image_path"] = $image_path_with_project;
            } else {
                $erreurs["image"] = "Erreur lors de l'enregistrement de l'image.";
            }
        } else {
            $erreurs["image"] = "L'extension de fichier n'est pas autorisée. Veuillez télécharger une image au format JPG, JPEG, PNG ou GIF.";
        }
    }
} else {
    $erreurs["image"] = "Veuillez télécharger une image pour le repas.";
}



if (empty($erreurs)) {

    if (!check_if_repas_exist_in_db($_POST["nom_repas"])) {

        $resultat = enregistrer_repas($donnees["nom_repas"], $donnees["descriptions"], $donnees["pu_repas"], $donnees["categorie"], $donnees["image_path"]);

        if ($resultat) {

            $message_success_global = "Le repas a été enrégistrer avec succès !";
        } else {

            $message_erreur_global = "Oups ! Une erreur s'est produite lors de l'enregistrement du repas.";
        }
    } else {

        $erreurs["nom_repas"] = "Oups! Le nom du repas existe deja. Veuillez réesayer.";
    }
}

$_SESSION['donnees-repas'] = $donnees;
$_SESSION['erreurs-repas'] = $erreurs;
$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'administrateur/repas');
