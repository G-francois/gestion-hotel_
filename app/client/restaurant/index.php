<?php

$include_client_header = true;
include('./app/commum/header_.php');

$menuItems = recuperer_liste_repas();
?>

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">
  <div class="container position-relative text-center text-lg-start" data-aos="zoom-in" data-aos-delay="100">
    <div class="row">
      <div class="col-lg-8">
        <h1>Bienvenue dans notre<span> Espace Restaurant</span></h1>
        <h2>Doté d'une expérience de plus de 18 ans notre cuisine repond à tous les goûts.</h2>

        <div class="btns">
          <a href="#menu" class="btn-menu animated fadeInUp scrollto">Notre Carte</a>
          <a href="<?= PATH_PROJECT ?>client/restaurant/commande" class="btn-book animated fadeInUp scrollto">Faire une Commande</a>
        </div>
      </div>
      <div class="col-lg-4 d-flex align-items-center justify-content-center position-relative" data-aos="zoom-in" data-aos-delay="200">
        <a href="https://www.youtube.com/watch?v=u6BOC7CDUTQ" class="glightbox play-btn"></a>
      </div>
    </div>
  </div>
</section>
<!-- End Hero -->

<main id="main">
  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="100">
          <div class="about-img">
            <img src="<?= PATH_PROJECT ?>public/images/about.jpg" alt="" />
          </div>
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
          <h3>
            Nous vous procuront les plaisirs les plus dignes, comme si les
            plaisirs du corps devaient être assumés.
          </h3>
          <p class="fst-italic">
            Il est important pour nous de prendre soin de vous, mais en même
            temps de vous satisfaire.
          </p>
          <ul>
            <li>
              <i class="bi bi-check-circle"></i> Notre terrasse permet
              d’accueillir une grande capacité de personnes dès que les
              beaux jours apparaissent.
            </li>
            <li>
              <i class="bi bi-check-circle"></i> Notre volonté est de faire
              passer un bon moment à tous nos clients.
            </li>
            <li>
              <i class="bi bi-check-circle"></i> Nous mettons à l’honneur
              ces gens de l’ombre qui participent pleinement à vous faire
              passer un excellent moment avec cette vue de mer.
            </li>
          </ul>
          <p>
            Notre restaurant Sous les Cocotiers s’inscrit dans ce cadre.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- End About Section -->

  <!-- ======= Why Us Section ======= -->
  <section id="why-us" class="why-us">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Pourquoi nous</h2>
        <p>Pourquoi choisir notre Restaurant</p>
      </div>

      <div class="row">
        <div class="col-lg-4">
          <div class="box" data-aos="zoom-in" data-aos-delay="100">
            <span>01</span>
            <h4>L'hygiène et la propreté sont au rendez-vous</h4>
            <p>
              Notre préoccupation est de veiller à la
              qualité des aliments, en minimisant les risques d'intoxication.
            </p>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="box" data-aos="zoom-in" data-aos-delay="200">
            <span>02</span>
            <h4>Un environnement calme et décontractant</h4>
            <p>
              Sous les Cocotiers est né de la volonté de créer un lieu
              convivial.
            </p>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="box" data-aos="zoom-in" data-aos-delay="300">
            <span>03</span>
            <h4>Un décors qui vous donne de l'appetit</h4>
            <p>
              Notre cuisine se dit simple mais avec du goût et des dessert qui vous facilitent la digestion.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Why Us Section -->

  <!-- ======= Menu Section ======= -->
  <!-- <section id="menu" class="menu section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Menu</h2>
        <p>Consultez notre menu savoureux</p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-12 d-flex justify-content-center">
          <ul id="menu-flters">
            <li data-filter="*" class="filter-active">Tout</li>
            <li data-filter=".filter-starters">Entrées</li>
            <li data-filter=".filter-salads">Salades</li>
            <li data-filter=".filter-specialty">Spécialité</li>
          </ul>
        </div>
      </div>

      <div class="row menu-container" data-aos="fade-up" data-aos-delay="200">
        <div class="col-lg-6 menu-item filter-starters">
          <img src="<?= PATH_PROJECT ?>public/images/menu/L'attiéké.jpg" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Attiéké</a><span>3.500 FCFA</span>
          </div>
          <div class="menu-ingredients">
            L'attiéké est un couscous traditionnel ivoirien composé de
            tubercule de manioc fermentées et moulues. Il est généralement
            accompagné d'oignons émincés, de tomates, de poulet grillé ou de
            poisson frit.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-specialty">
          <img src="<?= PATH_PROJECT ?>public/images/menu/bread-barrel.jpg" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Baril de pain</a><span>4.250 FCFA</span>
          </div>
          <div class="menu-ingredients">
            Le pain maison est un acte de simplicité volontaire.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-starters">
          <img src="<?= PATH_PROJECT ?>public/images/menu/cake.jpg" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Gâtaeu au Crabe</a><span>5.000 FCFA</span>
          </div>
          <div class="menu-ingredients">
            Un gâteau de crabe délicat servi sur un petit pain grillé avec
            de la laitue et de la sauce tartare.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-salads">
          <img src="<?= PATH_PROJECT ?>public/images/menu/caesar.jpg" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Selection de caesar</a><span>5.500 FCFA</span>
          </div>
          <div class="menu-ingredients">
            Un ensemble de plat collectionné composé de viandes et de
            légumes verts dans une sauce à base de tomates.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-specialty">
          <img src="<?= PATH_PROJECT ?>public/images/menu/tuscan-grilled.jpg" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#"> Grillarde Toscanes</a><span>6.200 FCFA</span>
          </div>
          <div class="menu-ingredients">
            Poulet grillé avec provolone, cœurs d'artichauts et pesto rouge
            rôti.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-starters">
          <img src="<?= PATH_PROJECT ?>public/images/menu/mozzarella.jpg" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Baton de Mozzarella</a><span>3.000 FCFA</span>
          </div>
          <div class="menu-ingredients">
            Les bâtonnets de mozzarella sont une collation frite populaire
            composée de longues tranches de fromage mozzarella garni de
            chapelure assaisonnée et frite jusqu’à ce qu’elle soit dorée et
            fondue à l’intérieur.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-salads">
          <img src="<?= PATH_PROJECT ?>public/images/menu/greek-salad.jpg" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Salade Grecque</a><span>4.200 FCFA</span>
          </div>
          <div class="menu-ingredients">
            Épinards frais, romaine croustillante, tomates et olives
            grecques.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-salads">
          <img src="<?= PATH_PROJECT ?>public/images/menu/spinach-salad.jpg" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Salade d'épinards</a><span>3.000 FCFA</span>
          </div>
          <div class="menu-ingredients">
            Épinards frais aux champignons, œuf dur et vinaigrette chaude au
            bacon.
          </div>
        </div>

        <div class="col-lg-6 menu-item filter-specialty">
          <img src="<?= PATH_PROJECT ?>public/images/menu/lobster-roll.jpg" class="menu-img" alt="" />
          <div class="menu-content">
            <a href="#">Rouleau de homard</a><span>8.000 FCFA</span>
          </div>
          <div class="menu-ingredients">
            Chair de homard dodue, mayonnaise et laitue croustillante sur un
            gros pain grillé.
          </div>
        </div>
      </div>
    </div>
  </section> -->

  <section id="menu" class="menu section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Menu</h2>
        <p>Consultez notre menu savoureux</p>
      </div>

      <?php
      // Vérifie si la liste des repas existe et n'est pas vide
      if (isset($menuItems) && !empty($menuItems)) {
      ?>
        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <!-- You can dynamically generate filters based on categories in your database -->
            <ul id="menu-flters">
              <li data-filter="*" class="filter-active">Tout</li>
              <li data-filter=".filter-entrees">Entrées</li>
              <li data-filter=".filter-salades">Salades</li>
              <li data-filter=".filter-specialites">Spécialité</li>
            </ul>
          </div>
        </div>

        <div class="row menu-container" data-aos="fade-up" data-aos-delay="200">
          <?php
          // Assuming $menuItems is an array of menu items fetched from the database
          foreach ($menuItems as $menuItem) {
          ?>
            <div class="col-lg-6 menu-item <?= 'filter-' . strtolower($menuItem['categorie']); ?>">
              <img src="<?= $menuItem['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $menuItem['photos'] ?>" class="menu-img" alt="" />
              <div class="menu-content">
                <a href="#"><?= $menuItem['nom_repas']; ?></a><span><?= $menuItem['pu_repas']; ?> FCFA</span>
              </div>
              <div class="menu-ingredients">
                <?= $menuItem['descriptions']; ?>
              </div>
            </div>
          <?php
          }
          ?>
        </div>

      <?php
      } else {
        // Affiche un message s'il n'y a aucun repas trouvé
        echo "Aucun repas n'a été trouvé!";
      }
      ?>
  </section>
  <!-- End Menu Section -->

  <!-- ======= Specials Section ======= -->
  <section id="specials" class="specials">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Spéciaux</h2>
        <p>Consultez nos promotions</p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-3">
          <ul class="nav nav-tabs flex-column">
            <li class="nav-item">
              <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">Riz</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#tab-3">Nouilles</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#tab-4">Dîner de Noël</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#tab-5">Plat de fruits</a>
            </li>
          </ul>
        </div>
        <div class="col-lg-9 mt-4 mt-lg-0">
          <div class="tab-content">
            <div class="tab-pane active show" id="tab-1">
              <div class="row">
                <div class="col-lg-8 details order-2 order-lg-1">
                  <h3>
                    Riz Frit avec Côtelettes de Poulet aux Œufs Salés.
                  </h3>
                  <p class="fst-italic">
                    Il est facile d'incorporer la dernière tendance dans le
                    plat populaire de votre restaurant, le riz frit avec
                    côtelette de poulet. Servez des côtelettes de poulet
                    crémeuses et savoureuses aux œufs salés Nasi Goreng en
                    un rien de temps !
                  </p>
                </div>
                <div class="col-lg-4 text-center order-1 order-lg-2">
                  <img src="<?= PATH_PROJECT ?>public/images/specials-1.png" alt="" class="img-fluid" />
                </div>
              </div>
            </div>

            <div class="tab-pane" id="tab-3">
              <div class="row">
                <div class="col-lg-8 details order-2 order-lg-1">
                  <h3>Les Nouilles</h3>
                  <p class="fst-italic">
                    Pâtes alimentaires de longueur moyenne, plates ou
                    rondes, et coupées en lanières minces. Il y eut des
                    plats à ravir à la pensée!... des nouilles d'une
                    délicatesse inédite, des éperlans d'une friture
                    incomparable.
                  </p>
                </div>
                <div class="col-lg-4 text-center order-1 order-lg-2">
                  <img src="<?= PATH_PROJECT ?>public/images/specials-3.png" alt="" class="img-fluid" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-4">
              <div class="row">
                <div class="col-lg-8 details order-2 order-lg-1">
                  <h3>Dîner de Noël</h3>
                  <p class="fst-italic">
                    Le dîner de Noël traditionnel comprend de la dinde
                    farcie, de la purée de pommes de terre, de la sauce, de
                    la sauce aux canneberges et des légumes . D'autres types
                    de volaille, rosbif ou jambon, sont également utilisés.
                    La tarte à la citrouille ou aux pommes, le pudding aux
                    raisins secs, le pudding de Noël ou le gâteau aux fruits
                    sont des incontournables du dessert.
                  </p>
                </div>
                <div class="col-lg-4 text-center order-1 order-lg-2">
                  <img src="<?= PATH_PROJECT ?>public/images/specials-4.png" alt="" class="img-fluid" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-5">
              <div class="row">
                <div class="col-lg-8 details order-2 order-lg-1">
                  <h3>Plat de fruits</h3>
                  <p class="fst-italic">
                    Bien sélectionnés et consommés aux bons moments, les
                    fruits contribuent au maintien de l'énergie, de la
                    vigilance et de l'efficacité au travail Gorgés d'eau, de
                    vitamines, d'oligo-éléments ou encore de fibres ils
                    apportent à l'organisme des éléments indispensable à son
                    bon fonctionnement.
                  </p>
                </div>
                <div class="col-lg-4 text-center order-1 order-lg-2">
                  <img src="<?= PATH_PROJECT ?>public/images/specials-5.png" alt="" class="img-fluid" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Specials Section -->

  <!-- ======= Events Section ======= -->
  <section id="events" class="events">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Evernements</h2>
        <p>Organisez vos Evernements dans notre Restaurant</p>
      </div>

      <div class="events-slider swiper" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="row event-item">
              <div class="col-lg-6">
                <img src="<?= PATH_PROJECT ?>public/images/event-birthday.jpg" class="img-fluid" alt="" />
              </div>
              <div class="col-lg-6 pt-4 pt-lg-0 content">
                <h3>Fêtes d'anniversaire</h3>
                <div class="price">
                  <p><span>116.500 FCFA</span></p>
                </div>
                <p class="fst-italic">
                  Offrez-vous un escape game avec des copains. <br />
                  C’est l’anniversaire de vos enfants, ou proches et vous
                  souhaitez leurs offrires un moment inoubliable avec ses
                  copains ? Amenez-les chez nous, on s’occupe de tout !
                  <br />
                  Partie endiablée dans l’escape room, goûter
                  d’anniversaire, ouverture des cadeaux, ballons… tous les
                  ingrédients indispensables sont réunis pour que vos
                  enfants, ou proches n’oublient jamais cette journée très
                  spécial.
                </p>
              </div>
            </div>
          </div>
          <!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="row event-item">
              <div class="col-lg-6">
                <img src="<?= PATH_PROJECT ?>public/images/event-private.jpg" class="img-fluid" alt="" />
              </div>
              <div class="col-lg-6 pt-4 pt-lg-0 content">
                <h3>Soirées privées</h3>
                <div class="price">
                  <p><span>180.000 FCFA</span></p>
                </div>
                <p class="fst-italic">
                  Organisez une soirée privée mémorable ! <br />
                  Une fois votre escape game terminé, rendez-vous à l’espace
                  restauration pour une soirée inoubliable. Que vous veniez
                  pour un anniversaire, des fiançailles, un vin d’honneur,
                  un mariage, un anniversaire de mariage, un départ à la
                  retraite ou juste pour passer du bon temps avec des
                  personnes chères à votre cœur, nous sommes heureux de
                  participer à la création de si beaux souvenirs !
                </p>
              </div>
            </div>
          </div>
          <!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="row event-item">
              <div class="col-lg-6">
                <img src="<?= PATH_PROJECT ?>public/images/event-custom.jpg" class="img-fluid" alt="" />
              </div>
              <div class="col-lg-6 pt-4 pt-lg-0 content">
                <h3>Fêtes personnalisées</h3>
                <div class="price">
                  <p><span>60.000 FCFA</span></p>
                </div>
                <p class="fst-italic">
                  Offrez-vous un escape game. <br />
                  Que qu'en soit pour un anniversaire, une pendaison de
                  crémaillère, une pool party, la fête de la musique… Il y a
                  toujours une bonne raison de faire la fête et de partager
                  des moments entre amis ou entre proches ! Pour danser,
                  rire, partager un bon moment et un bon repas… Et pour
                  trinquer ! La fête est un rituel, un besoin universel qui
                  nous permet de vivre et de vibrer !
                </p>
              </div>
            </div>
          </div>
          <!-- End testimonial item -->
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>
  <!-- End Events Section -->

  <!-- ======= Chefs Section ======= -->
  <section id="chefs" class="chefs">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Chefs</h2>
        <p>Nos Chefs Proffesionnels</p>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="member" data-aos="zoom-in" data-aos-delay="100">
            <img src="<?= PATH_PROJECT ?>public/images/chefs/chefs-4.JPG" class="img-fluid" alt="" />
            <div class="member-info">
              <div class="member-info-content">
                <h4>Walter White</h4>
                <span>Chef Cuisinier</span>
              </div>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="member" data-aos="zoom-in" data-aos-delay="200">
            <img src="<?= PATH_PROJECT ?>public/images/chefs/chefs-2.jpg" class="img-fluid" alt="" />
            <div class="member-info">
              <div class="member-info-content">
                <h4>Sarah Jhonson</h4>
                <span>Patissière</span>
              </div>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="member" data-aos="zoom-in" data-aos-delay="300">
            <img src="<?= PATH_PROJECT ?>public/images/chefs/chefs-3.jpg" class="img-fluid" alt="" />
            <div class="member-info">
              <div class="member-info-content">
                <h4>William Anderson</h4>
                <span>Cuisinier</span>
              </div>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Chefs Section -->

</main>
<!-- End #main -->

<?php

include('./app/commum/footer_.php');

?>