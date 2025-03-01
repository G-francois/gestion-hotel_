<?php

// Vérifier si le formulaire a été soumis avec un profil sélectionné
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Récupérer la sélection du profil
    $categorie_selectionne = !empty($_POST['categorie']) ? $_POST['categorie'] : null;

    // Stocker la sélection dans une session pour la récupérer lors du rechargement de la page
    $_SESSION['data']['categorie'] = $categorie_selectionne;

    // Rediriger vers la page principale après le traitement
    header('Location: ' . PATH_PROJECT . 'administrateur/repas/liste-repas');
    exit(); // Arrêter l'exécution après la redirection
}