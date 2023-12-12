<?php
$repasId = $params[3];

// Appeler la fonction de suppression de repas
if (supprimer_repas($repasId)) {
    $message_success_global = "Le repas a été supprimé avec succès !";
} else {
    $message_erreur_global = "Oups ! Une erreur s'est produite lors de la suppression du repas.";
}

$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('Location: ' . PATH_PROJECT . 'administrateur/repas/liste-repas');
