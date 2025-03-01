<?php
// Inclure ici les fonctions nécessaires, telles que check_if_chambre_exist_in_db et enregistrer_chambre
// Assurez-vous que PATH_PROJECT est défini dans votre configuration
$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];

if (!empty($_POST["type_chambre"])) {
    $donnees["type_chambre"] = $_POST["type_chambre"];
} else {
    $erreurs["type_chambre"] = "Le champ nom type est requis. Veuillez le renseigner.";
}

if (!empty($_POST["details_chambre"])) {
    $donnees["details_chambre"] = $_POST["details_chambre"];
} else {
    $erreurs["details_chambre"] = "Le champ informations est requis. Veuillez le renseigner.";
}

if (!empty($_POST["details_personne_chambre"])) {
    $donnees["details_personne_chambre"] = $_POST["details_personne_chambre"];
} else {
    $erreurs["details_personne_chambre"] = "Le champ nombre de personne est requis. Veuillez le renseigner.";
}

if (!empty($_POST["details_superficie_chambre"])) {
    $donnees["details_superficie_chambre"] = $_POST["details_superficie_chambre"];
} else {
    $erreurs["details_superficie_chambre"] = "Le champ superficie est requis. Veuillez le renseigner.";
}

if (!empty($_POST["pu"])) {
    $donnees["pu"] = $_POST["pu"];
} else {
    $erreurs["pu"] = "Le champ prix unitaire est requis. Veuillez le renseigner.";
}

// die(var_dump($donnees));


if (empty($erreurs)) {
    // Enregistrez ensuite les données de la chambre dans la base de données
    $resultat = enregistrer_type_chambre($donnees["type_chambre"], $donnees["details_chambre"], $donnees["details_personne_chambre"], $donnees["details_superficie_chambre"],  $donnees["pu"]);

    if ($resultat) {
        $message_success_global = "Le type de chambre a été enregistrée avec succès !";
    } else {
        $message_erreur_global = "Oups ! Une erreur s'est produite lors de l'enregistrement de la chambre.";
    }
}

// Stockage des données dans des variables de session
$_SESSION['donnees-type-chambre'] = $donnees;
$_SESSION['erreurs-type-chambre'] = $erreurs;
$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
// Redirection vers la page d'ajout de chambre
header('location: ' . PATH_PROJECT . 'administrateur/chambres/ajouter-type');
