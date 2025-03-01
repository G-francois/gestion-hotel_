
<?php
$donnees =  recuperer_type_chambre_par_son_id($params[3]);
$new_donnees = [];
$erreurs = [];
$message_erreur_global = "";
$message_success_global = "";

if (!empty($_POST['type_chambre']) && $_POST['type_chambre'] != $donnees['type_chambre']) {
    $new_data['type_chambre'] = $_POST['type_chambre'];
} else {
    if (empty($_POST['type_chambre'])) {
        $erreurs["type_chambre"] = "Le champ nom du type ne doit pas être vide.";
    } else {
        $new_data['type_chambre'] = $donnees['type_chambre'];
    }
}

if (!empty($_POST['details']) && $_POST['details'] != $donnees['details']) {
    $new_data['details'] = $_POST['details'];
} else {
    if (empty($_POST['details'])) {
        $erreurs["details"] = "Le champ details ne doit pas être vide.";
    } else {
        $new_data['details'] = $donnees['details'];
    }
}

if (!empty($_POST['personnes']) && $_POST['personnes'] != $donnees['personnes']) {
    $new_data['personnes'] = $_POST['personnes'];
} else {
    if (empty($_POST['personnes'])) {
        $erreurs["personnes"] = "Le champ personnes ne doit pas être vide.";
    } else {
        $new_data['personnes'] = $donnees['personnes'];
    }
}

if (!empty($_POST['superficies']) && $_POST['superficies'] != $donnees['superficie']) {
    $new_data['superficies'] = $_POST['superficies'];
} else {
    if (empty($_POST['superficies'])) {
        $erreurs["superficies"] = "Le champ superficies ne doit pas être vide.";
    } else {
        $new_data['superficies'] = $donnees['superficie'];
    }
}

if (!empty($_POST['pu']) && $_POST['pu'] != $donnees['montant']) {
    $new_data['pu'] = $_POST['pu'];
} else {
    if (empty($_POST['pu'])) {
        $erreurs["pu"] = "Le champ pu ne doit pas être vide.";
    } else {
        $new_data['pu'] = $donnees['pu'];
    }
}

$_SESSION['donnees-type-chambre-modifier'] = $new_data;
$_SESSION['erreurs-type-chambre-modifier'] = $erreurs;


// die(var_dump($_SESSION['donnees-chambre-modifier']));

if (empty($erreurs)) {

    if (!empty($params[3])) {

        $id = $params[3];

        $miseajour = modifier_type_chambre($id, $new_data["type_chambre"], $new_data["details"], $new_data["personnes"], $new_data["superficies"],$new_data["pu"]);

        if ($miseajour) {
            $message_success_global = "Le type de chambre a été modifier avec succès !";
        } else {
            // La mise à jour du statut a échoué.
            $message_erreur_global =  "Oups ! Une erreur s'est produite lors de la modification du type de chambre. Veuillez réessayez.";
        }
    } else {
        // Aucune chambre disponible de type "Doubles"
        $message_erreur_global = "Désolé, il n'y a pas de type de chambre disponible pour le moment.";
    }

}


$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'administrateur/chambres/modifier-type-chambre/' . $params[3]);
