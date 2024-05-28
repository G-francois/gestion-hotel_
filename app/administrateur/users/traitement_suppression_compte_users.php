<?php

$utilisateurId = $_POST['utilisateur_id'];
$message_success_global ="";
$message_erreur_global ="";
// Appeler la fonction d'activation de l'utilisateur
 if (suppression_compte_utilisateur($utilisateurId)){
    $message_success_global = "Le compte de l'utilisateur a été supprimé avec succès !";
 }else{
    $message_erreur_global = "Oups ! Une erreur s'est produite lors de la suppression du compte de l'utilisateur.";
 }

 $_SESSION['message-erreur-global'] = $message_erreur_global;
 $_SESSION['message-success-global'] = $message_success_global;
header('Location: ' . PATH_PROJECT . 'administrateur/users/liste-users');
