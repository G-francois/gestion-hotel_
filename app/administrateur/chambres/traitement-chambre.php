<?php

// Vérifier si le formulaire a été soumis avec un profil sélectionné
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Récupérer la sélection du profil
    $profil_selectionne = !empty($_POST['type_chambre']) ? $_POST['type_chambre'] : null;

    // Stocker la sélection dans une session pour la récupérer lors du rechargement de la page
    $_SESSION['data']['type_chambre'] = $profil_selectionne;

    // Rediriger vers la page principale après le traitement
    header('Location: ' . PATH_PROJECT . 'administrateur/chambres/liste-chambres');
    exit(); // Arrêter l'exécution après la redirection
}