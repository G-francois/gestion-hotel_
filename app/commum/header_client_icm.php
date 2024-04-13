<?php

if (check_if_user_connected_client()) {
    header('location: ' . PATH_PROJECT . 'client/dashboard/index');
    exit;
}

// Inclure la partie du header spécifique à include_icm_header.php
$erreurs = [];
$donnees = [];

if (isset($_SESSION['inscription-erreurs']) && !empty($_SESSION['inscription-erreurs'])) {
    $erreurs = $_SESSION['inscription-erreurs'];
}

if (isset($_SESSION['connexion-erreurs']) && !empty($_SESSION['connexion-erreurs'])) {
    $erreurs = $_SESSION['connexion-erreurs'];
}

if (isset($_SESSION['donnees-utilisateur']) && !empty($_SESSION['donnees-utilisateur'])) {
    $donnees = $_SESSION['donnees-utilisateur'];
}

if (isset($_SESSION['verification-erreurs']) && !empty($_SESSION['verification-erreurs'])) {
    $erreurs = $_SESSION['verification-erreurs'];
}

if (isset($_COOKIE["donnees-utilisateur"]) && !empty($_COOKIE["donnees-utilisateur"])) {
    $data = json_decode($_COOKIE["donnees-utilisateur"]);
}

if (isset($_SESSION['enregistrer-erreurs']) && !empty($_SESSION['enregistrer-erreurs'])) {
    $erreurs = $_SESSION['enregistrer-erreurs'];
}

if (check_if_user_connected_client()) {
    header('location: ' . PATH_PROJECT . 'client/dashboard/index');
    exit;
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sous les Cocotiers - Login</title>
    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="icon" />
    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="apple-touch-icon" />
    <link href="<?= PATH_PROJECT ?>public/outils/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?= PATH_PROJECT ?>public/outils/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="<?= PATH_PROJECT ?>public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= PATH_PROJECT ?>public/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?= PATH_PROJECT ?>public/css/style.css" rel="stylesheet" />

</head>

<style>
    /* Style pour les liens de navigation actifs */
    .nav-link.active {
        color: #d9ba85;
        /* Couleur du texte */
        /* padding: 5px 10px; */
        /* Espacement interne pour une apparence du texte */
        /* font-size: larger; */
        /* Taille du texte */
    }
</style>

<style>
    #hero {
        width: 100%;
        height: 100vh;
        background: url("<?= PATH_PROJECT ?>public/images/hero-bg.jpg") top center;
        background-size: cover;
        position: relative;
        padding: 0;
    }

    #hero2 {
        width: 100%;
        height: 100vh;
        background: url("<?= PATH_PROJECT ?>public/images/water-165219_1280.jpg") top center;
        background-size: cover;
        position: relative;
        padding: 0;
    }

    #hero3 {
        width: 100%;
        height: 100vh;
        background: url("<?= PATH_PROJECT ?>public/images/BG-5.jpeg") top center;
        background-size: cover;
        position: relative;
        padding: 0;
    }

    .about {
        background: url("<?= PATH_PROJECT ?>public/images/about-bg.jpg") center center;
        background-size: cover;
        position: relative;
        padding: 80px 0;
    }

    .events {
        background: url("<?= PATH_PROJECT ?>public/images/about-bg.jpg") center center no-repeat;
        background-size: cover;
        position: relative;
    }
</style>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">
            <h1 class="logo me-auto me-lg-0">
                <a href="<?= PATH_PROJECT ?>client/site/home" style="font-size: 26px;">Sous les Cocotiers</a>
            </h1>
            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <!-- Lien pour la page "Acceuil" -->
                    <li>
                        <a class="nav-link scrollto <?= is_current_page('client/acceuil') ?>" href="<?= PATH_PROJECT ?>client/acceuil">Acceuil</a>
                    </li>

                    <!-- Lien pour la page "Chambres" -->
                    <li>
                        <a class="nav-link scrollto <?= is_current_page('client/chambres') ?>" href="<?= PATH_PROJECT ?>client/chambres">Chambres</a>
                    </li>

                    <!-- Lien pour la page "Restaurant" -->
                    <li>
                        <a class="nav-link scrollto <?= is_current_page('client/restaurant') ?>" href="<?= PATH_PROJECT ?>client/restaurant">Restaurant</a>
                    </li>

                    <!-- Lien pour la page "Galeries" -->
                    <li>
                        <a class="nav-link scrollto <?= is_current_page('client/galeries') ?>" href="<?= PATH_PROJECT ?>client/galeries">Galeries</a>
                    </li>


                    <!-- Lien pour la page "Contact" -->
                    <li>
                        <a class="nav-link scrollto <?= is_current_page('client/contact') ?>" href="<?= PATH_PROJECT ?>client/contact">Contact</a>
                    </li>

                    <?php if (!check_if_user_connected_client()) : ?>
                        <!-- Lien pour se connecter -->
                        <li>
                            <a class="nav-link scrollto <?= is_current_page('client/connexion') ?>" href="<?= PATH_PROJECT ?>client/connexion"><strong>SE CONNECTER</strong></a>
                        </li>
                    <?php endif; ?>
                </ul>
                <i class="bi bi-list mobile-nav-toggle" style="margin-left: 80px;"></i>
            </nav>
        </div>
    </header>
    <!-- End Header -->