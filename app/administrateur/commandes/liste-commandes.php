<?php
if (!check_if_user_connected_admin()) {
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside.php';

$liste_chambre = recuperer_chambres();

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item active">Liste des repas</li>
            </ol>
        </nav>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <?php
        // Affiche un message de succès s'il existe et n'est pas vide
        if (isset($_SESSION['message-success-global']) && !empty($_SESSION['message-success-global'])) {
        ?>
            <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
                <?= $_SESSION['message-success-global'] ?>
            </div>
        <?php
        }
        ?>

        <?php
        // Affiche un message d'erreur s'il existe et n'est pas vide
        if (isset($_SESSION['message-erreur-global']) && !empty($_SESSION['message-erreur-global'])) {
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

                $liste_commandes_client = recuperer_liste_toutes_commandes();

                if (!empty($liste_commandes_client)) {
                ?>
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0" style="text-align: center;">
                        <thead>
                            <tr>
                                <th scope="col">Numéro de Commande</th>
                                <th scope="col">Date & Heure</th>
                                <th scope="col">Client(e)</th>
                                <th scope="col">Montant Total(FCFA)</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Parcours de la liste des chambres
                            foreach ($liste_commandes_client as $commande) {
                                $num_cmd = $commande['num_cmd'];
                                // Récupérer la liste des repas pour cette commande
                                $repas_commande = recuperer_liste_repas_par_commande($num_cmd);
                            ?>
                                <tr>
                                    <td><?php echo $commande['num_cmd']; ?></td>
                                    <td><?php echo $commande['creer_le']; ?></td>

                                    <td>
                                        <?php
                                        // Récupérer le numéro de reservation
                                        $donneesReservation = recuperer_donnee_reservation_par_num_chambre($commande['num_chambre']);
                                        // die(var_dump($donneesReservation));

                                        // Récupérer les informations d'une chambre
                                        $chambre = recuperer_chambre_par_son_num_chambre($commande['num_chambre']);

                                        $num_res = !empty($donneesReservation['num_res']) ? $donneesReservation['num_res'] : null;

                                        $donneesReservation2 = recuperer_donnees_reservation_par_num_res($num_res);

                                        $num_clt = !empty($donneesReservation2['num_clt']) ? $donneesReservation2['num_clt'] : null;

                                        $info_client_reservant = recuperer_user_par_son_id($num_clt);

                                        ?>

                                        <?php echo $nom_clt = !empty($info_client_reservant['nom']) ? $info_client_reservant['nom'] : null; ?>
                                        <?php echo $prenom_clt = !empty($info_client_reservant['prenom']) ? $info_client_reservant['prenom'] : null; ?>

                                    </td>

                                    <td>
                                        <?php echo $commande['prix_total']; ?>
                                    </td>

                                    <td>
                                        <!-- Afficher les boutons avec les styles en fonction du statut -->
                                        <div class="btn-group" role="group" aria-label="Actions de réservation">
                                            <?php if ($commande['statut'] === 'En cours de validation') : ?>
                                                <button type="button" class="btn btn-warning" style="color: #fff;">En cours de validation</button>
                                            <?php elseif ($commande['statut'] === 'Rejeter') : ?>
                                                <button type="button" class="btn btn-danger" style="color: #fff;">Rejeter</button>
                                            <?php elseif ($commande['statut'] === 'Valider') : ?>
                                                <button type="button" class="btn btn-success" style="color: #fff;">Validé</button>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-secondary">Statut inconnu</button>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td>
                                        <div style="display: flex; align-items: center;">

                                            <!-- Button Détails modal -->
                                            <i class="far fa-eye details-icon " style="margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#exampleModal-<?= $commande['num_cmd']; ?>" title="Voir les détails">
                                            </i>


                                            <!-- Modal Détails-->
                                            <div class="modal modal-blur fade" id="exampleModal-<?= $commande['num_cmd']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Détails de la commande <?php echo $commande['num_cmd']; ?></h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-borderless">
                                                                    <thead>
                                                                        <?php
                                                                        // Récupérer le numéro de reservation
                                                                        $donneesReservation = recuperer_donnee_reservation_par_num_chambre($commande['num_chambre']);
                                                                        // die(var_dump($donneesReservation));

                                                                        // Récupérer les informations d'une chambre
                                                                        $chambre = recuperer_chambre_par_son_num_chambre($commande['num_chambre']);

                                                                        $num_res = !empty($donneesReservation['num_res']) ? $donneesReservation['num_res'] : null;

                                                                        $donneesReservation2 = recuperer_donnees_reservation_par_num_res($num_res);

                                                                        // die(var_dump($num_res))
                                                                        ?>
                                                                        <tr>
                                                                            <th scope="col">Liste des Repas</th>
                                                                            <th scope="col">Prix Unitaire</th>
                                                                            <th scope="col">Numéro de Réservation</th>
                                                                            <th scope="col">Numéro de Chambres</th>
                                                                            <th scope="col">Type de chambre</th>
                                                                            <th scope="col">Date de début d'occupation</th>
                                                                            <th scope="col">Date de fin d'occupation</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <!-- Liste des repas commandé(s) -->
                                                                            <td>
                                                                                <?php
                                                                                if (empty($repas_commande)) {
                                                                                    echo '---';
                                                                                } else {
                                                                                    foreach ($repas_commande as $repas) {
                                                                                        $info_repas = recuperer_info_repas($repas['cod_repas']);
                                                                                        if ($info_repas !== null) {
                                                                                            echo $info_repas['nom_repas'] . '<br>';
                                                                                        } else {
                                                                                            echo 'Nom du repas non disponible<br>';
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <!-- Liste des prix unitaire de chaque repas commandé(s) -->
                                                                            <td>
                                                                                <?php

                                                                                if (empty($repas_commande)) {
                                                                                    echo '---';
                                                                                } else {
                                                                                    foreach ($repas_commande as $repas) {
                                                                                        $info_repas = recuperer_info_repas($repas['cod_repas']);
                                                                                        if ($info_repas !== null) {
                                                                                            echo $info_repas['pu_repas'] . '<br>';
                                                                                        } else {
                                                                                            echo 'Nom du repas non disponible<br>';
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <!-- Le numero de la reservation -->
                                                                            <td>
                                                                                <?php echo $num_res = !empty($donneesReservation['num_res']) ? $donneesReservation['num_res'] : null; ?>
                                                                            </td>

                                                                            <!-- Le numero de la chambre qui a fait la commande-->
                                                                            <td>
                                                                                <?php echo $commande['num_chambre']; ?>
                                                                            </td>
                                                                            <!-- Le type de la chambre qui a fait la commande-->
                                                                            <td>
                                                                                <?php echo $type_chambre = !empty($chambre['lib_typ']) ? $chambre['lib_typ'] : null; ?>
                                                                            </td>
                                                                            <!-- Le début d'occupation de la chambre qui a fait la commande-->
                                                                            <td>
                                                                                <?php echo $deb_occ_chambre = !empty($donneesReservation['deb_occ']) ? $donneesReservation['deb_occ'] : null; ?>
                                                                            </td>
                                                                            <!-- Le fin d'occupation de la chambre qui a fait la commande-->
                                                                            <td>
                                                                                <?php echo $fin_occ_chambre = !empty($donneesReservation['fin_occ']) ? $donneesReservation['fin_occ'] : null; ?>
                                                                            </td>

                                                                        </tr>
                                                                    </tbody>
                                                                </table>


                                                            </div>
                                                        </div>
                                                        <!-- <div class="modal-footer"> -->
                                                            <!-- Formulaire de validation -->
                                                            <!-- <form action="<?= PATH_PROJECT ?>administrateur/commandes/traitement-validation-commande" method="POST">
                                                                <input type="hidden" name="num_cmd" value="<?php echo $commande['num_cmd']; ?>">
                                                                <input type="hidden" name="num_res" value="<?php echo $commande['num_res']; ?>">
                                                                <button type="submit" class="btn btn-success"><i class="fas fa-calendar-check" title="Valider la commande"></i></button>
                                                            </form> -->

                                                            <!-- Formulaire de validation -->
                                                            <!-- <form action="<?= PATH_PROJECT ?>administrateur/commandes/traitement-rejeter-commande" method="POST">
                                                                <input type="hidden" name="num_res" value="<?php echo $commande['num_cmd']; ?>">
                                                                <button type="submit" class="btn btn-danger"><i class="fas fa-calendar-minus" title="Rejeter la commande"></i></button>
                                                            </form>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Button Modifier modal -->
                                            <i class="far fa-edit modifier-icon" style="margin-right: 20px;" data-bs-target="#modifierModal-<?php echo $num_cmd ?>" data-num-cmd="<?php echo $num_cmd ?>" data-nom-repas="<?= htmlspecialchars(json_encode($repas_commande)) ?>" title="Modifier la commande ">
                                            </i>


                                            <!-- Modal Modifier-->
                                            <div class="modal fade" id="modifierModal-<?php echo $num_cmd ?>" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier la commande <?php echo $num_cmd ?></h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Formulaire de modification de la commande -->
                                                            <form action="<?= PATH_PROJECT ?>administrateur/commandes/traitement-modifier-commande" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="commande_id" value="<?php echo $num_cmd ?>">
                                                                <input type="hidden" name="reservation_id" value="<?php echo $commande['num_res']; ?>">


                                                                <?php
                                                                // foreach ($liste_commandes_client as $commande) {
                                                                $num_cmd = $commande['num_cmd'];
                                                                $repas_commande = recuperer_liste_repas_par_commande($num_cmd);

                                                                // Vérifiez s'il y a des repas associés à cette commande
                                                                if (!empty($repas_commande)) {
                                                                ?>

                                                                    <?php
                                                                    foreach ($repas_commande as $repas) {
                                                                        $info_repas = recuperer_info_repas($repas['cod_repas']);
                                                                        if ($info_repas !== null) {
                                                                            $nom_repas = $info_repas['nom_repas'];
                                                                            $pu_repas = $info_repas['pu_repas'];
                                                                        } else {
                                                                            $nom_repas = '';
                                                                            $pu_repas = '';
                                                                        }
                                                                    ?>
                                                                        <div class="row">
                                                                            <!-- Le champ nom_repas -->
                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="modification-nom_repas">Nom du repas:</label>
                                                                                <select class="form-control nom_repas" id="modification-nom_repas" name="nom_repas[]">
                                                                                    <option value="">Sélectionnez un repas</option>
                                                                                    <?php
                                                                                    $liste_repas = recuperer_nom_prix_repas();

                                                                                    foreach ($liste_repas as $repas) {
                                                                                        $selected = ($repas['nom_repas'] == $nom_repas) ? 'selected' : '';
                                                                                        echo '<option value="' . $repas['cod_repas'] . '" data-prix="' . $repas['pu_repas'] . '" ' . $selected . '>' . $repas['nom_repas'] . '</option>';
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Le champ pu_repas -->
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="modification-pu_repas">Prix unitaire:</label>
                                                                                <input type="text" name="pu_repas[]" class="form-control pu_repas" value="<?= $pu_repas ?>" readonly>
                                                                            </div>

                                                                            <!-- Bouton pour retirer le champ de repas -->
                                                                            <div class="col-md-2 mb-3" style="display: flex; align-items: flex-end;">
                                                                                <button type="button" class="btn btn-danger" onclick="supprimerrepas(this)" style="--bs-btn-color: #fff; --bs-btn-bg: #3b070c; --bs-btn-border-color: #3b070c; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #b30617; --bs-btn-hover-border-color: #b30617;">
                                                                                    -
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                <?php
                                                                }
                                                                // }
                                                                ?>


                                                                <!-- Conteneur pour les champs de repas dynamiques -->
                                                                <div id="nouveaux-repas-<?php echo $num_cmd; ?>">
                                                                    <!-- Les champs de repas seront ajoutés ici en fonction des boutons "+" -->
                                                                </div>

                                                                <!-- Bouton pour ajouter un repas -->
                                                                <button type="button" class="btn btn-success ajouter-repas" data-repas-id="<?php echo $num_cmd; ?>">
                                                                    +
                                                                </button>

                                                                <!-- Champ de saisie de mot de passe -->
                                                                <div class="form-group">
                                                                    <label for="passwordImput">Mot de passe :</label>
                                                                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Veuillez entrer votre mot de passe" required>
                                                                </div>


                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <!-- Button supprimer modal -->
                                            <a href="#" data-toggle="modal" data-target="#supprimer-commande-<?php echo $num_cmd ?>">
                                                <i class="far fa-trash-alt supprimer-icon"></i>
                                            </a>

                                            <!-- Modal supprimer -->
                                            <div class="modal fade" id="supprimer-commande-<?php echo $num_cmd ?>" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Supprimer la commande <?php echo $num_cmd ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Etes-vous sûr de vouloir supprimer la commande <?php echo $num_cmd ?> ?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="<?= PATH_PROJECT ?>administrateur/commandes/traitement-supprimer-commande/<?php echo $num_cmd ?>" class="btn btn-danger">Oui</a>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fin Modal supprimer -->

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
                    <p style="color: black;">Aucun repas n'a été trouvé!</p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Ajoutez ce script JavaScript à la fin de votre page -->
<script>
    $(document).ready(function() {
        // Gestionnaire d'événement pour le changement de sélection
        $('.nom_repas').change(function() {
            var selectedOption = $(this).find('option:selected');
            var prixInput = $(this).closest('.row').find('.pu_repas');

            if (selectedOption.length > 0) {
                var prix = selectedOption.data('prix');
                prixInput.val(prix);
            } else {
                prixInput.val('');
            }
        });
    });



    $(document).ready(function() {
        $('.ajouter-repas').click(function() {
            var repasId = $(this).data('repas-id');
            var nouveauChamp = `
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom_repas">Nom du Repas : <span class="text-danger">(*)</span></label>
                    <select class="form-control nom_repas" id="nom_repas" name="nom_repas[]">
                        <option value="">Sélectionnez un repas</option>
                        <?php
                        $liste_repas = recuperer_nom_prix_repas();

                        foreach ($liste_repas as $repas) {
                            echo '<option value="' . $repas['cod_repas'] . '" data-prix="' . $repas['pu_repas'] . '">' . $repas['nom_repas'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="pu_repas">Prix du Repas :</label>
                    <input type="text" class="form-control pu_repas" placeholder="Le prix du repas sera automatiquement rempli" id="pu_repas" name="pu_repas[]">
                </div>

                <div class="col-md-2 mb-3" style="display: flex; align-items: flex-end; justify-content: center;">
                    <button type="button" class="btn btn-danger" onclick="supprimerrepas(this)" style="--bs-btn-color: #fff; --bs-btn-bg: #3b070c; --bs-btn-border-color: #3b070c; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #b30617; --bs-btn-hover-border-color: #b30617;">-</button>
                </div>
            </div>
            `;

            $('#nouveaux-repas-' + repasId).append(nouveauChamp);

            // Ajoutez le gestionnaire d'événements change pour mettre à jour le prix du repas
            $('#nouveaux-repas-' + repasId).find('.nom_repas').last().change(function() {
                updateMealPrice($(this));
            });
        });

        // Fonction pour mettre à jour le prix du repas en fonction de la sélection
        function updateMealPrice(selectElement) {
            var prixInput = selectElement.closest('.row').find('.pu_repas');
            var selectedOption = selectElement.find('option:selected');

            if (selectedOption.length > 0) {
                var prix = selectedOption.data('prix');
                prixInput.val(prix);
            } else {
                prixInput.val('');
            }
        }
    });

    // Fonction pour supprimer un repas
    function supprimerrepas(button) {
        $(button).closest('.row').remove();
    }
</script>




<?php
// Supprime les messages de succès et d'erreur globaux de la session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

include './app/commum/footer.php'

?>