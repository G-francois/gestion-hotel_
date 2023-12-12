<?php

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

    <!-- BOOTSTRAP ICONS CSS Files -->
	<link href="<?= PATH_PROJECT ?>public/outils/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"/>
	<!-- FONTAWESOME ICONS CSS Files -->
	<link href="<?= PATH_PROJECT ?>public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<!-- NUNITO GOOGLE FONTS	-->
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="<?= PATH_PROJECT ?>public/css/sb-admin-2.css" rel="stylesheet">
	<!-- Custom styles client for this template-->
	<link href="<?= PATH_PROJECT ?>public/css/style.css" rel="stylesheet"/>

</head>

<body>
    <!-- ======= Header ======= -->

    <header id="header" class="fixed-top d-flex align-items-center">


        <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between" style="justify-content: space-between;">
            <h1 class="logo me-auto me-lg-0">
                <a href="<?= PATH_PROJECT ?>client/site/home" style="font-size: 26px;">Sous les Cocotiers</a>
            </h1>

            <!-- Uncomment below if you prefer to use an image logo -->

            <!-- <a href="home.html" class="logo me-auto me-lg-0"><img src="publics/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="nav-link scrollto active" href="<?= PATH_PROJECT ?>client/site/home">Acceuil</a></li>

                    <li>
                        <a class="nav-link scrollto" href="<?= PATH_PROJECT ?>client/site/chambres">Chambres</a>
                    </li>

                    <li>
                        <a class="nav-link scrollto" href="<?= PATH_PROJECT ?>client/site/restaurant">Restaurant</a>
                    </li>

                    <li>
                        <a class="nav-link scrollto" href="<?= PATH_PROJECT ?>client/site/galeries">Galeries</a>
                    </li>

                    <li>
                        <a class="nav-link scrollto" href="<?= PATH_PROJECT ?>client/site/contact">Contact</a>
                    </li>

                    <li>
                        <a href="<?= PATH_PROJECT ?>client/connexion/index" class="nav-link scrollto" style="color: #d9ba85;"><strong>SE CONNECTER</strong></a>
                    </li>
                </ul>


                <i class="bi bi-list mobile-nav-toggle" style="margin-left: 80px;"></i>
            </nav>
            <!-- .navbar -->


        </div>
    </header>
    <!-- End Header -->