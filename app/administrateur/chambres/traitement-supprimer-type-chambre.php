<?php
$TypechambreId = $params[3];
$message_erreur_global ="";
$message_success_global = "";


// Appeler la fonction de suppression de chambre
if (supprimer_type_chambre($TypechambreId)) {
    $message_success_global = "Le type de chambre a été supprimé avec succès !";
} else {
    $message_erreur_global = "Oups ! Une erreur s'est produite lors de la suppression de la chambre.";
}

$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('Location: ' . PATH_PROJECT . 'administrateur/chambres/liste-type-chambre');
