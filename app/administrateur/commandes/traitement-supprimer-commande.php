<?php
$commandeId = $params[3];

// Appeler la fonction de suppression de repas
if (supprimer_commande_administrateur($commandeId)) {
    $message_success_global = "La commande a été supprimé avec succès !";
} else {
    $message_erreur_global = "Oups ! Une erreur s'est produite lors de la suppression de la commande.";
}

$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('Location: ' . PATH_PROJECT . 'administrateur/commandes/liste-commandes');
