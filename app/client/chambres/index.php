<?php
include('./app/commum/header_client.php');

$data = [];

if (!empty($_SESSION['data'])) {
	$data = $_SESSION['data'];
}

$page = 1;

if (!empty($params[3])) {
	$page = $params[3];
}


$liste_chambres = liste_chambres($page);

if (!empty($data['type_chambre'])) {
	$liste_chambres = liste_chambres($page, $data['type_chambre']);
}


$types = liste_types();

?>

    <style>
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            text-decoration: none;
            padding: 5px 10px;
            /* border: 1px solid #ccc;
				border-radius: 3px; */
        }

        .zoom-effect-container {
            overflow: hidden;
        }

        .zoom-effect {
            transition: transform 0.5s;
        }

        .zoom-effect:hover {
            transform: scale(1.1);
        }

        #hero3 .btns {
            margin-top: 30px;
        }

        #hero3 .btn-book {
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: inline-block;
            padding: 12px 30px;
            border-radius: 50px;
            transition: 0.3s;
            line-height: 1;
            color: white;
            border: 2px solid #cda45e;
        }

        #hero3 .btn-book:hover {
            background: #cda45e;
            color: #fff;
        }

        #hero3 .btn-book {
            margin-left: 15px;
        }
    </style>


    <!-- ======= Hero Section ======= -->
    <section id="hero3" class="d-flex align-items-center">
        <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-8">
                    <h1>Espace<span> Chambre</span></h1>
                    <h2>
                        Réservez directement avec nous pour les meilleurs tarifs garantis.
                        <br/>
                        À l'hôtel Sous les Cocotiers, vous trouverez nos chambres qui offrent un maximum de confort :
                        grandes, meublées et
                        décorées dans un style minimaliste, qui permet une utilisation optimale de l'espace. Nous vous
                        invitons
                        à profiter des services que nous vous proposons : 32 logements au Sous les Cocotiers, des
                        chambres avec balcon ou terrasse,
                        avec de grands lits confortables, bureau, TV LCD, internet Wi-Fi, minibar et climatisation.
                    </h2>

                    <div class="btns">
                        <a href="<?= PATH_PROJECT . 'client/chambres/reservations' ?>"
                           class="btn-book animated fadeInUp scrollto">Faire une Réservation</a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <!-- chambre -->
    <section>
        <div class="container">
            <form action="<?= PATH_PROJECT ?>client/chambres/traitement-chambre" method="post" class="user" novalidate>
                <div class="row">
                    <div class="row justify-content-end">
                        <div class="col-3">
                            <div class="input-group mb-3">
                                <!-- <select class="form-select" aria-label="Sélectionner un type de chambre" name="type_chambre"> -->
                                <select class="form-select" aria-label="Sélectionner un type de chambre"
                                        name="type_chambre" id="type_chambre_select">

                                    <option value="">Tout Afficher</option>
									<?php
									if (!empty($types)) {
										foreach ($types as $type) {
											?>
                                            <option <?php echo !empty($data['type_chambre']) && $data['type_chambre'] == $type ? 'selected' : '' ?>
                                                    value="<?= $type ?>"><?= $type ?></option>
											<?php
										}
									}
									?>

                                </select>
                                <!-- <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="bi bi-search"></i></button> -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
						<?php
						// Affichez les chambres de la page actuelle
						if (!empty($liste_chambres)) {
							foreach ($liste_chambres as $chambre) {
								?>
                                    
                                <div class="col-md-4">

                                    <a href="#" data-bs-toggle="modal"
                                       data-bs-target="#detailsModal-<?php echo $chambre['num_chambre']; ?>"
                                       data-num-chambre="<?php echo $chambre['num_chambre']; ?>">
                                        <!-- <a href="<?= PATH_PROJECT . 'client/chambres/details_chambre/' . $chambre['num_chambre'] ?>"> -->
                                        <div class="card mb-4 shadow-sm">
                                            <div class="zoom-effect-container">
                                                <img class="bd-placeholder-img card-img-top zoom-effect" width="100%"
                                                     height="225"
                                                     src="<?= $chambre['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $chambre['photos'] ?>"
                                                     focusable="false" role="img" aria-label="Placeholder: Thumbnail" alt="">
                                            </div>
                                            <div class="card-body">
                                                <div style="display: flex; align-items: center; justify-content: space-between; font-family: Playfair Display, serif; font-size :larger; font-weight: 600;">
                                                    <p class="card-text" style="color:black; margin-bottom: 0;">
                                                        Chambre <?php echo $chambre['num_chambre']; ?> de
                                                        type <?php echo $chambre['lib_typ']; ?> </p>
                                                    <!-- <a href="<?= PATH_PROJECT . 'client/chambres/details_chambre/' . $chambre['num_chambre'] ?>">Détails</a> -->

                                                    <!-- Button Détails modal -->
                                                    <p style="margin-bottom: 0;" type="button"
                                                       class="btn btn-primary" data-bs-toggle="modal"
                                                       data-bs-target="#detailsModal-<?php echo $chambre['num_chambre']; ?>"
                                                       data-num-chambre="<?php echo $chambre['num_chambre']; ?>">
                                                        Détails
                                                    </p>


                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Modal  Détails-->
                                <div class="modal fade" id="detailsModal-<?php echo $chambre['num_chambre']; ?>"
                                     tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
                                     style="font-family: Open Sans , sans-serif;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" style="color: black;">
                                            <div class="modal-header">

                                                <h3 class="card-title">
                                                    Détails de la chambre <?php echo $chambre['num_chambre']; ?>
                                                    : <?php echo $chambre['lib_typ']; ?>
                                                </h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="card-text">
													<?php echo $chambre['details']; ?>
                                                </p>
                                                <div>
                                                    <div style="display: flex">
                                                        <p>
                                                            <i class="fas fa-user-circle"></i> <?php echo $chambre['personnes']; ?>
                                                            VOYAGEURS
                                                        </p>
                                                        <p style="margin-left: 2rem">
                                                            <i class="fas fa-vector-square"></i> <?php echo $chambre['superficies']; ?>
                                                        </p>
                                                        <p style="margin-left: 2rem">
                                                            <i class="bi bi-house"></i> <?php echo $chambre['pu']; ?>
                                                            F/Nuit
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row d-flex">
                                                    <div class="col-md-6">
                                                        <a title="Cocktail De Bienvenue"
                                                           class="nd_booking_tooltip_jquery nd_booking_float_left"><img
                                                                    alt="Cocktail De Bienvenue"
                                                                    class="nd_booking_margin_right_15 nd_booking_float_left"
                                                                    width="23" height="23"
                                                                    src="<?= PATH_PROJECT ?>public/images/Icons/icon-13.png"/></a>
                                                        <a title="Salle de bains privée"
                                                           class="nd_booking_tooltip_jquery nd_booking_float_left"><img
                                                                    alt="Salle de bains privée"
                                                                    class="nd_booking_margin_right_15 nd_booking_float_left"
                                                                    width="23" height="23"
                                                                    src="<?= PATH_PROJECT ?>public/images/Icons/icon-10.png"/></a>
                                                        <a title="satellite-tv"
                                                           class="nd_booking_tooltip_jquery nd_booking_float_left"><img
                                                                    alt="satellite-tv"
                                                                    class="nd_booking_margin_right_15 nd_booking_float_left"
                                                                    width="23" height="23"
                                                                    src="<?= PATH_PROJECT ?>public/images/Icons/icon-18.png"/></a>
                                                        <a title="Blanchisserie"
                                                           class="nd_booking_tooltip_jquery nd_booking_float_left"><img
                                                                    alt="Blanchisserie"
                                                                    class="nd_booking_margin_right_15 nd_booking_float_left"
                                                                    width="23" height="23"
                                                                    src="<?= PATH_PROJECT ?>public/images/Icons/icon-15.png"/></a>
                                                        <a title="Wifi"
                                                           class="nd_booking_tooltip_jquery nd_booking_float_left"><img
                                                                    alt="Wifi"
                                                                    class="nd_booking_margin_right_15 nd_booking_float_left"
                                                                    width="23" height="23"
                                                                    src="<?= PATH_PROJECT ?>public/images/Icons/icon-12-1.png"/></a>
                                                    </div>

                                                    <div class="col-md-6">
														<?php
														if (!check_if_user_connected_client()) {
															?>
                                                            <div class="mt-4" style="text-align: center;">
                                                                <a href="<?= PATH_PROJECT ?>client/connexion"
                                                                   class="btn btn-primary">Réserver maintenant</a>
                                                            </div>
															<?php
														}
														?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<?php
							}
							?>


							<?php
						} else {
							?>
                            <!-- Affiche un message d'erreur si la chambre n'existe pas -->
                            <div>
                                La page chambre que vous souhaitez voir n'existe pas.
                                <a class="" href="<?= PATH_PROJECT ?>client/chambres" style="color: #cda45e;">Retour
                                    vers la liste des chambres</a>
                            </div>
							<?php
						}
						?>
                    </div>

                    <!-- Affiche le bouton de réservation uniquement sur la dernière page -->
					<?php if (!empty($liste_chambres) && count($liste_chambres) < 9) : ?>
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <a class="btn btn-primary" href="<?= PATH_PROJECT . 'client/chambres/reservations' ?>">
                                    <!-- Afficher le bouton de réservation ici -->
                                    Faire une Réservation
                                </a>
                            </div>
                        </div>
					<?php endif; ?>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
							<?php if ($page > 1) : ?>
                                <li class="page-item"><a class="page-link"
                                                         href="<?= PATH_PROJECT . 'client/chambres/index/' ?><?= $page - 1 ?>">Précédent</a>
                                </li>
							<?php endif; ?>
                            <li class="page-item active"><a class="page-link" href="#"><?= $page ?></a></li>
							<?php if (!empty($liste_chambres) && count($liste_chambres) == 9) : ?>
                                <li class="page-item"><a class="page-link"
                                                         href="<?= PATH_PROJECT . 'client/chambres/index/' ?><?= $page + 1 ?>">Suivant</a>
                                </li>
							<?php endif; ?>
                        </ul>
                    </nav>

                </div>
            </form>
        </div>
    </section>

    <script>
        document.getElementById('type_chambre_select').addEventListener('change', function () {
            this.form.submit();
        });
    </script>

<?php
include('./app/commum/footer_client.php');

//unset($_SESSION['data'])
?>