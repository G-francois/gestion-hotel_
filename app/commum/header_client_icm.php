<?php

if (check_if_user_connected_client()) {
	header('location: ' . PATH_PROJECT . 'client/dashboard/index');
	exit;
}

// Inclure la partie du header spécifique à include_icm_header.php
$erreurs = [];
$donnees = [];

if (!empty($_SESSION['inscription-erreurs'])) {
	$erreurs = $_SESSION['inscription-erreurs'];
}

if (!empty($_SESSION['connexion-erreurs'])) {
	$erreurs = $_SESSION['connexion-erreurs'];
}

if (!empty($_SESSION['donnees-utilisateur'])) {
	$donnees = $_SESSION['donnees-utilisateur'];
}

if (!empty($_SESSION['verification-erreurs'])) {
	$erreurs = $_SESSION['verification-erreurs'];
}

if (!empty($_COOKIE["donnees-utilisateur"])) {
	$data = json_decode($_COOKIE["donnees-utilisateur"]);
}

if (!empty($_SESSION['enregistrer-erreurs'])) {
	$erreurs = $_SESSION['enregistrer-erreurs'];
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
    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="icon"/>
    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="apple-touch-icon"/>
    <link href="<?= PATH_PROJECT ?>public/outils/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"/>
    <link href="<?= PATH_PROJECT ?>public/outils/boxicons/css/boxicons.min.css" rel="stylesheet"/>
    <link href="<?= PATH_PROJECT ?>public/outils/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">
    <link href="<?= PATH_PROJECT ?>public/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?= PATH_PROJECT ?>public/css/style.css" rel="stylesheet"/>

</head>

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
                    <a class="nav-link scrollto <?= is_current_page('client/acceuil') ?>"
                       href="<?= PATH_PROJECT ?>client/acceuil">Acceuil</a>
                </li>

                <!-- Lien pour la page "Chambres" -->
                <li>
                    <a class="nav-link scrollto <?= is_current_page('client/chambres') ?>"
                       href="<?= PATH_PROJECT ?>client/chambres">Chambres</a>
                </li>

                <!-- Lien pour la page "Restaurant" -->
                <li>
                    <a class="nav-link scrollto <?= is_current_page('client/restaurant') ?>"
                       href="<?= PATH_PROJECT ?>client/restaurant">Restaurant</a>
                </li>

                <!-- Lien pour la page "Galeries" -->
                <li>
                    <a class="nav-link scrollto <?= is_current_page('client/galeries') ?>"
                       href="<?= PATH_PROJECT ?>client/galeries">Galeries</a>
                </li>


                <!-- Lien pour la page "Contact" -->
                <li>
                    <a class="nav-link scrollto <?= is_current_page('client/contact') ?>"
                       href="<?= PATH_PROJECT ?>client/contact">Contact</a>
                </li>

				<?php if (!check_if_user_connected_client()) : ?>
                    <!-- Lien pour se connecter -->
                    <li>
                        <a class="nav-link scrollto <?= is_current_page('client/connexion') ?>"
                           href="<?= PATH_PROJECT ?>client/connexion"><strong>Se connecter</strong></a>
                    </li>
				<?php endif; ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle" style="margin-left: 400px;"></i>
        </nav>
    </div>
</header>
<!-- End Header -->