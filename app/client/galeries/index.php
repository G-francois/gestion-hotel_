<?php

include('./app/commum/header_client.php');

$liste_chambres = recuperer_liste_chambres();


?>
    <!-- ======= Hero Section ======= -->
    <section id="hero2" class="d-flex align-items-center">
        <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-8">
                    <h1>Espace<span> Galerie</span></h1>
                    <h2>
                        Naviguer par-dessus les images pour plus d'informations.
                    </h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <!-- ======= Gallery Section Chambres ======= -->
    <section id="chambres" class="chambres">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Galerie</h2>
                <p>Quelques photos de nos Chambres</p>
            </div>
        </div>

        <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-0 d-flex">
				<?php
				// Affichez les chambres de la page actuelle
				if (!empty($liste_chambres)) {
					foreach ($liste_chambres as $chambre) {
						?>


                        <!-- <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="<?= $chambre['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $chambre['photos'] ?>" class="gallery-lightbox" data-gall="gallery-item">
                <img width="100%" height="225" src="<?= $chambre['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $chambre['photos'] ?>" alt="" />
              </a>
            </div>
          </div> -->


                        <div class="col-lg-3 col-md-4 p-1">
                            <div class="member" data-aos="zoom-in" data-aos-delay="100">
                                <img width="100%" height="225"
                                     src="<?= $chambre['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $chambre['photos'] ?>"
                                     alt=""/>
                                <div class="member-info">
                                    <div class="member-info-content">
                                        <h4>Chambre : <?php echo $chambre['lib_typ']; ?></h4>
                                        <span>
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star"></i>
                                    </span>
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
                        Les chambres que vous souhaitez voir n'existe pas.
                        <!-- <a class="" href="<?= PATH_PROJECT ?>client/chambres" style="color : #cda45e;">Retour vers la liste des chambres</a> -->
                    </div>
					<?php
				}
				?>
            </div>
        </div>
    </section>
    <!-- ======= End Gallery Section Chambres ======= -->

    <!-- ======= Gallery Section espaces ======= -->
    <section id="chambres" class="chambres">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Galerie</h2>
                <p>Quelques photos de nos Espaces</p>
            </div>
        </div>
        <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-0 d-flex">
                <div class="col-lg-3 col-md-4 p-1">
                    <div class="member" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= PATH_PROJECT ?>public/images/wellness/filles-au-spa.jpg" class="img-fluid"
                             alt=""/>
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Espace Piscine</h4>
                                <span>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="member" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= PATH_PROJECT ?>public/images/wellness/salle_de_jeu (1).jpg" class="img-fluid"
                             alt=""/>
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Espace jeu</h4>
                                <span>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="member" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= PATH_PROJECT ?>public/images/wellness/salle_de_reunion 2.jpg" class="img-fluid"
                             alt=""/>
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Espace Réunion</h4>
                                <span>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="member" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= PATH_PROJECT ?>public/images/wellness/belle-femme-africaine-au-repos-relaxante-dans-station-thermale-yeux-fermes.jpg"
                             class="img-fluid" alt=""/>
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Espace Bien-être</h4>
                                <span>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="member" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= PATH_PROJECT ?>public/images/wellness/salle_de_jeu (3).jpg" class="img-fluid"
                             alt=""/>
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Espace JEUX</h4>
                                <span>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="member" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= PATH_PROJECT ?>public/images/wellness/piscine.jpg" class="img-fluid" alt=""/>
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Espace Piscine</h4>
                                <span>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="member" data-aos="zoom-in" data-aos-delay="300">
                        <img src="<?= PATH_PROJECT ?>public/images/wellness/femme-relaxante-dans-station-balneaire-ayant-massage-sain-spa2.jpg"
                             class="img-fluid" alt=""/>
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Espace Bien-être</h4>
                                <span>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="member" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= PATH_PROJECT ?>public/images/wellness/salle_de_reunion.jpg" class="img-fluid"
                             alt=""/>
                        <div class="member-info">
                            <div class="member-info-content">
                                <h4>Espace Réunion</h4>
                                <span>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ======= End Gallery Section espaces ======= -->

    <!-- ======= Gallery Section Restaurant ======= -->
    <section id="gallery" class="gallery">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Galerie</h2>
                <p>Quelques photos de notre Restaurant</p>
            </div>
        </div>

        <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-0">
                <div class="col-lg-3 col-md-4 p-1">
                    <div class="gallery-item">
                        <a href="<?= PATH_PROJECT ?>public/images/gallery/gallery-1.jpg" class="gallery-lightbox"
                           data-gall="gallery-item">
                            <img src="<?= PATH_PROJECT ?>public/images/gallery/gallery-1.jpg" alt="" class="img-fluid"/>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="gallery-item">
                        <a href="<?= PATH_PROJECT ?>public/images/gallery/gallery-2.jpg" class="gallery-lightbox"
                           data-gall="gallery-item">
                            <img src="<?= PATH_PROJECT ?>public/images/gallery/gallery-2.jpg" alt="" class="img-fluid"/>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="gallery-item">
                        <a href="<?= PATH_PROJECT ?>public/images/gallery/gallery-3.jpg" class="gallery-lightbox"
                           data-gall="gallery-item">
                            <img src="<?= PATH_PROJECT ?>public/images/gallery/gallery-3.jpg" alt="" class="img-fluid"/>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="gallery-item">
                        <a href="<?= PATH_PROJECT ?>public/images/gallery/gallery-4.jpg" class="gallery-lightbox"
                           data-gall="gallery-item">
                            <img src="<?= PATH_PROJECT ?>public/images/gallery/gallery-4.jpg" alt="" class="img-fluid"/>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="gallery-item">
                        <a href="<?= PATH_PROJECT ?>public/images/gallery/gallery-10.jpg" class="gallery-lightbox"
                           data-gall="gallery-item">
                            <img src="<?= PATH_PROJECT ?>public/images/gallery/gallery-10.jpg" alt=""
                                 class="img-fluid"/>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="gallery-item">
                        <a href="<?= PATH_PROJECT ?>public/images/gallery/gallery-13.jpeg" class="gallery-lightbox"
                           data-gall="gallery-item">
                            <img src="<?= PATH_PROJECT ?>public/images/gallery/gallery-13.jpeg" alt=""
                                 class="img-fluid"/>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="gallery-item">
                        <a href="<?= PATH_PROJECT ?>public/images/gallery/gallery-12.jpeg" class="gallery-lightbox"
                           data-gall="gallery-item">
                            <img src="<?= PATH_PROJECT ?>public/images/gallery/gallery-12.jpeg" alt=""
                                 class="img-fluid"/>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 p-1">
                    <div class="gallery-item">
                        <a href="<?= PATH_PROJECT ?>public/images/gallery/gallery-9.jpeg" class="gallery-lightbox"
                           data-gall="gallery-item">
                            <img src="<?= PATH_PROJECT ?>public/images/gallery/gallery-9.jpeg" alt=""
                                 class="img-fluid"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Gallery Section Restaurant-->


<?php

include('./app/commum/footer_client.php');

?>