<?php


// Vérifier si le formulaire a été soumis avec un profil sélectionné
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Récupérer la sélection du profil
    $profil_selectionne = !empty($_POST['profil']) ? $_POST['profil'] : null;

    // Stocker la sélection dans une session pour la récupérer lors du rechargement de la page
    $_SESSION['data']['profil'] = $profil_selectionne;

    // Rediriger vers la page principale après le traitement
    header('Location: ' . PATH_PROJECT . 'administrateur/users/liste-users');
    exit(); // Arrêter l'exécution après la redirection
}