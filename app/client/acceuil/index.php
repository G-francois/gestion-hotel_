<?php
include('./app/commum/header_client.php');
?>


    <!-- ======= Hero Section ======= -->
    <header id="headerwrap" class="backstretched no-overlay fullheight">
        <div class="container vertical-center">
            <div class="intro-text vertical-center text-left smoothie"
                 style="font-family: Playfair Display , sans-serif;">
                <div class="intro-heading h1 wow fadeIn heading-font" data-wow-delay="0.2s">
                    Bienvenue chez vous
                </div>

                <div class="intro-sub-heading wow fadeIn secondary-font h1" data-wow-delay="0.2s">
                    Nous sommes là pour vous offrir<span class="rotate">
                    un séjour d'affaire/loisir relaxant, un confort remarquable, des
                    salles de conférence, un espace Restaurant.</span>
                </div>

            </div>
        </div>
    </header>
    <!-- End Hero -->


    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Pourquoi nous</h2>

                <p>Pourquoi choisir notre Hôtel ?</p>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="box" data-aos="zoom-in" data-aos-delay="100">
                        <span>01</span>

                        <h4>LOCALISATION & CATHEGORIE</h4>

                        <p>
                            Nous sommes situé dans le quartier résidentiel de la ville (à
                            10 minutes du centre-ville) et faisons partie de la catégorie
                            des hôtels 3 étoiles plus.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 mt-4 mt-lg-0">
                    <div class="box" data-aos="zoom-in" data-aos-delay="100">
                        <span>02</span>

                        <h4>ACCUEIL & SERVICES</h4>

                        <p>
                            Nous vous offrons un accueil chaleureux tout en vous faisant déguster notre cocktail de
                            bienvenue dans un cadre spontieux.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 mt-4 mt-lg-0">
                    <div class="box" data-aos="zoom-in" data-aos-delay="200">
                        <span>03</span>

                        <h4>HÉBERGEMENTS & SECURITE</h4>

                        <p>
                            Réservez une chambre pour rester dans un environnement agréable et sécurisé.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 mt-4 mt-lg-0">
                    <div class="box" data-aos="zoom-in" data-aos-delay="300">
                        <span>04</span>

                        <h4>CONFORT & REPAS</h4>

                        <p>
                            Nos repas peuvent être pris au bord de la piscine intérieure et vos détentes sur notre
                            espace Wellness et Bibliothèque.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Why Us Section -->


    <!-- Section des différents types de chambres -->
    <section class="cc-chambre">
        <div class="py-2">
            <div class="container">
                <div class="row text-center">
                    <h1>À L'HÔTEL SOUS LES COCOTIERS</h1>

                    <p class="size-18 m-size-14">
                        Nous vous proposons une large gamme de services pour rendre votre
                        séjour d'affaires ou de loisirs aussi insouciant et aussi relaxant que
                        possible. Vous trouverez nos chambres qui offrent un maximum de confort : grandes, meublées et
                        décorées dans un style minimaliste, qui permet une utilisation optimale de l'espace.
                    </p>
                </div>

                <div class="row">
                    <section>
                        <div class="container">
                            <div class="row">
								<?php
								$liste_chambres = recuperer_liste_chambres_acceuil();

								if (!empty($liste_chambres)) {
									$total_chambres = count($liste_chambres);
									$chambres_par_ligne = 3;
									$chambres_par_groupe = $chambres_par_ligne * 2;

									for ($i = 0; $i < $total_chambres; $i += $chambres_par_groupe) {
										echo '<div class="row">';

										for ($j = $i; $j < $i + $chambres_par_groupe && $j < $total_chambres; $j++) {
											$chambre = $liste_chambres[$j];
											$photos = $chambre['photos'];
											$nomChambre = $chambre['lib_typ'];
											?>

                                            <div class="col-md-4">

                                                <a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#detailsModal-<?php echo $chambre['num_chambre']; ?>"
                                                   data-num-chambre="<?php echo $chambre['num_chambre']; ?>">
                                                    <!-- <a href="<?= PATH_PROJECT . 'client/chambres/details_chambre/' . $chambre['num_chambre'] ?>"> -->
                                                    <div class="card mb-4 shadow-sm">
                                                        <div class="zoom-effect-container">
                                                            <img class="bd-placeholder-img card-img-top zoom-effect"
                                                                 width="100%" height="225"
                                                                 src="<?= $chambre['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $chambre['photos'] ?>"
                                                                 focusable="false" role="img"
                                                                 aria-label="Placeholder: Thumbnail" alt="">
                                                        </div>
                                                        <div class="card-body">
                                                            <div style="display: flex; align-items: center; justify-content: space-between; font-family: Playfair Display, serif; font-size :larger; font-weight: 600;">
                                                                <p class="card-text"
                                                                   style="color:black; margin-bottom: 0;">
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
                                            <div class="modal fade"
                                                 id="detailsModal-<?php echo $chambre['num_chambre']; ?>" tabindex="-1"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true"
                                                 style="font-family: Open Sans , sans-serif;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content" style="color: black;">
                                                        <div class="modal-header">

                                                            <h3 class="card-title">
                                                                Détails de la
                                                                chambre <?php echo $chambre['num_chambre']; ?>
                                                                : <?php echo $chambre['lib_typ']; ?>
                                                            </h3>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                                               class="btn btn-primary">Réserver
                                                                                maintenant</a>
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

										echo '</div>';
										echo '<div class="float-right mt-4" style="text-align: right;">
                                            <a href="' . PATH_PROJECT . 'client/chambres" class="btn btn-primary" style="--bs-btn-color: #fff; --bs-btn-bg: #013534; --bs-btn-border-color: #000000; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #9d6b15; --bs-btn-hover-border-color: #000000; font-family: Playfair Display, sans-serif; font-size :large">Voir plus >></a>
                                        </div>';
									}
								} else {
									?>
                                    <!-- Affiche un message d'erreur si la chambre n'existe pas -->
                                    <p class="size-18 m-size-14">
                                        Aucune chambre n'est disponible actuellement.
                                    </p>

									<?php
								}
								?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <!-- End Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Témoignages</h2>
                <p>Ce qu'ils disent de nous</p>
            </div>

            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>

                                J'ai été affectée dans cette ville pour affaire. Et pour
                                globaliser, je dirais que le cadre est très agréable après une
                                dure journée de travail.

                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>

                            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-1.jpg"
                                 class="testimonial-img" alt=""/>

                            <h3>Saul Goodman</h3>

                            <h4>Ceo &amp; Founder</h4>
                        </div>
                    </div>
                    <!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>

                                J'ai été affectée dans cette ville pour affaire. Je dirais que c'est très bien comme
                                lieu et aussi, j'ai beaucoup apprécié les mets.

                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>

                            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-2.jpg"
                                 class="testimonial-img" alt=""/>

                            <h3>Sara Wilson</h3>

                            <h4>Designer</h4>
                        </div>
                    </div>
                    <!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>

                                J'ai reçu en cadeau de mariage, une suite dans cet hôtel pour ma nuit de noces avec mon mari. Et la déception n'est pas éprouvé tout au long de notre séjour.

                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>

                            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-3.jpg"
                                 class="testimonial-img" alt=""/>

                            <h3>Jena Karlis</h3>

                            <h4>Store Owner</h4>
                        </div>
                    </div>
                    <!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>

                                Je suis venu passer mes vacances dans cette ville et je me
                                sens vraiment comme roi ici. Ils répondent à mes besoins et je
                                n'ai pas de quoi me plaindre.

                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>

                            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-4.jpg"
                                 class="testimonial-img" alt=""/>

                            <h3>Matt Brandon</h3>

                            <h4>Freelancer</h4>
                        </div>
                    </div>
                    <!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>

                                Je viens ici souvent avec ma femme pour la faire changer un
                                peu l'atmosphère conjugale. Et c'est très cool.

                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>

                            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-5.jpg"
                                 class="testimonial-img" alt=""/>

                            <h3>John Larson</h3>

                            <h4>Entrepreneur</h4>
                        </div>
                    </div>
                    <!-- End testimonial item -->
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <!-- End Testimonials Section -->

<?php
include('./app/commum/footer_client.php');
?>