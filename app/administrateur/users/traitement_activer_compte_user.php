<?php

// die(var_dump($_POST));

$utilisateurId = $_POST['utilisateur_id'];
$message_erreur_global = "";
$message_success_global = "";
// Appeler la fonction d'activation de l'utilisateur
 if (activer_utilisateur($utilisateurId)){
    $message_success_global = "Le compte de l'utilisateur est activer avec succès !";
 }else{
    $message_erreur_global = "Oups ! Une erreur s'est produite lors de l'activation du compte de l'utilisateur.";
 }

 $_SESSION['message-erreur-global'] = $message_erreur_global;
 $_SESSION['message-success-global'] = $message_success_global;
header('Location: ' . PATH_PROJECT . 'administrateur/users/liste-users');




