<?php
$message_erreur_global = "";
$message_success_global = "";
$donnees =  recuperer_repas_par_son_code_repas($params[3]);
$new_donnees = [];
$erreurs = [];

if (isset($_POST['nom_repas']) && !empty($_POST['nom_repas']) && $_POST['nom_repas'] != $donnees['nom_repas']) {
    $new_data['nom_repas'] = $_POST['nom_repas'];
} else {
    if (empty($_POST['nom_repas'])) {
        $erreurs["nom_repas"] = "Le champ nom repas ne doit pas être vide.";
    } else {
        $new_data['nom_repas'] = $donnees['nom_repas'];
    }
}

if (isset($_POST['descriptions']) && !empty($_POST['descriptions']) && $_POST['descriptions'] != $donnees['descriptions']) {
    $new_data['descriptions'] = $_POST['descriptions'];
} else {
    if (empty($_POST['descriptions'])) {
        $erreurs["descriptions"] = "Le champ ndescription ne doit pas être vide.";
    } else {
        $new_data['descriptions'] = $donnees['descriptions'];
    }
}

if (isset($_POST['pu_repas']) && !empty($_POST['pu_repas']) && $_POST['pu_repas'] != $donnees['pu_repas']) {
    $new_data['pu_repas'] = $_POST['pu_repas'];
} else {
    if (empty($_POST['pu_repas'])) {
        $erreurs["pu_repas"] = "Le champ prix unitaire repas ne doit pas être vide.";
    } else {
        $new_data['pu_repas'] = $donnees['pu_repas'];
    }
}

if (isset($_POST['categorie']) && !empty($_POST['categorie']) && $_POST['categorie'] != $donnees['categorie']) {
    $new_data['categorie'] = $_POST['categorie'];
} else {
    if (empty($_POST['categorie'])) {
        $erreurs["categorie"] = "Le champ categorie ne doit pas être vide.";
    } else {
        $new_data['categorie'] = $donnees['categorie'];
    }
}

$_SESSION['donnees-repas-modifier'] = $new_data;
$_SESSION['erreurs-repas-modifier'] = $erreurs;


if (empty($erreurs)) {

    if (!empty($params[3])) {

        $cod_repas = $params[3];

        $miseajour = modifier_repas($cod_repas, $new_data["nom_repas"], $new_data["descriptions"], $new_data["pu_repas"], $new_data["categorie"]);

        if ($miseajour) {
            $message_success_global = "Le repas a été modifié avec succès !";
        } else {
            // La  mise à jour du statut a échoué
            $message_erreur_global =  "Oups ! Une erreur s'est produite lors de la modification du repas. Veuiller réessayez.";
        }
    } else {
        // Aucune chambre disponible de type "Doubles"
        $message_erreur_global = "Désolé, il n'y a pas de repas disponible pour le moment.";
    }

}


$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('Location: ' . PATH_PROJECT . 'administrateur/repas/modifier-repas/' . $params[3]);
