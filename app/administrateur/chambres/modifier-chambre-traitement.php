
<?php

$message_erreur_global = "";
$message_success_global = "";
$donnees =  recuperer_chambre_par_son_num_chambre($params[3]);
$new_donnees = [];
$erreurs = [];

if (isset($_POST['lib_typ']) && !empty($_POST['lib_typ']) && $_POST['lib_typ'] != $donnees['lib_typ']) {
    $new_data['lib_typ'] = $_POST['lib_typ'];
} else {
    if (empty($_POST['lib_typ'])) {
        $erreurs["lib_typ"] = "Le champ libelle type ne doit pas être vide.";
    } else {
        $new_data['lib_typ'] = $donnees['lib_typ'];
    }
}

if (isset($_POST['cod_typ']) && !empty($_POST['cod_typ']) && $_POST['cod_typ'] != $donnees['cod_typ']) {
    $new_data['cod_typ'] = $_POST['cod_typ'];
} else {
    if (empty($_POST['cod_typ'])) {
        $erreurs["cod_typ"] = "Le champ code type ne doit pas être vide.";
    } else {
        $new_data['cod_typ'] = $donnees['cod_typ'];
    }
}

if (isset($_POST['details']) && !empty($_POST['details']) && $_POST['details'] != $donnees['details']) {
    $new_data['details'] = $_POST['details'];
} else {
    if (empty($_POST['details'])) {
        $erreurs["details"] = "Le champ details ne doit pas être vide.";
    } else {
        $new_data['details'] = $donnees['details'];
    }
}

if (isset($_POST['personnes']) && !empty($_POST['personnes']) && $_POST['personnes'] != $donnees['personnes']) {
    $new_data['personnes'] = $_POST['personnes'];
} else {
    if (empty($_POST['personnes'])) {
        $erreurs["personnes"] = "Le champ personnes ne doit pas être vide.";
    } else {
        $new_data['personnes'] = $donnees['personnes'];
    }
}

if (isset($_POST['superficies']) && !empty($_POST['superficies']) && $_POST['superficies'] != $donnees['superficies']) {
    $new_data['superficies'] = $_POST['superficies'];
} else {
    if (empty($_POST['superficies'])) {
        $erreurs["superficies"] = "Le champ superficies ne doit pas être vide.";
    } else {
        $new_data['superficies'] = $donnees['superficies'];
    }
}

if (isset($_POST['pu']) && !empty($_POST['pu']) && $_POST['pu'] != $donnees['pu']) {
    $new_data['pu'] = $_POST['pu'];
} else {
    if (empty($_POST['pu'])) {
        $erreurs["pu"] = "Le champ pu ne doit pas être vide.";
    } else {
        $new_data['pu'] = $donnees['pu'];
    }
}

$_SESSION['donnees-chambre-modifier'] = $new_data;
$_SESSION['erreurs-chambre-modifier'] = $erreurs;


// die(var_dump($_SESSION['donnees-chambre-modifier']));

if (empty($erreurs)) {

    if (!empty($params[3])) {

        $num_chambre = $params[3];

        $miseajour = modifier_chambre($num_chambre, $new_data["cod_typ"], $new_data["lib_typ"], $new_data["details"], $new_data["personnes"], $new_data["superficies"],$new_data["pu"]);

        if ($miseajour) {
            $message_success_global = "La chambre a été modifier avec succès !";
        } else {
            // La  mise à jour du statut a échoué
            $message_erreur_global =  "Oups ! Une erreur s'est produite lors de la modification de la chambre. Veuiller réessayez.";
        }
    } else {
        // Aucune chambre disponible de type "Doubles"
        $message_erreur_global = "Désolé, il n'y a pas de chambre disponible pour le moment.";
    }

}


$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'administrateur/chambres/modifier-chambre/' . $params[3]);
