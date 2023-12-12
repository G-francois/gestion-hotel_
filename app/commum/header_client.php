<?php

// LES SESSIONS UTILISEE LORS DE LA PAGE RESERVATION-SOLO DE L'ADMINISTRATEUR 
if (isset($_SESSION['donnees-reservation']) && !empty($_SESSION['donnees-reservation'])) {
    $donnees = $_SESSION['donnees-reservation'];
}

if (isset($_SESSION['erreurs-reservation']) && !empty($_SESSION['erreurs-reservation'])) {
    $erreurs = $_SESSION['erreurs-reservation'];
}

// LES SESSIONS UTILISEE LORS DE LA PAGE RESERVATION-SOLO DE L'ADMINISTRATEUR 
if (isset($_SESSION['donnees-commande']) && !empty($_SESSION['donnees-commande'])) {
    $donnees = $_SESSION['donnees-commande'];
}

if (isset($_SESSION['erreurs-commande']) && !empty($_SESSION['erreurs-commande'])) {
    $erreurs = $_SESSION['erreurs-commande'];
}

// Appeler la fonction pour mettre à jour les états
mettre_a_jour_etat_reservations_accompagnateurs();


?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Sous les Cocotiers - Index</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->

    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="icon" />

    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->

    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" /> -->

    <!-- outils CSS Files -->

    <link href="<?= PATH_PROJECT ?>public/outils/animate.css/animate.min.css" rel="stylesheet" />

    <link href="<?= PATH_PROJECT ?>public/outils/aos/aos.css" rel="stylesheet" />

    <link href="<?= PATH_PROJECT ?>public/vendor/bootstrap/css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">

    <link href="<?= PATH_PROJECT ?>public/outils/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <link href="<?= PATH_PROJECT ?>public/outils/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />

    <link href="<?= PATH_PROJECT ?>public/outils/boxicons/css/boxicons.min.css" rel="stylesheet" />

    <link href="<?= PATH_PROJECT ?>public/outils/glightbox/css/glightbox.min.css" rel="stylesheet" />

    <link href="<?= PATH_PROJECT ?>public/outils/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Template Main CSS File -->

    <link href="<?= PATH_PROJECT ?>public/css/style.css" rel="stylesheet" />

    <script src="<?= PATH_PROJECT ?>public/jquery/jquery.min.js"></script>

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



</head>

<body>
    <!-- ======= Header ======= -->

    <header id="header" class="fixed-top d-flex align-items-cente">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">
            <h1 class="logo me-auto me-lg-0">
                <a href="#">Sous les Cocotiers</a>
            </h1>

            <!-- Uncomment below if you prefer to use an image logo -->

            <!-- <a href="home.html" class="logo me-auto me-lg-0"><img src="publics/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li>
                        <a class="nav-link scrollto" href="<?= PATH_PROJECT ?>client/site/home">Acceuil</a>
                    </li>

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

                    <?php
                    if (!check_if_user_connected_client()) {
                    ?>

                        <li>
                            <a href="<?= PATH_PROJECT ?>client/connexion/index" class="nav-link scrollto" style="color: #d9ba85;"><strong>SE CONNECTER</strong></a>
                        </li>

                        <!-- <div id="notification-container" class="notification-container">
                            <div class="notification-content d-flex">
                                <img id="offre" src="<?= PATH_PROJECT ?>public/images/remise.jpg" alt="Remise" />
                                <span class="notification-message">Profitez d'un rabais de 5% sur toutes vos <br> réservations lorsque vous vous inscrivez <br> sur notre platforme dès maintnant.</span>

                            </div>
                        </div> -->

                        <!-- <div id="notification-container" class="notification-container">
                            <div class="notification-content d-flex">
                                <span class="notification-message">Profitez d'un un cocktail de bienvenue pour vous <br>
                                    laissez imprégner du lieu. <br>
                                    Après votre réservation vous avez accès à notre: <br>
                                    - Wifi haut débit disponible gratuitement dans tout l'hotel. <br>
                                    - Piscine intérieure équipée d'un jacuzzi et sauna. <br>
                                    - Espace Wellness en découvrant notre sauna et <br>
                                    nos prestations de massage. <br>
                                    - Services + qui vous oriente vers nos partenaires de location de vélos, <br>
                                    skis, heliski, et bien plus. <br>
                                </span>

                            </div>
                        </div> -->




                        <style>
                            .notification-container {
                                display: none;
                                position: fixed;
                                top: 70px;
                                right: 20px;
                                z-index: 9999;
                            }

                            .notification-content {
                                background-color: #f8f9fa;
                                border: 1px solid #ced4da;
                                padding: 10px;
                                border-radius: 4px;
                                display: flex;
                                align-items: center;
                                animation: zoomDownNotification 2.5s ease;
                            }

                            .notification-content img {
                                width: 46px;
                                height: 36px;
                            }

                            .notification-message {
                                margin-right: 10px;
                                color: black;
                            }

                            @keyframes zoomDownNotification {
                                0% {
                                    opacity: 0;
                                    transform: translateY(-50px);
                                }

                                100% {
                                    opacity: 1;
                                    transform: translateY(0);
                                }
                            }
                        </style>
                    <?php
                    }
                    ?>

                    <?php
                    if (check_if_user_connected_client()) {
                    ?>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <img src="<?= $_SESSION['utilisateur_connecter_client']['avatar'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_profil.jpg' : $_SESSION['utilisateur_connecter_client']['avatar'] ?>" style="margin-right: 12px; width: 2rem; height: 2rem;" alt="Profile" class="rounded-circle">

                                <h5 class="ml-2"><?= isset($_SESSION['utilisateur_connecter_client']) ?  $_SESSION['utilisateur_connecter_client']['nom_utilisateur'] : 'Pseudo' ?></h5>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-center shadow animated--grow-in text-center" style="min-width: 12rem;" aria-labelledby="userDropdown">
                                <div class="dropdown">
                                    <p style="color: black;"> <strong><?= isset($_SESSION['utilisateur_connecter_client']) ?  $_SESSION['utilisateur_connecter_client']['nom_utilisateur'] : 'Pseudo' ?></strong> <br>
                                        <span><?= isset($_SESSION['utilisateur_connecter_client']) ?  $_SESSION['utilisateur_connecter_client']['profil'] : 'Profil' ?></span>
                                </div>
                                <hr>
                                <a class="dropdown-item d-flex align-items-center mb-3" style="justify-content: unset; color: black; padding: 0px 0 0px 20px;" href="<?= PATH_PROJECT ?>client/profil/profile">
                                    <i class="bi bi-person" style="margin-right: 12px;"></i>
                                    <span>Mon Profile</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center mb-3" style="justify-content: unset; color: black; padding: 0px 0 0px 20px;" href="<?= PATH_PROJECT ?>client/dashboard/index">
                                    <i class="bi bi-gear" style="margin-right: 12px;"></i>
                                    <span>Tableau de bord</span>
                                </a>
                                <!-- <a class="dropdown-item d-flex align-items-center" style="justify-content: unset; color: black; padding: 0px 0 0px 20px;" href="<?= PATH_PROJECT ?>client/profil/notification">
                                    <i class="bi bi-bell" style="margin-right: 12px;"></i>
                                    <span>Notification(s)</span>
                                </a> -->
                                <hr>
                                <a class="dropdown-item d-flex align-items-center" style="justify-content: unset; color: black; padding: 0px 0 0px 20px;" href="<?= PATH_PROJECT ?>client/deconnexion/index">
                                    <i class="bi bi-box-arrow-right" style="margin-right: 12px;"></i>
                                    <span>Déconnexion</span>
                                </a>
                            </div>
                        </li>
                        <!-- End Profile Nav -->

                    <?php
                    }
                    ?>

                </ul>

                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <!-- .navbar -->


        </div>
    </header>
    <!-- End Header -->

