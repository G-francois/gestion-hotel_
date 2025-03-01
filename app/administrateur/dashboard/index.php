<?php
if (!check_if_user_connected_admin()) {
  header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
  exit;
}

include './app/commum/header.php';

include './app/commum/aside.php';

$total_reservation = recuperer_nombre_reservations();
?>

<div class="container-fluid" style="color: black;">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>

  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Nombre de Réservation :
                <?php
                // Afficher le nombre total de réservations
                $total_reservations = recuperer_nombre_reservations();
                echo "<div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'> " . $total_reservations . "</div>";
                ?>
              </div>
              <ul>
                <li>
                  Réservation En cours :
                  <?php
                  // Afficher le nombre total de réservations Active
                  $total_reservations = recuperer_nombre_reservations_encours();
                  echo " $total_reservations ";
                  ?>
                </li>
                <li>
                  Réservation Valider :
                  <?php
                  // Afficher le nombre total de réservations Active
                  $total_reservations = recuperer_nombre_reservations_active();
                  echo " $total_reservations ";
                  ?>
                </li>
                <li>
                  Réservation Rejeter :
                  <?php
                  // Afficher le nombre total de réservations Rejeter
                  $total_reservations = recuperer_nombre_reservations_rejeter();
                  echo " $total_reservations ";
                  ?>
                </li>
              </ul>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Revenue total des réservations (valide)</div>
              <?php
              // Afficher le revenu total des réservations valides
              $total_revenue = recuperer_revenue_total_reservations_valide();
              echo "<div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'> " . number_format($total_revenue, 2) . " FCFA</div>";

              ?>


            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Nombre de Commande
              </div>
              <?php
              // Afficher le nombre total de commandes
              $total_reservations = recuperer_nombre_commandes();
              echo "<div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'> " . $total_reservations . "</div>";
              ?>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                Pending Requests</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <style>
    /* Container pour l'image et les détails */
    .image-container {
      position: relative;
      border-radius: 10px;
      /* Arrondir les bords de l'image */
      overflow: hidden;
      /* S'assurer que les bords de l'image arrondis sont respectés */
    }

    /* Image avec bords arrondis */
    .image-container img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 10px;
      /* Arrondir les bords de l'image */
    }

    /* Détails qui seront cachés par défaut */
    .details-overlay {
      position: absolute;
      bottom: 0;
      /* Placer l'overlay au bas de l'image */
      left: 0;
      width: 100%;
      height: 0;
      /* Commencer avec une hauteur de 0% */
      background: rgba(0, 0, 0, 0.7);
      /* Fond semi-transparent */
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      /* Masquer l'overlay au départ */
      transition: opacity 0.3s ease, height 0.3s ease;
      /* Transition douce */
      color: white;
      text-align: center;

      border-radius: 10px;
      /* Arrondir les bords de l'overlay */
    }

    /* Effet de survol pour afficher les détails */
    .image-container:hover .details-overlay {
      opacity: 1;
      /* Rendre l'overlay visible */
      height: 20%;
      /* L'overlay prendra 40% de la hauteur de l'image */
    }
  </style>

  <section>
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" style="position: relative;">
      <div class="carousel-inner">
        <?php
        // Récupérer la liste des chambres à afficher
        $liste_chambres = recuperer_liste_chambres_acceuil2();

        if (!empty($liste_chambres)) {
          $total_chambres = count($liste_chambres);
          $chambres_par_slide = 4; // Nombre de chambres par slide
          $total_slides = ceil($total_chambres / $chambres_par_slide);

          // Affichage des chambres par slide
          for ($i = 0; $i < $total_chambres; $i += $chambres_par_slide) {
            // Début d'une slide
            $active_class = $i === 0 ? 'active' : '';
            echo '<div class="carousel-item ' . $active_class . '">';

            // Création d'une grille pour les chambres dans chaque slide
            echo '<div class="row d-flex justify-content-center">'; // Début de la ligne avec les 3 images par slide
            for ($j = $i; $j < $i + $chambres_par_slide && $j < $total_chambres; $j++) {
              $chambre = $liste_chambres[$j];
              $photos = $chambre['photos'];
              $nomChambre = $chambre['lib_typ'];
              $numChambre = $chambre['num_chambre'];
        ?>

              <div class="col-3 position-relative">
                <div class="image-container">
                  <img src="<?= $photos == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $photos ?>"
                    class="d-block w-100"
                    alt="Image de la chambre"
                    style="height: 300px; object-fit: cover;">

                  <!-- Détails visibles au survol -->
                  <div class="details-overlay">

                    <p class="text-white" style="display: flex; flex-direction: column; margin:2px;">
                      Chambre <?= $numChambre ?> de type <?= $nomChambre ?>
                      <br>
                      <span>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                      </span>
                    </p>
                  </div>
                </div>
              </div>

        <?php
            }
            echo '</div>'; // Fin de la ligne
            echo '</div>'; // Fin de la slide
          }
        } else {
          echo '<p>Aucune chambre n\'est disponible actuellement.</p>';
        }
        ?>
      </div>

      <!-- Indicateurs en points -->
      <div class="carousel-indicators" style="position: absolute; bottom: -70px; z-index: 3; display: flex; justify-content: center;">
        <?php
        // Générer les indicateurs en fonction du nombre de slides
        for ($i = 0; $i < $total_slides; $i++) {
          $active_class = $i === 0 ? 'active' : '';
          echo '<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="' . $i . '" class="' . $active_class . '" aria-label="Slide ' . ($i + 1) . '" style="width: 10px; height: 10px; border-radius: 50%; margin: 0 5px;"></button>';
        }
        ?>
      </div>

    </div>
  </section>


</div>

<?php

include './app/commum/footer.php'

?>