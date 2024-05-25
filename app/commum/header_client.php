<?php

// Inclure la partie du header spécifique à index_v.php
$erreurs = [];

// LES SESSIONS UTILISEE LORS DE LA PAGE RESERVATION DU CLIENT & DE L'ADMINISTRATEUR 
if (!empty($_SESSION['donnees-reservation'])) {
	$donnees = $_SESSION['donnees-reservation'];
}

if (!empty($_SESSION['erreurs-reservation'])) {
	$erreurs = $_SESSION['erreurs-reservation'];
}

// LES SESSIONS UTILISEE LORS DE LA PAGE COMMANDE DU CLIENT & DE L'ADMINISTRATEUR 
if (!empty($_SESSION['donnees-commande'])) {
	$donnees = $_SESSION['donnees-commande'];
}

if (!empty($_SESSION['erreurs-commande'])) {
	$erreurs = $_SESSION['erreurs-commande'];
}

// LES SESSIONS UTILISEE LORS DE LA PAGE CONTACT DU CLIENT & DE L'ADMINISTRATEUR 
if (!empty($_SESSION['donnees-contact'])) {
	$donnees = $_SESSION['donnees-contact'];
}

if (!empty($_SESSION['erreurs-contact'])) {
	$erreurs = $_SESSION['erreurs-contact'];
}

// LES SESSIONS UTILISEE LORS DE LA PAGE PROFIL DU CLIENT & DE L'ADMINISTRATEUR
if (!empty($_SESSION['changement-erreurs'])) {
	$erreurs = $_SESSION['changement-erreurs'];
}

if (!empty($_SESSION['sauvegarder-erreurs'])) {
	$erreurs = $_SESSION['sauvegarder-erreurs'];
}

if (!empty($_SESSION['suppression-erreurs'])) {
	$erreurs = $_SESSION['suppression-erreurs'];
}

if (!empty($_SESSION['suppression-photo-erreurs'])) {
	$erreurs = $_SESSION['suppression-photo-erreurs'];
}

if (!empty($_SESSION['desactivation-erreurs'])) {
	$erreurs = $_SESSION['desactivation-erreurs'];
}

if (!empty($_SESSION['photo-erreurs'])) {
	$erreurs = $_SESSION['photo-erreurs'];
}

if (!empty($_SESSION['erreurs'])) {
	$erreurs = $_SESSION['erreurs'];
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sous les Cocotiers - Index</title>
    <meta content="" name="description"/>
    <meta content="" name="keywords"/>
    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="icon"/>
    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="apple-touch-icon"/>
    <link href="<?= PATH_PROJECT ?>public/outils/animate.css/animate.min.css" rel="stylesheet"/>
    <link href="<?= PATH_PROJECT ?>public/outils/aos/aos.css" rel="stylesheet"/>
    <link href="<?= PATH_PROJECT ?>public/vendor/bootstrap/css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <link href="<?= PATH_PROJECT ?>public/outils/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?= PATH_PROJECT ?>public/outils/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"/>
    <link href="<?= PATH_PROJECT ?>public/outils/boxicons/css/boxicons.min.css" rel="stylesheet"/>
    <link href="<?= PATH_PROJECT ?>public/outils/glightbox/css/glightbox.min.css" rel="stylesheet"/>
    <link href="<?= PATH_PROJECT ?>public/outils/swiper/swiper-bundle.min.css" rel="stylesheet"/>
    <link href="<?= PATH_PROJECT ?>public/css/style.css" rel="stylesheet"/>


    <!-- Custom styles for this page -->
    <link href="<?= PATH_PROJECT ?>public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="<?= PATH_PROJECT ?>public/jquery/jquery.min.js"></script>
    <script src="<?= PATH_PROJECT ?>public/js/ajax.js"></script>

    <link href="<?= PATH_PROJECT ?>public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet"/>


    <style>
        .hr {
            margin: 0 0;
            color: inherit;
            border: 0;
            border-top: 1px solid;
            opacity: .25;
        }

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


</head>

<body>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-cente">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-lg-between">
        <h1 class="logo me-auto me-lg-0">
            <a href="#">Sous les Cocotiers</a>
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

				<?php
				if (!check_if_user_connected_client()) {
					?>
                    <!-- Lien pour se connecter -->
                    <li>
                        <a class="nav-link scrollto <?= is_current_page('client/connexion') ?>"
                           href="<?= PATH_PROJECT ?>client/connexion"><strong>Se connecter</strong></a>
                    </li>
					<?php
				}
				?>

				<?php
				if (check_if_user_connected_client()) {
					?>

                    <div class="col-md-5">
                        <nav class="navbar navbar-expand-sm navbar-dark" aria-label="Third navbar example">
                            <div class="container-fluid">
                                <div class="collapse navbar-collapse" id="navbarsExample03">
                                    <ul class="navbar-nav me-auto mb-2 mb-sm-0">

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown" aria-expanded="false">
                                                <!-- Image de profil de l'utilisateur -->
                                                <img src="<?= $_SESSION['utilisateur_connecter_client']['avatar'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_profil.jpg' : $_SESSION['utilisateur_connecter_client']['avatar'] ?>"
                                                     style="margin-right: 12px; width: 2rem; height: 2rem;" alt="Profile"
                                                     class="rounded-circle">

                                                <!-- Nom de l'utilisateur -->
                                                <h5 class="ml-2"><?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['nom_utilisateur'] : 'Pseudo' ?></h5>

                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdown03">
                                                <li>
                                                    <a class="dropdown-item" href="<?= PATH_PROJECT ?>client/profil" style="justify-content: unset;">
                                                        <i class="bi bi-person" style="margin-right: 12px;"></i>
                                                        Mon Profile
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="<?= PATH_PROJECT ?>client/liste_des_reservations" style="justify-content: unset;">
                                                        <i class="bi bi-card-checklist" style="margin-right: 12px;"></i>
                                                        Liste des reservations
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="<?= PATH_PROJECT ?>client/liste_des_commandes" style="justify-content: unset;">
                                                        <i class="bi bi-card-checklist" style="margin-right: 12px;"></i>
                                                        Liste des commandes
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="<?= PATH_PROJECT ?>client/liste_des_messages" style="justify-content: unset;">
                                                        <i class="bi bi-mailbox" style="margin-right: 12px;"></i>
                                                        Liste des messages
                                                    </a>
                                                </li>

                                                <hr>
                                                <li>
                                                    <a class="dropdown-item" href="<?= PATH_PROJECT ?>client/deconnexion" style="justify-content: unset;">
                                                        <i class="bi bi-box-arrow-right" style="margin-right: 12px;"></i>
                                                        Déconnexion
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </nav>
                    </div>




                    <!-- Lien pour le profil de l'utilisateur connecté -->

                    <!-- Fin du profil de l'utilisateur connecté -->

					<?php
				}
				?>

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
    </div>
</header>
<!-- End Header -->