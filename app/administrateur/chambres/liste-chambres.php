<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside.php';

// $liste_chambre = recuperer_liste_chambres();

$data = [];

if (!empty($_SESSION['data'])) {
    $data = $_SESSION['data'];
}

$page = 1;

if (!empty($params[3])) {
    $page = $params[3];
}


$liste_chambres = liste_chambres_admin($page);

if (!empty($data['type_chambre'])) {
    $liste_chambres = liste_chambres_admin($page, $data['type_chambre']);
}


$types = liste_types();

?>

<style>
    .chambre {
        /* background-color: white; */
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }



    .menu-actions {
        display: flex;
        justify-content: space-around;
        padding: 10px 0;
    }

    .card-custom {
        height: auto;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #f8f9fa;
        /* Couleur de fond légère */
    }

    .card-body-custom {
        padding: 10px;
    }

    .img-custom {
        width: 80px;
        /* Ajustez la taille selon vos besoins */
        height: 80px;
    }
</style>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="text-decoration: none; color: #cda45e;" href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item active">Liste des chambres</li>
            </ol>
        </nav>
    </div>

    <?php
    // Affichage du message de succès global s'il existe
    if (!empty($_SESSION['message-success-global'])) {
    ?>
        <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
            <?= $_SESSION['message-success-global'] ?>
        </div>
    <?php
    }
    ?>

    <?php
    // Affichage du message d'erreur global s'il existe
    if (!empty($_SESSION['message-erreur-global'])) {
    ?>
        <div class="alert alert-danger" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
            <?= $_SESSION['message-erreur-global'] ?>
        </div>
    <?php
    }
    ?>



    <form action="<?= PATH_PROJECT ?>administrateur/chambres/traitement-chambre" method="post" class="user" novalidate>
        <div class="row">
            <div class="row justify-content-end">
                <div class="col-3">
                    <div class="input-group mb-3">
                        <!-- <select class="form-select" aria-label="Sélectionner un type de chambre" name="type_chambre"> -->
                        <select class="form-select" aria-label="Sélectionner un type de chambre" name="type_chambre" id="type_chambre_select">

                            <option value="">Tout Afficher</option>
                            <?php
                            if (!empty($types)) {
                                foreach ($types as $type) {
                            ?>
                                    <option <?php echo !empty($data['type_chambre']) && $data['type_chambre'] == $type ? 'selected' : '' ?> value="<?= $type ?>"><?= $type ?></option>
                            <?php
                                }
                            }
                            ?>

                        </select>
                        <!-- <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="bi bi-search"></i></button> -->
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <?php
                // Affichez les chambres de la page actuelle
                if (!empty($liste_chambres)) {
                    foreach ($liste_chambres as $chambre) {
                ?>

                        <div class="chambre col-md-3">

                            <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#detailsModal-<?php echo $chambre['num_chambre']; ?>" data-num-chambre="<?php echo $chambre['num_chambre']; ?>"> -->
                            <!-- <a href="<?= PATH_PROJECT . 'client/chambres/details_chambre/' . $chambre['num_chambre'] ?>"> -->
                            <div class="card mb-4 shadow-sm">
                                <div class="zoom-effect-container">
                                    <img class="bd-placeholder-img card-img-top zoom-effect" width="100%" height="225" src="<?= $chambre['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $chambre['photos'] ?>" focusable="false" role="img" aria-label="Placeholder: Thumbnail" alt="">
                                </div>
                                <div class="card-body card-body-custom">
                                    <h5 class="card-title" style="color:black;">
                                        Chambre <?php echo $chambre['num_chambre']; ?> de
                                        type <?php echo $chambre['lib_typ']; ?>
                                    </h5>

                                    <div style="display: flex; align-items: center; justify-content: center; font-family: Playfair Display, serif; font-size :larger; font-weight: 600;">

                                        <!-- <a href="<?= PATH_PROJECT . 'client/chambres/details_chambre/' . $chambre['num_chambre'] ?>">Détails</a> -->

                                        <div class="menu-actions">
                                            <!-- Button de détails modal -->
                                            <i class="fas fa-eye details-icon " style=" color:green; margin-right: 70px;" data-toggle="modal" data-target="#details-chambre-<?php echo $chambre['num_chambre']; ?>" title="Voir les détails">
                                            </i>

                                            <!-- lien bouton pour modifier et supprimer -->
                                            <a href="<?= PATH_PROJECT ?>administrateur/chambres/modifier-chambre/<?= $chambre['num_chambre'] ?>" style="color: #d99727; margin-right: 70px;">
                                                <i class="far fa-edit modifier-icon" title="Modifier chambre"></i>
                                            </a>

                                            <a href="#" data-toggle="modal" data-target="#supprimer-chambre-<?= $chambre["num_chambre"]; ?>" style="color: #7e0707;">
                                                <i class="far fa-trash-alt supprimer-icon"></i>
                                            </a>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- </a> -->
                        </div>

                        <!-- Modal  Détails-->
                        <div class="modal fade" id="details-chambre-<?php echo $chambre['num_chambre']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family: Open Sans , sans-serif;">
                            <div class="modal-dialog">
                                <div class="modal-content" style="color: black;">
                                    <div class="modal-header">

                                        <h3 class="card-title">
                                            <strong> Détails de la chambre <?php echo $chambre['num_chambre']; ?>
                                                : <?php echo $chambre['lib_typ']; ?> </strong>
                                        </h3>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="text-align: center;">
                                        <p class="card-text">
                                            <strong>Descriptions : </strong> <?php echo $chambre['details']; ?>
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
                                            <div class="col-md-12">
                                                <strong>Avantages : </strong>
                                                <a title="Cocktail De Bienvenue" class="nd_booking_tooltip_jquery nd_booking_float_left"><img alt="Cocktail De Bienvenue" class="nd_booking_margin_right_15 nd_booking_float_left" width="23" height="23" src="<?= PATH_PROJECT ?>public/images/Icons/icon-13.png" /></a>
                                                <a title="Salle de bains privée" class="nd_booking_tooltip_jquery nd_booking_float_left"><img alt="Salle de bains privée" class="nd_booking_margin_right_15 nd_booking_float_left" width="23" height="23" src="<?= PATH_PROJECT ?>public/images/Icons/icon-10.png" /></a>
                                                <a title="satellite-tv" class="nd_booking_tooltip_jquery nd_booking_float_left"><img alt="satellite-tv" class="nd_booking_margin_right_15 nd_booking_float_left" width="23" height="23" src="<?= PATH_PROJECT ?>public/images/Icons/icon-18.png" /></a>
                                                <a title="Blanchisserie" class="nd_booking_tooltip_jquery nd_booking_float_left"><img alt="Blanchisserie" class="nd_booking_margin_right_15 nd_booking_float_left" width="23" height="23" src="<?= PATH_PROJECT ?>public/images/Icons/icon-15.png" /></a>
                                                <a title="Wifi" class="nd_booking_tooltip_jquery nd_booking_float_left"><img alt="Wifi" class="nd_booking_margin_right_15 nd_booking_float_left" width="23" height="23" src="<?= PATH_PROJECT ?>public/images/Icons/icon-12-1.png" /></a>
                                            </div>

                                            <!-- <div class="col-md-6">
                                                <?php
                                                if (!check_if_user_connected_client()) {
                                                ?>
                                                    <div class="mt-4" style="text-align: center;">
                                                        <a href="<?= PATH_PROJECT ?>client/connexion" class="btn btn-primary">Réserver maintenant</a>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal supprimer -->
                        <div class="modal fade" id="supprimer-chambre-<?= $chambre["num_chambre"]; ?>" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="color: black;">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Supprimer la chambre <?= $chambre["num_chambre"]; ?></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p style="font-size: larger;">Êtes-vous sûr de vouloir supprimer la chambre <?= $chambre["lib_typ"]; ?> ?</p>
                                    </div>
                                    <div class="modal-footer ">
                                        <a href="<?= PATH_PROJECT ?>administrateur/chambres/traitement-supprimer-chambre/<?= $chambre["num_chambre"]; ?>" class="btn btn-danger">Oui</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin Modal supprimer -->
                    <?php
                    }
                    ?>


                <?php
                } else {
                ?>
                    <!-- Affiche un message d'erreur si la chambre n'existe pas -->
                    <div style="margin-bottom: 280px;">
                        La page chambre que vous souhaitez voir n'existe pas.
                        <a class="" href="<?= PATH_PROJECT ?>administrateur/chambres/liste-chambres" style="color: #cda45e;">Retour
                            vers la liste des chambres</a>
                    </div>
                <?php
                }
                ?>
            </div>

            <!-- Affiche le bouton de réservation uniquement sur la dernière page -->
            <?php if (!empty($liste_chambres) && count($liste_chambres) < 8) : ?>
                <div class="row">
                    <div class="col-md-12 text-right mb-4">
                        <a class="btn btn-primary" href="<?= PATH_PROJECT . 'administrateur/chambres/index' ?>">
                            <!-- Afficher le bouton de réservation ici -->
                            Ajouter une chambre
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Pagination -->
            <nav aria-label="Page navigation example" style="justify-content: center; display:flex;">
                <ul class="pagination">
                    <?php if ($page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="<?= PATH_PROJECT . 'administrateur/chambres/liste-chambres/' ?><?= $page - 1 ?>">Précédent</a>
                        </li>
                    <?php endif; ?>
                    <li class="page-item active"><a class="page-link" href="#"><?= $page ?></a></li>
                    <?php if (!empty($liste_chambres) && count($liste_chambres) == 8) : ?>
                        <li class="page-item"><a class="page-link" href="<?= PATH_PROJECT . 'administrateur/chambres/liste-chambres/' ?><?= $page + 1 ?>">Suivant</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

        </div>
    </form>


    <script>
        document.getElementById('type_chambre_select').addEventListener('change', function() {
            this.form.submit();
        });
    </script>



    <?php
    // Supprime les messages de succès et d'erreur globaux de la session
    unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

    include './app/commum/footer.php';
    ?>