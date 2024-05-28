<?php

$_SESSION['donnees-utilisateur-admin'] = [];
$_SESSION['enregistrer-erreurs-admin'] = [];

$donnees = [];

$erreurs = [];

if (!empty($_POST["mot-passe"])) {
    $password = $_POST["mot-passe"];
    $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    /* Dans ce code, j'ai ajouté une nouvelle validation pour le champ "mot de passe". J'ai défini le
	modèle /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/ qui vérifie que la chaîne $password respecte les
	critères suivants :

	Au moins 8 caractères
	Au moins une lettre majuscule
	Au moins une lettre minuscule
	Au moins un chiffre
	Au moins un caractère spécial parmi (@$!%*?&)
	Ensuite, j'ai utilisé la fonction preg_match() pour valider si le mot de passe correspond au modèle. Si c'est le cas, le mot de passe
	est ajouté aux données ($donnees["password"]). Sinon, un message d'erreur approprié est stocké dans le tableau $erreurs["password"].
	*/
    if (preg_match($pattern, $password)) {
        $donnees["mot-passe"] = $password;
    } else {
        $erreurs["mot-passe"] = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@$!%*?&).";
    }
} else {
    $erreurs["mot-passe"] = "Le champ mot de passe est requis. Veuillez le renseigner.";
}

if ((!empty($_POST["retapez-mot-passe"]) && $_POST["retapez-mot-passe"] != $_POST["mot-passe"])) {
    $erreurs["retapez-mot-passe"] = "Mot de passe erroné. Entrez le mot de passe du précédent champs";
}

if ((!empty($_POST["mot-passe"]) && $_POST["retapez-mot-passe"] == $_POST["mot-passe"])) {
    $donnees["mot-passe"] = trim(htmlentities($_POST['mot-passe']));
}

$_SESSION['donnees-utilisateur-admin'] = $donnees;


if (empty($erreurs)) {

    if (mise_a_jour_mot_passe($_SESSION['id_user'], $donnees["mot-passe"])) {
        session_destroy();
        header('location:' . PATH_PROJECT . 'administrateur/connexion/index');
    } else {
        $_SESSION['enregistrer-erreurs-admin'] = $erreurs;
        header('location: ' . PATH_PROJECT . 'administrateur/mot_de_passe/new_mot_passe');
    }
} else {
    $_SESSION['enregistrer-erreurs-admin'] = $erreurs;
    header('location: ' . PATH_PROJECT . 'administrateur/mot_de_passe/new_mot_passe');
}
