<?php
$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];

if (!empty($_POST["nom"])) {
    $nom = htmlentities($_POST["nom"]);
    $pattern = '/^[A-Z]+$/';
    /*Dans ce code, j'ai ajouté une nouvelle validation pour le champ "nom". J'ai défini le modèle /^[A-Z]+$/
	 qui vérifie que la chaîne $nom contient uniquement des lettres majuscules. Ensuite, j'ai utilisé la fonction
	 preg_match() pour valider si le nom correspond au modèle. Si c'est le cas, le nom est ajouté aux données
	 ($donnees["nom"]). Sinon, un message d'erreur approprié est stocké dans le tableau $erreurs["nom"].
	*/
    if (preg_match($pattern, $nom)) {
        $donnees["nom"] = $nom;
    } else {
        $donnees["nom"] = strtoupper($nom);
    }
} else {
    $erreurs["nom"] = "Le champ nom est requis. Veuillez le renseigner.";
}

if (!empty($_POST["prenom"])) {
    $donnees["prenom"] = $_POST["prenom"];
} else {
    $erreurs["prenom"] = "Le champs prénom est requis. Veuillez le renseigné.";
}

if (!empty($_POST["sexe"])) {
    $donnees["sexe"] = $_POST["sexe"];
} else {
    $erreurs["sexe"] = "Le champs sexe est requis. Veuillez le renseigné.";
}

if (!empty($_POST["profil"])) {
    $donnees["profil"] = $_POST["profil"];
} else {
    $erreurs["profil"] = "Le champs profile est requis. Veuillez le renseigné.";
}

if (!empty($_POST["telephone"])) {
    $telephone = trim(htmlentities($_POST["telephone"]));
    $pattern = '/^\d{8,}$/';

    if (preg_match($pattern, $telephone)) {
        $donnees["telephone"] = $telephone;
    } else {
        $erreurs["telephone"] = "Le numéro de téléphone doit contenir entre 1 et 8 chiffres.";
    }
} else {
    $erreurs["telephone"] = "Le champ numéro de téléphone est requis. Veuillez le renseigner.";
}


if (!empty($_POST["email"])) {
    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $donnees["email"] = trim(htmlentities($_POST["email"]));
    } else {
        $erreurs["email"] = "Le champs email doit être une adresse mail valide. Veuillez le renseigner.";
    }
} else {
    $erreurs["email"] = "Le champs email est requis. Veuillez le renseigner.";
}

if (!empty($_POST["nom-utilisateur"])) {
    $donnees["nom-utilisateur"] = $_POST["nom-utilisateur"];
} else {
    $erreurs["nom-utilisateur"] = "Le champs nom-utilisateur est requis. Veuillez le renseigner.";
}

// Validation du champ "mot-passe" et "retapez-mot-passe"
if (isset($_POST["mot-passe"])) {
	$password = trim($_POST["mot-passe"]);
	$retapezMotPasse = trim($_POST["retapez-mot-passe"]);

	if (empty($password)) {
		$erreurs["mot-passe"] = "Le champ du mot de passe est vide. Veuillez le renseigner.";
	} elseif (strlen($password) < 8) {
		$erreurs["mot-passe"] = "Le champ doit contenir au moins 8 caractères. Les espaces ne sont pas pris en compte.";
	} elseif (empty($retapezMotPasse)) {
		$erreurs["retapez-mot-passe"] = "Entrez votre mot de passe à nouveau.";
	} elseif ($password != $retapezMotPasse) {
		$erreurs["retapez-mot-passe"] = "Mot de passe erroné. Entrez le mot de passe du champ précédent.";
	} else {
		$donnees["mot-passe"] = htmlentities($password);
	}
}




// if (check_email_exist_in_db($_POST["email"])) {
//     $erreurs["email"] = "Cette adresse mail est déjà utilisée. Veuillez-le changez.";
// }

if (check_email_and_profile_in_db($_POST["email"])) {
    $erreurs["email"] = "Cette adresse mail n'est pas autorisée car il est déjà utiliser par un autre profil 'client'.";
} 

if (check_email_and_profile_admin_in_db($_POST["email"])) {
    $erreurs["email"] = "Cette adresse mail n'est pas autorisée car il est déjà utiliser par un autre profil 'ADMINISTRATEUR'.";
} 

if (check_user_name_exist_in_db($_POST["nom-utilisateur"])) {
    $erreurs["nom-utilisateur"] = "Ce nom d'utilisateur est déjà utilisé. Veuillez le changez.";
}

if (check_telephone_exist_in_db($_POST["telephone"])) {
    $erreurs["telephone"] = "Ce numéro de téléphone est déjà utilisé. Veuillez le changez.";
}



if (empty($erreurs)) {

	$resultat = enregistrer_utilisateur_admin($donnees["nom"], $donnees["prenom"], $donnees["sexe"], $donnees["telephone"], $donnees["email"], $donnees["nom-utilisateur"], $donnees["mot-passe"], $donnees["profil"]);

	if ($resultat) {

        $message_success_global = "Utilisateur ajouté avec succès.";

    } else {

        $message_erreur_global = "Oups ! Une erreur s'est produite lors de l'enregistrement de l'utilisateur.";

    }
}

$_SESSION['donnees-utilisateur'] = $donnees;
$_SESSION['erreurs-utilisateur'] = $erreurs;
$_SESSION['ajout-message-success-global'] = $message_success_global;
$_SESSION['ajout-message-erreur-global'] = $message_erreur_global;
header('location: ' . PATH_PROJECT . 'administrateur/users');
