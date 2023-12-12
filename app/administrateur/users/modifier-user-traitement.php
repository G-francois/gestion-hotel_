
<?php

$message_erreur_global = "";
$message_success_global = "";
$donnees = recuperer_user_par_son_id($params[3]);
$new_donnees = [];
$erreurs = [];



if (isset($_POST['nom']) && !empty($_POST['nom']) && $_POST['nom'] != $donnees['nom']) {
    $new_data['nom'] = $_POST['nom'];
} else {
    if (empty($_POST['nom'])) {
        $erreurs["nom"] = "Le champ nom ne doit pas être vide.";
    } else {
        $new_data['nom'] = $donnees['nom'];
    }
}

if (isset($_POST['prenom']) && !empty($_POST['prenom']) && $_POST['prenom'] != $donnees['prenom']) {
    $new_data['prenom'] = $_POST['prenom'];
} else {
    if (empty($_POST['prenom'])) {
        $erreurs["prenom"] = "Le champ prenom ne doit pas être vide.";
    } else {
        $new_data['prenom'] = $donnees['prenom'];
    }
}

if (isset($_POST['sexe']) && !empty($_POST['sexe']) && $_POST['sexe'] != $donnees['sexe']) {
    $new_data['sexe'] = $_POST['sexe'];
} else {
    if (empty($_POST['sexe'])) {
        $erreurs["sexe"] = "Le champ sexe ne doit pas être vide.";
    } else {
        $new_data['sexe'] = $donnees['sexe'];
    }
}

if (isset($_POST['telephone']) && !empty($_POST['telephone']) && $_POST['telephone'] != $donnees['telephone']) {
    $telephone = trim(htmlentities($_POST['telephone']));
    $pattern = '/^\d{8,}$/';

    if (preg_match($pattern, $telephone)) {
        $new_data['telephone'] = $telephone;
    } else {
        $erreurs["telephone"] = "Le numéro de téléphone doit contenir entre 1 et 8 chiffres.";
    }
} else {
    $new_data['telephone'] = isset($donnees['telephone']) ? $donnees['telephone'] : '';

    if (empty($_POST['telephone'])) {
        $erreurs["telephone"] = "Le champ téléphone ne doit pas être vide.";
    }
}

die(var_dump($new_data['telephone']));

if (isset($_POST['email']) && !empty($_POST['email']) && $_POST['email'] != $donnees['email']) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if ($email !== false) {
        // L'e-mail est valide, vous pouvez l'utiliser
        $new_data['email'] = $email;
    } else {
        $erreurs["email"] = "L'adresse e-mail n'est pas valide.";
    }
} else {
    if (empty($_POST['email'])) {
        $erreurs["email"] = "Le champ email ne doit pas être vide.";
    } else {
        $new_data['email'] = $donnees['email'];
    }
}

if (isset($_POST[' nom_utilisateur']) && !empty($_POST[' nom_utilisateur']) && $_POST[' nom_utilisateur'] != $donnees[' nom_utilisateur']) {
    $new_data[' nom_utilisateur'] = $_POST[' nom_utilisateur'];
} else {
    if (empty($_POST[' nom_utilisateur'])) {
        $erreurs[" nom_utilisateur"] = "Le champ  nom utilisateur ne doit pas être vide.";
    } else {
        $new_data[' nom_utilisateur'] = $donnees[' nom_utilisateur'];
    }
}

if (isset($_POST['profil']) && !empty($_POST['profil']) && $_POST['profil'] != $donnees['profil']) {
    $new_data['profil'] = $_POST['profil'];
} else {
    if (empty($_POST['profil'])) {
        $erreurs["profil"] = "Le champ profil ne doit pas être vide.";
    } else {
        $new_data['profil'] = $donnees['profil'];
    }
}

$_SESSION['donnees-user-modifier'] = $new_data;
$_SESSION['erreurs-user-modifier'] = $erreurs;

// die(var_dump($_SESSION['donnees-user-modifier']));

if (empty($erreurs)) {

    if (!empty($params[3])) {

        $id_user = $params[3];

        $miseajour = modifier_user($id_user, $new_data["nom"], $new_data["prenom"], $new_data["sexe"], $new_data["telephone"], $new_data["email"], $new_data["nom_utilisateur"],$new_data["profil"]);

        if ($miseajour) {
            $message_success_global = "Les informations a été modifier avec succès !";
        } else {
            // La  mise à jour du statut a échoué
            $message_erreur_global =  "Oups ! Une erreur s'est produite lors de la modification. Veuiller réessayez.";
        }
    } else {
        // Aucune user
        $message_erreur_global = "Désolé, il n'y a pas d'utilisateur.";
    }

}


$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'administrateur/users/modifier-user/' . $params[3]);
