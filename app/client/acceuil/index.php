<?php
include('./app/commum/header_client.php');
?>


<!-- ======= Hero Section ======= -->
<header id="headerwrap" class="backstretched no-overlay fullheight">
  <div class="container vertical-center">
    <div class="intro-text vertical-center text-left smoothie">
      <div class="intro-heading h1 wow fadeIn heading-font" data-wow-delay="0.2s">
        Bienvenue chez vous
      </div>

      <div class="intro-sub-heading wow fadeIn secondary-font h1" data-wow-delay="0.2s">
        Nous sommes là pour vous offrir<span class="rotate">
          un séjour d'affaire/loisir relaxant, un confort remarquable, des
          salles de conférence, un espace Restaurant.</span>
      </div>
      <!-- 
      <div class="dropdown">
        <button class="btn btn-primary btn-white mt30 page-scroll dropdown-toggle" style="background-color: black; border-color: black;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          NOS MEILLEURS OFFRES
        </button>
        <ul class="dropdown-menu p-4">
          Nous vous offrons un cocktail de bienvenue pour vous laissez
          imprégner du lieu.
          <li>
            Après votre réservation vous avez accès à notre: <br />

            - Wifi haut débit disponible gratuitement dans tout l'hotel.
            <br />
            - Piscine intérieure équipée d'un jacuzzi et sauna. <br />
            - Espace Wellness en découvrant notre sauna et nos prestations
            de massage. <br />
            - Services + qui vous oriente vers nos partenaires de location
            de vélos, skis, heliski, et bien plus.
          </li>
        </ul>
      </div> -->
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
            Nous sommes situé dans le quartiers résidentiel de la ville (à
            10 minutes du centre-ville) et faisons partie de la cathégorie
            des hôtels 3 étoiles plus.
          </p>
        </div>
      </div>

      <div class="col-lg-3 mt-4 mt-lg-0">
        <div class="box" data-aos="zoom-in" data-aos-delay="100">
          <span>02</span>

          <h4>ACCEUIL & SERVICES</h4>

          <p>
            Nous vous offrons un acceuil chaleureux tout en vous faisant déguster notre cocktail de bienvenue dans un cadre spontieux.
          </p>
        </div>
      </div>

      <div class="col-lg-3 mt-4 mt-lg-0">
        <div class="box" data-aos="zoom-in" data-aos-delay="200">
          <span>03</span>

          <h4>HEBERGEMENT & SECURITE</h4>

          <p>
            Reservez une chambre pour rester dans un environnement agréable et sécurisé.
          </p>
        </div>
      </div>

      <div class="col-lg-3 mt-4 mt-lg-0">
        <div class="box" data-aos="zoom-in" data-aos-delay="300">
          <span>04</span>

          <h4>CONFORT & REPAS</h4>

          <p>
            Nos repas peuvent être pris au bord de la piscine intérieure et vos détentes sur notre espace Wellness et Bibliothèque.
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
          décorées dans un styles minimaliste, qui permet une utilisation optimal de l'espace.
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

                      <div class="card mb-4 shadow-sm">
                        <div class="zoom-effect-container">
                          <img class="bd-placeholder-img card-img-top zoom-effect" width="100%" height="225" src="<?= $chambre['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $chambre['photos'] ?>" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
                        </div>
                        <div class="card-body">
                          <p class="card-text" style="color:black;"> Chambre <?php echo $chambre['num_chambre']; ?></p>
                          <!-- <a href="<?= PATH_PROJECT . 'client/chambres/details_chambre/' . $chambre['num_chambre'] ?>">Détails</a> -->
                        </div>
                      </div>
                    </div>

                    <!-- <div class="col-md-4">
                      <a href="<?= $photos ?>">
                        <figure id="vignette2">
                          <img id="photo2" src="<?= $photos ?>" alt="<?= $nomChambre ?>" />
                          <figcaption>
                            <h3 id="intitule2"><?= $nomChambre ?></h3>
                          </figcaption>
                        </figure>
                      </a>
                    </div> -->
                <?php
                  }

                  echo '</div>';
                  echo '<div class="float-right mt-4" style="text-align: right;">
                          <a href="' . PATH_PROJECT . 'client/chambres" class="btn btn-primary" style="--bs-btn-color: #fff; --bs-btn-bg: #013534; --bs-btn-border-color: #000000; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #9d6b15; --bs-btn-hover-border-color: #000000;">Voir plus >></a>
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

            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-1.jpg" class="testimonial-img" alt="" />

            <h3>Saul Goodman</h3>

            <h4>Ceo &amp; Founder</h4>
          </div>
        </div>
        <!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-item">
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>

              J'ai été affectée dans cette ville pour affaire. Je dirais que c'est très bien comme lieu et aussi j'ai
              beaucoup apprécier les mets.

              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>

            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-2.jpg" class="testimonial-img" alt="" />

            <h3>Sara Wilsson</h3>

            <h4>Designer</h4>
          </div>
        </div>
        <!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-item">
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>

              J'ai reçu en cadeau de mariage, une suite dans cette hôtel
              pour ma nuit de noces avec mon mari. Et la déception n'est pas
              éprouvé tout au long de notre séjour.

              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>

            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-3.jpg" class="testimonial-img" alt="" />

            <h3>Jena Karlis</h3>

            <h4>Store Owner</h4>
          </div>
        </div>
        <!-- End testimonial item -->

        <div class="swiper-slide">
          <div class="testimonial-item">
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>

              Je suis venu passer mes vaccances dans cette ville et je me
              sens vraiment comme roi ici. Ils répondent à mes besoins et je
              n'ai pas de quoi me plaindre.

              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>

            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-4.jpg" class="testimonial-img" alt="" />

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

            <img src="<?= PATH_PROJECT ?>public/images/testimonials/testimonials-5.jpg" class="testimonial-img" alt="" />

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