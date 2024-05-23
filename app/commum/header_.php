<?php
if (isset($include_icm_header) && $include_icm_header) {

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

    <!-- <?php

	try {
		// Récupérez les numéros de chambre expirés (vous pouvez utiliser la fonction précédente)
		$reservations_expirees = recuperer_reservations_expirees();

		$numeros_chambre = array_column($reservations_expirees, 'num_chambre');
		// Mettez à jour est_actif dans la table chambre
		$resultat_mise_a_jour_chambre = mettre_a_jour_est_actif_chambre($numeros_chambre);

		$numReservations = array_column($reservations_expirees, 'num_res');
		// Mettez à jour est_actif dans la table reservations
		$resultat_mise_a_jour_reservations = mettre_a_jour_est_actif_reservations($numReservations);

		// Récupérez les ID des réservations à partir des numéros de réservation
		$idReservations = recuperer_id_reservations_par_num_res($numReservations);

		// Mettez à jour est_actif dans la table commande
		$resultat_mise_a_jour_commandes = mettre_a_jour_est_actif_commandes($idReservations);

		// Utilisez la fonction pour récupérer les numéros de commande
		$numeros_commande_a_metre_a_jour = recuperer_tous_num_cmd_par_num_res($idReservations);

		// Vérifiez si $numeros_commande_a_metre_a_jour est un tableau avant d'appeler la fonction
		if (is_array($numeros_commande_a_metre_a_jour) && !empty($numeros_commande_a_metre_a_jour)) {
			// Mettez à jour est_actif et est_supprimer dans la table commande_repas
			$resultat_mise_a_jour_commande_repas = mettre_a_jour_est_actif_commande_repas($numeros_commande_a_metre_a_jour);
		} else {
			// Ajoutez un message de débogage en cas d'erreur
			// echo "Aucun numéro de commande à mettre à jour.";
		}

		// Affichez un message de succès si toutes les mises à jour sont terminées avec succès
		echo "Toutes les mises à jour sont terminées avec succès.";
	} catch (Exception $e) {
		// En cas d'erreur, affichez un message d'erreur
		echo "Une erreur s'est produite : " . $e->getMessage();
	}

	?> -->


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
        <link href="<?= PATH_PROJECT ?>public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
              rel="stylesheet">
        <link href="<?= PATH_PROJECT ?>public/css/sb-admin-2.css" rel="stylesheet">
        <link href="<?= PATH_PROJECT ?>public/css/style.css" rel="stylesheet"/>

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
                <i class="bi bi-list mobile-nav-toggle" style="margin-left: 80px;"></i>
            </nav>
        </div>
    </header>
    <!-- End Header -->

	<?php

} elseif (isset($include_client_header) && $include_client_header) {
	// Inclure la partie du header spécifique à index_v.php
	$erreurs = [];

	// LES SESSIONS UTILISEE LORS DE LA PAGE RESERVATION DU CLIENT & DE L'ADMINISTRATEUR
	if (isset($_SESSION['donnees-reservation']) && !empty($_SESSION['donnees-reservation'])) {
		$donnees = $_SESSION['donnees-reservation'];
	}

	if (isset($_SESSION['erreurs-reservation']) && !empty($_SESSION['erreurs-reservation'])) {
		$erreurs = $_SESSION['erreurs-reservation'];
	}

	// LES SESSIONS UTILISEE LORS DE LA PAGE COMMANDE DU CLIENT & DE L'ADMINISTRATEUR
	if (isset($_SESSION['donnees-commande']) && !empty($_SESSION['donnees-commande'])) {
		$donnees = $_SESSION['donnees-commande'];
	}

	if (isset($_SESSION['erreurs-commande']) && !empty($_SESSION['erreurs-commande'])) {
		$erreurs = $_SESSION['erreurs-commande'];
	}

	// LES SESSIONS UTILISEE LORS DE LA PAGE CONTACT DU CLIENT & DE L'ADMINISTRATEUR
	if (isset($_SESSION['donnees-contact']) && !empty($_SESSION['donnees-contact'])) {
		$donnees = $_SESSION['donnees-contact'];
	}

	if (isset($_SESSION['erreurs-contact']) && !empty($_SESSION['erreurs-contact'])) {
		$erreurs = $_SESSION['erreurs-contact'];
	}

	// LES SESSIONS UTILISEE LORS DE LA PAGE PROFIL DU CLIENT & DE L'ADMINISTRATEUR
	if (isset($_SESSION['changement-erreurs']) && !empty($_SESSION['changement-erreurs'])) {
		$erreurs = $_SESSION['changement-erreurs'];
	}

	if (isset($_SESSION['sauvegarder-erreurs']) && !empty($_SESSION['sauvegarder-erreurs'])) {
		$erreurs = $_SESSION['sauvegarder-erreurs'];
	}

	if (isset($_SESSION['suppression-erreurs']) && !empty($_SESSION['suppression-erreurs'])) {
		$erreurs = $_SESSION['suppression-erreurs'];
	}

	if (isset($_SESSION['suppression-photo-erreurs']) && !empty($_SESSION['suppression-photo-erreurs'])) {
		$erreurs = $_SESSION['suppression-photo-erreurs'];
	}

	if (isset($_SESSION['desactivation-erreurs']) && !empty($_SESSION['desactivation-erreurs'])) {
		$erreurs = $_SESSION['desactivation-erreurs'];
	}

	if (isset($_SESSION['photo-erreurs']) && !empty($_SESSION['photo-erreurs'])) {
		$erreurs = $_SESSION['photo-erreurs'];
	}

	if (isset($_SESSION['erreurs']) && !empty($_SESSION['erreurs'])) {
		$erreurs = $_SESSION['erreurs'];
	}


	// Supposez que vous avez une liste de réservations avec leurs dates de fin_occ
	/* $reservations = [];

	foreach ($reservations as $reservation) {
		// Appelez la fonction pour chaque réservation avec sa date de fin_occ
		mettre_a_jour_etat_reservations_accompagnateurs($reservation['fin_occ']);
	} */


	//mettre_a_jour_etat_reservations_accompagnateurs();

	?>


    <!-- <?php

	try {
		// Récupérez les numéros de chambre expirés (vous pouvez utiliser la fonction précédente)
		$reservations_expirees = recuperer_reservations_expirees();

		$numeros_chambre = array_column($reservations_expirees, 'num_chambre');
		// Mettez à jour est_actif dans la table chambre
		$resultat_mise_a_jour_chambre = mettre_a_jour_est_actif_chambre($numeros_chambre);

		$numReservations = array_column($reservations_expirees, 'num_res');
		// Mettez à jour est_actif dans la table reservations
		$resultat_mise_a_jour_reservations = mettre_a_jour_est_actif_reservations($numReservations);

		// Récupérez les ID des réservations à partir des numéros de réservation
		$idReservations = recuperer_id_reservations_par_num_res($numReservations);

		// Mettez à jour est_actif dans la table commande
		$resultat_mise_a_jour_commandes = mettre_a_jour_est_actif_commandes($idReservations);

		// Utilisez la fonction pour récupérer les numéros de commande
		$numeros_commande_a_metre_a_jour = recuperer_tous_num_cmd_par_num_res($idReservations);

		// Vérifiez si $numeros_commande_a_metre_a_jour est un tableau avant d'appeler la fonction
		if (is_array($numeros_commande_a_metre_a_jour) && !empty($numeros_commande_a_metre_a_jour)) {
			// Mettez à jour est_actif et est_supprimer dans la table commande_repas
			$resultat_mise_a_jour_commande_repas = mettre_a_jour_est_actif_commande_repas($numeros_commande_a_metre_a_jour);
		} else {
			// Ajoutez un message de débogage en cas d'erreur
			// echo "Aucun numéro de commande à mettre à jour.";
		}

		// Affichez un message de succès si toutes les mises à jour sont terminées avec succès
		echo "Toutes les mises à jour sont terminées avec succès.";
	} catch (Exception $e) {
		// En cas d'erreur, affichez un message d'erreur
		echo "Une erreur s'est produite : " . $e->getMessage();
	}

	?> -->


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
        <link href="<?= PATH_PROJECT ?>public/vendor/bootstrap/css/bootstrap-grid.min.css" rel="stylesheet"
              type="text/css">
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
                margin: 0rem 0;
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

                    <!-- Lien pour le profil de l'utilisateur connecté -->
                    <li class="nav-item" style="width: auto;">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <!-- Image de profil de l'utilisateur -->
                            <img src="<?= $_SESSION['utilisateur_connecter_client']['avatar'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_profil.jpg' : $_SESSION['utilisateur_connecter_client']['avatar'] ?>"
                                 style="margin-right: 12px; width: 2rem; height: 2rem;" alt="Profile"
                                 class="rounded-circle">

                            <!-- Nom de l'utilisateur -->
                            <h5 class="ml-2"><?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['nom_utilisateur'] : 'Pseudo' ?></h5>
                        </a>
                        <!-- Contenu du dropdown pour l'utilisateur connecté -->
                        <div class="dropdown-menu dropdown-menu-center shadow animated--grow-in text-center"
                             style="min-width: 12rem; width: -webkit-fill-available;" aria-labelledby="userDropdown">

                            <a class="dropdown-item d-flex align-items-center mb-3"
                               href="<?= PATH_PROJECT ?>client/profil"
                               style="justify-content: unset; color: black; padding: 0px 0 0px 20px;">
                                <i class="bi bi-person" style="margin-right: 12px;"></i>
                                <span>Mon Profile</span>
                            </a>

                            <a class="dropdown-item d-flex align-items-center mb-3"
                               href="<?= PATH_PROJECT ?>client/liste_des_reservations"
                               style="justify-content: unset; color: black; padding: 0px 0 0px 20px;">
                                <i class="bi bi-card-checklist" style="margin-right: 12px;"></i>
                                <span>Liste des reservations</span>
                            </a>

                            <a class="dropdown-item d-flex align-items-center mb-3"
                               href="<?= PATH_PROJECT ?>client/liste_des_commandes"
                               style="justify-content: unset; color: black; padding: 0px 0 0px 20px;">
                                <i class="bi bi-card-list" style="margin-right: 12px;"></i>
                                <span>Liste des commandes</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center mb-3"
                               href="<?= PATH_PROJECT ?>client/liste_des_messages"
                               style="justify-content: unset; color: black; padding: 0px 0 0px 20px;">
                                <i class="bi bi-mailbox" style="margin-right: 12px;"></i>
                                <span>Liste des messages</span>
                            </a>

                            <hr>
                            <a class="dropdown-item d-flex align-items-center"
                               style="justify-content: unset; color: black; padding: 0px 0 0px 20px;"
                               href="<?= PATH_PROJECT ?>client/deconnexion">
                                <i class="bi bi-box-arrow-right" style="margin-right: 12px;"></i>
                                <span>Déconnexion</span>
                            </a>
                        </div>
                    </li>
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
	<?php
} else {
	// Inclure la partie commune du header
}
?>