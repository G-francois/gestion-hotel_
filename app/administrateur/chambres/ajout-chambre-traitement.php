<?php
// Inclure ici les fonctions nécessaires, telles que check_if_chambre_exist_in_db et enregistrer_chambre
// Assurez-vous que PATH_PROJECT est défini dans votre configuration
$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];

if (isset($_POST["cod_typ"]) && !empty($_POST["cod_typ"])) {
    $donnees["cod_typ"] = $_POST["cod_typ"];
} else {
    $erreurs["cod_typ"] = "Le champ code type est requis. Veuillez le renseigner.";
}

if (isset($_POST["lib_typ"]) && !empty($_POST["lib_typ"])) {
    $donnees["lib_typ"] = $_POST["lib_typ"];
} else {
    $erreurs["lib_typ"] = "Le champ libellé type de chambre est requis. Veuillez le renseigner.";
}

if (isset($_POST["details_chambre"]) && !empty($_POST["details_chambre"])) {
    $donnees["details_chambre"] = $_POST["details_chambre"];
} else {
    $erreurs["details_chambre"] = "Le champ informations est requis. Veuillez le renseigner.";
}

if (isset($_POST["details_personne_chambre"]) && !empty($_POST["details_personne_chambre"])) {
    $donnees["details_personne_chambre"] = $_POST["details_personne_chambre"];
} else {
    $erreurs["details_personne_chambre"] = "Le champ nombre de personne est requis. Veuillez le renseigner.";
}

if (isset($_POST["details_superficie_chambre"]) && !empty($_POST["details_superficie_chambre"])) {
    $donnees["details_superficie_chambre"] = $_POST["details_superficie_chambre"];
} else {
    $erreurs["details_superficie_chambre"] = "Le champ superficie est requis. Veuillez le renseigner.";
}

if (isset($_POST["pu"]) && !empty($_POST["pu"])) {
    $donnees["pu"] = $_POST["pu"];
} else {
    $erreurs["pu"] = "Le champ prix unitaire est requis. Veuillez le renseigner.";
}

// Vérifier si une image a été téléchargée
if (isset($_FILES["image"]) && !empty($_FILES["image"]["name"])) {

    if ($_FILES["image"]["size"] > 3000000) {
        $erreurs["image"] = "La taille de l'image est supérieure à 3 Mo. Veuillez télécharger une image plus petite.";
    } else {
        $dossierImage = "public/images/";

        // Vérifier si le dossier chambre existe, sinon le creer
        $dossierChambre = $dossierImage . "Chambres/";
        if (!is_dir($dossierChambre)) {
            mkdir($dossierChambre);
        }

        // Vérifier si le dossier libelle type existe dans le dossier chambres, sinon le creer
        $dossierLibelle = $dossierChambre . $donnees["lib_typ"] . "/";
        if (!is_dir($dossierLibelle)) {
            mkdir($dossierLibelle);
        }

        // Le chemin de destination pour enregistrer l'image
        $image_path = $dossierLibelle . $_FILES["image"]["name"];

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
    $erreurs["image"] = "Veuillez télécharger une image pour la chambre.";
}

if (empty($erreurs)) {
    // Enregistrez ensuite les données de la chambre dans la base de données
    $resultat = enregistrer_chambre($donnees["cod_typ"], $donnees["lib_typ"], $donnees["details_chambre"], $donnees["details_personne_chambre"], $donnees["details_superficie_chambre"],  $donnees["pu"], $donnees["image_path"]);

    if ($resultat) {
        $message_success_global = "La chambre a été enregistrée avec succès !";
    } else {
        $message_erreur_global = "Oups ! Une erreur s'est produite lors de l'enregistrement de la chambre.";
    }
}

// Stockage des données dans des variables de session
$_SESSION['donnees-chambre'] = $donnees;
$_SESSION['erreurs-chambre'] = $erreurs;
$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
// Redirection vers la page d'ajout de chambre
header('location: ' . PATH_PROJECT . 'administrateur/chambres/');
