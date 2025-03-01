<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}
include './app/commum/header.php';

include './app/commum/aside.php';

$liste_chambre = recuperer_chambres();


// Appeler la fonction pour récupérer la liste des clients
$liste_clients = recuperer_liste_clients_actifs();
?>

<!-- <style>
    .btn-custom {
        --bs-btn-color: #fff;
        --bs-btn-border-color: #fff;
        --bs-btn-bg: #cda45e;
        --bs-btn-hover-bg: #cda45e;
        --bs-btn-hover-border-color: #fff;
    }

    .card-body {
        color: black;
    }
</style> -->


<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="text-decoration: none; color: #cda45e;" href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item">Liste des réservations</li>
            </ol>
        </nav>
    </div>


    <!-- Tableau de données liste reservations -->
    <div class="card shadow mb-4">

        <?php
        // Affiche un message de succès s'il existe et n'est pas vide
        if (!empty($_SESSION['message-success-global'])) {
        ?>
            <div class="alert alert-success" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
                <?= $_SESSION['message-success-global'] ?>
            </div>
        <?php
        }
        ?>

        <?php
        // Affiche un message d'erreur s'il existe et n'est pas vide
        if (!empty($_SESSION['message-erreur-global'])) {
        ?>
            <div class="alert alert-danger" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
                <?= $_SESSION['message-erreur-global'] ?>
            </div>
        <?php
        }
        ?>

        <div class="card-body">
            <div class="table-responsive">
                <?php
                // Récupérer la liste des réservations avec les informations du client et des accompagnateurs
                $liste_reservations = recuperer_liste_des_reservations();

                // Obtenez la date actuelle
                $currentDate = date('Y-m-d H:i:s'); // Format 'YYYY-MM-DD'

                // Vérifiez s'il y a des réservations
                if (!empty($liste_reservations)) {
                ?>
                    <!-- <div class="form-check">
                        <input type="checkbox" id="selectAllCheckbox">
                        <label class="form-check-label" for="selectAllCheckbox">Tout Sélectionner</label>
                    </div> -->

                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0" style="text-align: center;">
                        <thead>
                            <tr>
                                <!-- <th scope="col">Sélection</th> Nouvelle colonne pour la sélection -->
                                <th scope="col">N° de Réservation</th>
                                <th scope="col">Date & Heure</th>
                                <th scope="col">Client(e)</th>
                                <th scope="col">Montant Total (FCFA)</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($liste_reservations as $reservation) {
                                $liste_chambres_reservations = recuperer_liste_chambres_reservations($reservation['num_res']);
                                foreach ($liste_chambres_reservations as $chambre) {
                                    $liste_accompagnateurs_chambres_reservations[$chambre['num_chambre']] = recuperer_accompagnateurs_par_chambre_sur_une_reservation($reservation['num_res'], $chambre['num_chambre']);
                                }

                                //die(var_dump($liste_chambres_reservations))
                                //die(var_dump($liste_accompagnateurs_chambres_reservations));

                            ?>
                                <tr>
                                    <!-- <td><input type="checkbox" name="selection[]" value="<?= $reservation['num_res']; ?>"></td> Case à cocher pour la sélection -->
                                    <td>
                                        <?= $reservation['num_res'] ?>
                                        <br>
                                        <!-- Afficher le statut des réservations -->
                                        <?php if ($reservation['statut'] === 'En cours de validation') : ?>
                                            <span class="badge bg-warning ">
                                                En cours de validation
                                            </span>
                                        <?php elseif ($reservation['statut'] === 'Rejeter') : ?>
                                            <span class="badge bg-danger ">
                                                Rejeter
                                            </span>
                                        <?php elseif ($reservation['statut'] === 'Valider') : ?>
                                            <span class="badge bg-success ">
                                                Validé
                                            </span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary ">
                                                Statut inconnu
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($reservation['creer_le'])) ?></td>
                                    <td>
                                        <?php
                                        // Utilisation de la fonction pour récupérer les informations du client liées à une réservation spécifique
                                        $id_reservation_a_consulter =  $reservation['num_res'];

                                        $id_utilisateur = recuperer_id_utilisateur_par_num_res($id_reservation_a_consulter);

                                        $info_client_reservant = recuperer_user_par_son_id($id_utilisateur);

                                        if ($info_client_reservant) {
                                            // Afficher le nom et le prénom du client qui a effectué la réservation
                                            echo $info_client_reservant['nom'] . "  " . $info_client_reservant['prenom'];
                                        } else {
                                            echo "La réservation n'existe pas ou il y a eu un problème lors de la récupération des informations du client.";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= $reservation['prix_total'] ?>
                                    </td>

                                    <td>
                                        <div>

                                            <!-- Button Détails modal -->
                                            <i class="far fa-eye details-icon " style="margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#exampleModal-<?= $reservation['num_res']; ?>" title="Voir les détails">
                                            </i>

                                            <!-- Modal Détails-->
                                            <div class="modal modal-blur fade" id="exampleModal-<?= $reservation['num_res']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Détails de la réservation <?php echo $reservation['num_res']; ?></h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-borderless">
                                                                    <thead style="color: black;">
                                                                        <tr>
                                                                            <th scope="col">Chambres</th>
                                                                            <th scope="col">Photos</th>
                                                                            <th scope="col">Type</th>
                                                                            <th scope="col">Nuitée (FCFA)</th>
                                                                            <th scope="col">Date début</th>
                                                                            <th scope="col">Date fin</th>
                                                                            <th scope="col">Durée</th>
                                                                            <th scope="col">Coût (FCFA)</th>
                                                                            <th scope="col">Accompagnateurs</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($liste_chambres_reservations as $_chambre) {
                                                                            $typ_chambre = recuperer_type_chambre_pour_affichage($_chambre['num_chambre']);
                                                                            $photo_chambre = recuperer_photo_chambre_pour_affichage($_chambre['num_chambre']);
                                                                            $prix_chambre = recuperer_prix_chambre($typ_chambre);
                                                                            $deb_occ = date('d-m-Y H:i:s', strtotime($_chambre['deb_occ']));
                                                                            $fin_occ = date('d-m-Y H:i:s', strtotime($_chambre['fin_occ']));
                                                                            $dateDebut = new DateTime($deb_occ);
                                                                            $dateFin = new DateTime($fin_occ);
                                                                            $diff = $dateDebut->diff($dateFin);
                                                                            $jours = $diff->days + 1;
                                                                        ?>
                                                                            <tr>
                                                                                <th scope="row"><?= $_chambre['num_chambre'] ?></th>
                                                                                <td><?= $typ_chambre ?></td>
                                                                                <td>
                                                                                    <img src="<?= $photo_chambre == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.JPEG' : $photo_chambre ?>" alt="chambre" class=" img-fluid img-custom mx-auto d-block" width="50px">
                                                                                </td>
                                                                                <td><?= $prix_chambre['montant'] ?></td>
                                                                                <td><?= $deb_occ ?></td>
                                                                                <td><?= $fin_occ ?></td>
                                                                                <td><?= $jours . ' nuitée(s)' ?></td>
                                                                                <td><?= $_chambre['montant'] ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    if (!empty($liste_accompagnateurs_chambres_reservations[$_chambre['num_chambre']])) {
                                                                                        foreach ($liste_accompagnateurs_chambres_reservations[$_chambre['num_chambre']] as $accompagnateur) {
                                                                                    ?>
                                                                                            <span><?= $accompagnateur['nom_acc'] . ' (' . $accompagnateur['contact'] . ')<br>' ?></span>
                                                                                        <?php
                                                                                        }
                                                                                    } else {
                                                                                        ?>
                                                                                        <span>Aucun accompagnateur</span>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <!-- Formulaire de validation -->
                                                            <form action="<?= PATH_PROJECT ?>administrateur/reservations/traitement_validation_reservation" method="POST">
                                                                <input type="hidden" name="num_res" value="<?php echo $reservation['num_res']; ?>">
                                                                <button type="submit" class="btn btn-success"><i class="fas fa-calendar-check" title="Valider la réservation"></i></button>
                                                            </form>

                                                            <!-- Formulaire de validation -->
                                                            <form action="<?= PATH_PROJECT ?>administrateur/reservations/traitement_rejeter_reservation" method="POST">
                                                                <input type="hidden" name="num_res" value="<?php echo $reservation['num_res']; ?>">
                                                                <button type="submit" class="btn btn-danger"><i class="fas fa-calendar-minus" title="Rejeter la réservation"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <!-- Button Modifier modal -->
                                            <i class="far fa-edit modifier-icon" style="color: #d99727; margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#exampleModal1-<?= $reservation['num_res']; ?>" title="Modifier la réservation">
                                            </i>


                                            <!-- Modal Modifier -->
                                            <div class="modal modal-blur fade" id="exampleModal1-<?= $reservation['num_res']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                                    <div class="modal-content" id="container<?= $reservation['num_res']; ?>">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier la réservation <?php echo $reservation['num_res']; ?></h1>
                                                            <!-- Bouton pour ajouter un conteneur -->
                                                            <div class="col-md" style="justify-content: end; display: flex;">
                                                                <button type="button" class="btn btn-custom text-light" style="background-color: #cda45e;" id="ajouter-chambres">Ajouter une chambre</button>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="modification<?= $reservation['num_res']; ?>" data-endpoint="<?= PATH_PROJECT ?>administrateur/reservations/traitement_reservations">

                                                                <!-- Le champ email -->
                                                                <div class="col-md-12 mb-4" style="padding-left: 0px;">
                                                                    <label for="email"> Email du Client :
                                                                        <span class="text-danger">(*)</span>
                                                                    </label>

                                                                    <!-- Champ de sélection dynamique avec les adresses e-mail -->
                                                                    <select name="email" class="js-example-basic-single" style="width: 100%;">
                                                                        <option value=""></option>
                                                                        <?php foreach ($liste_clients as $client) : ?>
                                                                            <option <?= $client['email'] == $info_client_reservant['email'] ? 'selected' : ''  ?> value="<?= $client['email'] ?>"><?= $client['email'] ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <!-- Conteneur pour les champs de chambre dynamiques -->
                                                                <div id="champs-chambres-dynamiques-container">
                                                                    <!-- Les champs de chambre seront ajoutés ici en fonction des boutons "+" et "-" -->
                                                                </div>

                                                                <hr>

                                                                <?php
                                                                $l = sizeof($liste_chambres_reservations);
                                                                foreach ($liste_chambres_reservations as $i => $chambre_) {
                                                                    $typ_chambre = recuperer_type_chambre_pour_affichage($chambre_['num_chambre']);
                                                                ?>
                                                                    <div id="champs-chambres-dynamiques-container<?= $chambre_['num_chambre'] + 1 ?>">

                                                                        <!-- Le champ Numéro de chambre -->
                                                                        <div class="col-md-12 mb-3">
                                                                            <label for="num_chambre">Chambres :
                                                                                <span class="text-danger">(*)</span>
                                                                            </label>
                                                                            <select class="form-control chambre-select" id="num_chambre" name="chambre<?= $i + 1 ?>[num]" required>
                                                                                <option value="">Sélectionnez le numéro de chambre</option>

                                                                                <?php
                                                                                foreach ($liste_chambre as $chambre) {
                                                                                    if ($chambre['est_actif'] == 1 || ($chambre['est_actif'] == 0 && $chambre['num_chambre'] == $chambre_['num_chambre'])) {
                                                                                        $compared_value = $chambre_['num_chambre'] . '&' . $typ_chambre;
                                                                                        $value = $chambre['num_chambre'] . '&' . $chambre['lib_typ'];
                                                                                        $option_text = 'Chambre N°' . $chambre['num_chambre'] . ' - Type : ' . $chambre['lib_typ'];
                                                                                        //$prix_par_chambre = $chambre['pu'];
                                                                                        ///echo '<option value="' . $chambre['num_chambre'] . '&' . $chambre['lib_typ'] . '">' . $option_value . '</option>';
                                                                                ?>
                                                                                        <option value="<?= $value ?>" <?= $compared_value == $value ? 'selected' : '' ?>><?= $option_text ?></option>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>

                                                                        <?php
                                                                        $k = sizeof($liste_accompagnateurs_chambres_reservations[$chambre_['num_chambre']]);
                                                                        foreach ($liste_accompagnateurs_chambres_reservations[$chambre_['num_chambre']] as $j => $accompagnateur) {
                                                                        ?>
                                                                            <!-- Le(s) champ(s) nom et contact accompagnateur(s) anciennements ajoutés -->
                                                                            <div class="row">
                                                                                <!-- Le champ nom_acc -->
                                                                                <div class="col-md-6 mb-1">
                                                                                    <label for="modification-nom_acc_<?= $reservation['num_res'] ?>">
                                                                                        Nom de l'accompagnateur:
                                                                                    </label>
                                                                                    <input type="text" name="chambre<?= $i + 1 ?>[ACCS][acc<?= $j + 1 ?>][nom_acc]" id="modification-nom_acc_<?= $reservation['num_res'] ?>" class="form-control" value="<?= $accompagnateur['nom_acc'] ?>">
                                                                                </div>

                                                                                <!-- Le champ contact_acc -->
                                                                                <div class="col-md-5 mb-1">
                                                                                    <label for="modification-contact_acc">
                                                                                        Contact de l'accompagnateur:
                                                                                    </label>
                                                                                    <input type="text" name="chambre<?= $i + 1 ?>[ACCS][acc<?= $j + 1 ?>][contact_acc]" id="modification-contact_acc" class="form-control" value="<?= $accompagnateur['contact'] ?>">
                                                                                </div>

                                                                                <!-- Bouton pour retirer un accompagnateur anciennement ajouter -->
                                                                                <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 21px;">
                                                                                    <button type="button" class="btn btn-danger" onclick="supprimerAccompagnateur(this)">-</button>
                                                                                </div>

                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                        <!-- Le champ nom et contact nouveau accompagnateur -->
                                                                        <div class="row">
                                                                            <!-- Le champ nom_acc -->
                                                                            <div class="col-md-6 mb-1">
                                                                                <label for="modification-nom_acc-<?= $reservation['num_res']  ?>">
                                                                                    Nom de l'accompagnateur:
                                                                                </label>
                                                                                <input type="text" name="chambre<?= $i + 1 ?>[ACCS][acc<?= $k + 1 ?>][nom_acc]" id="modification-nom_acc-<?= $reservation['num_res'] ?>" class="form-control">
                                                                            </div>

                                                                            <!-- Le champ contact_acc -->
                                                                            <div class="col-md-5 mb-1">
                                                                                <label for="modification-contact_acc-<?= $reservation['num_res'] ?>">
                                                                                    Contact de l'accompagnateur:
                                                                                </label>
                                                                                <input type="text" name="chambre<?= $i + 1 ?>[ACCS][acc<?= $k + 1 ?>][contact_acc]" id="modification-contact_acc-<?= $reservation['num_res'] ?>" class="form-control">
                                                                            </div>

                                                                            <!-- Bouton pour ajouter un accompagnateur -->
                                                                            <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 21px;">
                                                                                <button type="button" id="ajouter-accompagnateur-btn<?= $chambre_['num_chambre'] + 1 ?>" class="btn btn-custom ajouter-accompagnateur-btn">+</button>
                                                                            </div>

                                                                            <!-- Conteneur pour les champs d'accompagnateur dynamiques -->
                                                                            <div id="champs-accompagnateur-dynamiques-container<?= $chambre_['num_chambre'] + 1 ?>">
                                                                                <!-- Les champs d'accompagnateur seront ajoutés ici en fonction des boutons "+" -->
                                                                            </div>
                                                                        </div>

                                                                        <!-- Le champ début et fin occupation -->
                                                                        <div class="row">
                                                                            <!-- Le champ date de début occupation -->
                                                                            <div class="col-md-6 mb-1">
                                                                                <label for="inscription-deb_occ-<?= $reservation['num_res'] ?>">
                                                                                    Début de séjour:
                                                                                    <span class="text-danger">(*)</span>
                                                                                </label>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="date" id="inscription-deb_occ-<?php echo $reservation['num_res']; ?>" name="chambre<?= $i + 1 ?>[deb_occ]" id="inscription-deb_occ" class="form-control" placeholder="Veuillez entrer votre date de début occupation" value="<?= date('Y-m-d', strtotime($chambre_['deb_occ'])) ?>" required>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Le champ date de fin occupation -->
                                                                            <div class="col-md-6 mb-1">
                                                                                <label for="inscription-fin_occ-<?php echo $reservation['num_res']; ?>-2">
                                                                                    Fin de séjour:
                                                                                    <span class="text-danger">(*)</span>
                                                                                </label>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="date" id="inscription-fin_occ-<?php echo $reservation['num_res']; ?>" name="chambre<?= $i + 1 ?>[fin_occ]" id="inscription-fin_occ" class="form-control" placeholder="Veuillez entrer votre date de fin occupation" value="<?= date('Y-m-d', strtotime($chambre_['fin_occ'])) ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Bouton pour supprimer un conteneur -->
                                                                        <div class="col-md-12 mb-2" style="justify-content: center; display: flex;">
                                                                            <button type="button" class="btn btn-danger" onclick="retirer_Chambre('champs-chambres-dynamiques-container<?= $chambre_['num_chambre'] + 1 ?>')" style="--bs-btn-color: #fff; --bs-btn-bg: #b30617; --bs-btn-border-color: #b30617;">Retirer cette chambre</button>
                                                                        </div>

                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                                <!-- </div> -->

                                                                <input type="hidden" name="editing" value="<?= $reservation['num_res'] ?>">

                                                                <hr>

                                                                <div class="col-md mb-1">
                                                                    <label for="password-<?php echo $reservation['num_res']; ?>">
                                                                        Mot de passe:
                                                                        <span class="text-danger">(*)</span>
                                                                    </label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="password" id="password-<?php echo $reservation['num_res']; ?>" name="password" class="form-control mb-2" placeholder="Veuillez entrez votre mot de passe utilisateur puis valider" id="">
                                                                    </div>
                                                                </div>

                                                                <div class="float-right" style="text-align: right;">
                                                                    <button type="reset" class="btn btn-danger">
                                                                        Annuler
                                                                    </button>
                                                                    <button type="submit" id="submitButton-<?= $reservation['num_res']; ?>" class="btn btn-success">
                                                                        <span>Mettre à jour</span>
                                                                        <span class="loader"></span>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Button supprimer modal -->
                                            <i class="far fa-trash-alt supprimer-icon" data-bs-toggle="modal" data-bs-target="#exampleModal2-<?= $reservation['num_res']; ?>" title="Supprimer la réservation" style="color: #7e0707;">
                                            </i>


                                            <!-- Modal supprimer -->
                                            <div class="modal fade" id="exampleModal2-<?= $reservation['num_res']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer la réservation <?php echo $reservation['num_res']; ?></h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= PATH_PROJECT ?>administrateur/reservations/liste-reservations/traitement_supprimer_reservation" method="post" enctype="multipart/form-data">
                                                                <!-- Début du formulaire de supression du reservation -->
                                                                <input type="hidden" name="reservation_id" value="<?php echo $reservation['num_res']; ?>">
                                                                <div class="form-group">
                                                                    <label for="passwordImput2-<?php echo $reservation['num_res']; ?>" class="col-12 col-form-label" style="color: #070b3a;">Veuillez entrer votre mot de passe pour supprimer la réservation</label>
                                                                    <input type="password" name="password" id="passwordImput2-<?php echo $reservation['num_res']; ?>" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="" required>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" name="supprimer" class="btn btn-primary">Valider</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>


                <?php
                } else {
                    // Aucune réservation n'a été trouvée, affichez le message en couleur noire
                ?>
                    <p style="color: black;">Aucune réservation n'a été trouvée!</p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>

<!-- FIN -->

<?php
foreach ($liste_reservations as $reservation) {
?>
    <!-- ajx -->

    <script>
        $(document).ready(function() {

            var $submitButton = $('#submitButton-<?= $reservation['num_res']; ?>');
            var $loader = $submitButton.find('.loader');

            $('#modification<?= $reservation['num_res']; ?>').submit(function(event) {
                event.preventDefault();

                $submitButton.attr('disabled', true);
                $loader.addClass('show');

                var endpointUrl = $(this).data('endpoint');
                var formData = $(this).serialize();

                $.ajax({
                    url: endpointUrl,
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        console.log('Réponse du serveur : ', response);

                        if (response.success) {
                            showAlert('success', 'Succès', response.message);
                            setTimeout(function() {
                                window.location.href = response.redirectUrl;
                            }, 1000);
                        } else {
                            showAlert('danger', 'Erreur', response.message);
                        }

                        $submitButton.attr('disabled', false);
                        $loader.removeClass('show');
                    },
                    error: function(xhr, status, error) {
                        console.log('Erreur lors de la requête AJAX : ' + error);
                        console.log('Réponse du serveur : ' + xhr.responseText);

                        showAlert('danger', 'Erreur', 'Une erreur s\'est produite lors du processus. Assurez-vous d\'avoir bien rempli le formulaire.');

                        $submitButton.attr('disabled', false);
                        $loader.removeClass('show');
                    }
                });
            });

            function showAlert(type, title, message) {
                var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                    '<strong>' + title + '</strong> ' + message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">' +
                    '</button>' +
                    '</div>';

                var $container = $('#container<?= $reservation['num_res']; ?>');

                $container.prepend(alertHtml);


                $('html, body').animate({
                    scrollTop: $('#alertContainer').offset().top
                }, 1000);
            }
        });
    </script>

    <?php
    $liste_chambres_reservations = recuperer_liste_chambres_reservations($reservation['num_res']);
    foreach ($liste_chambres_reservations as $i => $chambre_) {
    ?>
        <!-- edt -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ajouterAccompagnateurBtn = document.getElementById('ajouter-accompagnateur-btn<?= $chambre_['num_chambre'] + 1 ?>');

                var incAc = <?= $k + 2 ?>;
                // Écouteur d'événement pour le bouton "+" (ajouter accompagnateur)
                ajouterAccompagnateurBtn.addEventListener('click', function() {
                    // Ajoutez ici le code pour ajouter dynamiquement les champs d'accompagnateur
                    var container = document.getElementById('champs-accompagnateur-dynamiques-container<?= $chambre_['num_chambre'] + 1 ?>');
                    var nouvelAccompagnateur = document.createElement('div');
                    nouvelAccompagnateur.innerHTML = `
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label for="nouveau-nom_acc">Nom de l'accompagnateur:</label>
                            <input type="text" name="chambre${<?= $i + 1 ?>}[ACCS][acc${incAc}][nom_acc]" class="form-control">
                        </div>
                        <div class="col-md-5 mb-1">
                            <label for="nouveau-contact_acc">Contact de l'accompagnateur:</label>
                            <input type="text" name="chambre${<?= $i + 1 ?>}[ACCS][acc${incAc}][contact_acc]" class="form-control">
                        </div>

                        <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 21px;">
                            <button type="button" class="btn btn-danger" onclick="supprimerAccompagnateur(this)">-</button>
                        </div>
                    </div>
                    `;
                    container.appendChild(nouvelAccompagnateur);
                    incAc++
                });

            });

            // Fonction pour supprimer un champ d'accompagnateur
            function supprimerAccompagnateur(element) {
                var row = element.closest('.row');
                row.remove();
            }

            // Fonction pour retirer une chambre
            function retirer_Chambre(containerId) {
                // Récupérer le conteneur par son ID
                var container = document.getElementById(containerId);
                console.log(container)

                // Retirer le conteneur du DOM
                if (container) {
                    container.remove();
                }
            }
        </script>
<?php
    }
}
?>

<br>
<br>

<!-- Ajoutez cette balise script à la fin de la page -->
<script>
    $(document).ready(function() {
        $('.ajouter-accompagnateur').click(function() {
            var reservationId = $(this).data('reservation-id');
            var nouveauChamp = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nom de l'accompagnateur <span class="text-danger">(*)</span> </label>
                <input type="text" name="nom_acc[]" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Contact <span class="text-danger">(*)</span> : </label>
                <input type="text" name="contact_acc[]" class="form-control" required>
            </div>

            <div class="col-md-2 mb-3" style="display: flex; align-items: flex-end; justify-content: center;">
                <button type="button" class="btn btn-danger" onclick="supprimerAccompagnateur(this)" style="--bs-btn-color: #fff; --bs-btn-bg: #3b070c; --bs-btn-border-color: #3b070c; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #b30617; --bs-btn-hover-border-color: #b30617;">-</button>
            </div>
        </div>
    `;

            $('#nouveaux-accompagnateurs-' + reservationId).append(nouveauChamp);

            // Ajoutez une validation pour le champ "Contact de l'accompagnateur" ici
            $('#nouveaux-accompagnateurs-' + reservationId + ' input[name="contact_acc[]"]').on('input', function() {
                var contactAcc = $(this).val();

                // Utilisez une expression régulière pour vérifier si contact_acc contient uniquement des nombres
                var numbersOnlyRegex = /^[0-9]+$/;

                if (!numbersOnlyRegex.test(contactAcc)) {
                    alert('Le champ Contact de l\'accompagnateur doit contenir uniquement des nombres.');
                    $(this).val(''); // Effacez la saisie incorrecte
                }
            });
        });
    });

    // Function to remove an accompagnateur
    function supprimerAccompagnateur(button) {
        $(button).closest('.row').remove();
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ajouterChambreBtn = document.querySelector('#ajouter-chambres');

        var incCh = <?= $l ?>

        // Écouteur d'événement pour le bouton "Ajouter une chambre"
        ajouterChambreBtn.addEventListener('click', function(event) {
            // Ajoutez ici le code pour ajouter dynamiquement les champs pour une nouvelle chambre
            //console.log(event.target)
            if (event.target === ajouterChambreBtn) {
                incCh++
                var container = document.getElementById('champs-chambres-dynamiques-container');
                var nouvelleChambre = document.createElement('div');
                nouvelleChambre.innerHTML = `
                        <!-- Le champ Numéro de chambre -->
                        <div class="col-md-12 mb-3">
                            <label for="num_chambre">Chambres :
                                <span class="text-danger">(*)</span>
                            </label>
                            <select class="form-control num_chambre" name="chambre${incCh}[num]" required>
                                <option value="">Sélectionnez le numéro de chambre</option>
                                <?php
                                foreach ($liste_chambre as $chambre) {
                                    if ($chambre['est_actif'] == 1) {

                                        $value = $chambre['num_chambre'] . '&' . $chambre['lib_typ'];
                                        $option_text = 'Chambre N°' . $chambre['num_chambre'] . ' - Type : ' . $chambre['lib_typ'];
                                ?>
                                    <option value="<?= $value ?>"><?= $option_text ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Le champ nom et contact accompagnateur -->
                        <div class="row">
                            <!-- Le champ nom_acc -->
                            <div class="col-md-6 mb-1">
                                <label for="modification-nom_acc">Nom de l'accompagnateur:</label>
                                <input type="text" name="chambre${incCh}[ACCS][acc1][nom_acc]" class="form-control">
                            </div>

                            <!-- Le champ contact_acc -->
                            <div class="col-md-5 mb-1">
                                <label for="modification-contact_acc">Contact de l'accompagnateur:</label>
                                <input type="text" id="modification-contact_acc" name="chambre${incCh}[ACCS][acc1][contact_acc]" class="form-control">
                            </div>

                            <!-- Bouton pour ajouter un accompagnateur -->
                            <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 21px;">
                                <button type="button" class="btn btn-success ajouter-accompagnateur2-btn">+</button>
                            </div>

                            <!-- Conteneur pour les champs d'accompagnateur dynamiques -->
                            <div class="champs-accompagnateur2-dynamiques-container">
                                <!-- Les champs d'accompagnateur seront ajoutés ici en fonction des boutons "+" -->
                            </div>
                        </div>

                        <!-- Le champ début et fin occupation -->
                        <div class="row">
                            <!-- Le champ date de début occupation -->
                            <div class="col-md-6 mb-1">
                                <label for="inscription-deb_occ">Début de séjour:
                                    <span class="text-danger">(*)</span>
                                </label>
                                <div class="input-group mb-3">
                                    <input type="date" id="inscription-deb_occ" name="chambre${incCh}[deb_occ]" class="form-control" placeholder="Veuillez entrer votre date de début occupation" value="" required>
                                </div>
                            </div>

                            <!-- Le champ date de fin occupation -->
                            <div class="col-md-6 mb-1">
                                <label for="inscription-fin_occ">Fin de séjour:
                                    <span class="text-danger">(*)</span>
                                </label>
                                <div class="input-group mb-3">
                                    <input type="date" id="inscription-fin_occ" name="chambre${incCh}[fin_occ]" class="form-control" placeholder="Veuillez entrer votre date de fin occupation" value="" required>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-4">
                                <!-- <h5 style="font-weight: bold">Nombre total de jours : <span id="nombre_jour">0</span></h5>-->
                                <!-- <h5 style="font-weight: bold">Montant total : <span id="prix_total">0</span> </h5> -->
                            </div>

                            <!-- Bouton pour supprimer un conteneur -->
                            <div class="col-md-12 mb-3" style="justify-content: center; display: flex;">
                                <button type="button" class="btn btn-danger" onclick="retirerChambre(this)" style="--bs-btn-color: #fff; --bs-btn-bg: #b30617; --bs-btn-border-color: #b30617;">Retirer une chambre</button>
                            </div>
                        </div>
                        `;
                container.appendChild(nouvelleChambre);
            }

            var ajouterAccompagnateur2Btn = nouvelleChambre.querySelector('.ajouter-accompagnateur2-btn');
            //console.log(ajouterAccompagnateur2Btn)
            var incAcc = 2

            ajouterAccompagnateur2Btn.addEventListener('click', function(event) {
                // Ajoutez ici le code pour ajouter dynamiquement les champs d'accompagnateur
                //console.log(event.target === ajouterAccompagnateur2Btn)
                if (event.target === ajouterAccompagnateur2Btn) {
                    var container = nouvelleChambre.querySelector('.champs-accompagnateur2-dynamiques-container');
                    var nouvelAccompagnateur2 = document.createElement('div');
                    nouvelAccompagnateur2.innerHTML = `
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label for="nouveau-nom_acc">Nom de l'accompagnateur:</label>
                                    <input type="text" id="nouveau-nom_acc" name="chambre${incCh}[ACCS][acc${incAcc}][nom_acc]" class="form-control">
                                </div>
                                <div class="col-md-5 mb-1">
                                    <label for="nouveau-contact_acc">Contact de l'accompagnateur:</label>
                                    <input type="text" id="nouveau-contact_acc" name="chambre${incCh}[ACCS][acc${incAcc}][contact_acc]" class="form-control">
                                </div>

                                <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 21px;">
                                    <button type="button" class="btn btn-danger" onclick="supprimerAccompagnateur(this)">-</button>
                                </div>
                            </div>
                            `;
                    container.appendChild(nouvelAccompagnateur2);
                    incAcc++
                }
            });
        });
    });

    // Fonction pour retirer une chambre
    function retirerChambre(element) {
        var container = document.getElementById('champs-chambres-dynamiques-container');
        var dernierChambre = container.lastElementChild;
        if (dernierChambre) {
            container.removeChild(dernierChambre);
        }
    }
</script>


<?php
// Supprime les messages de succès et d'erreur globaux de la session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

include './app/commum/footer.php'

?>