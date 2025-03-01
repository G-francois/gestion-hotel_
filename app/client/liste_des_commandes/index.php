<?php
if (!check_if_user_connected_client()) {
    header('location: ' . PATH_PROJECT . 'client/connexion/index');
    exit;
}

include('./app/commum/header_client.php');

?>

<style>
    .card-body {
        color: black;
    }
</style>
<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <!-- <div class="pagetitle"
             style="padding-top: 126px; padding-bottom: 12px; display: flex; justify-content: space-between;">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Liste des commandes</li>
                </ol>
            </nav>

            <a class="btn btn-primary"
               style="--bs-btn-color: #fff; --bs-btn-bg: #cda45e; --bs-btn-border-color: #000000; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #9d6b15; --bs-btn-hover-border-color: #000000;"
               href="<?= PATH_PROJECT . 'client/restaurant/commande' ?>">
                Faire une Commande
            </a>
        </div> -->

    <section id="hero4" class="d-flex align-items-center">
        <div class="container-fluid position-relative text-center text-lg-start aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
            <div class="row mt-5">
                <div class="col-lg-12 mt-5 mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                    <h1>Espace<span> Liste de commande repas</span></h1>

                    <a class="btn btn-primary"
                        style="--bs-btn-color: #fff; --bs-btn-bg: #cda45e; --bs-btn-border-color: #000000; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #9d6b15; --bs-btn-hover-border-color: #000000;"
                        href="<?= PATH_PROJECT . 'client/restaurant/commande' ?>">
                        <!-- Afficher le bouton de réservation ici -->
                        Faire une Commande
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- Tableau de données liste reservations -->
    <div class="card shadow mb-4">

        <?php
        // Affiche un message de succès s'il existe et n'est pas vide
        if (isset($_SESSION['message-success-global']) && !empty($_SESSION['message-success-global'])) {
        ?>
            <div class="alert alert-primary"
                style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
                <?= $_SESSION['message-success-global'] ?>
            </div>
        <?php
        }
        ?>

        <?php
        // Affiche un message d'erreur s'il existe et n'est pas vide
        if (isset($_SESSION['message-erreur-global']) && !empty($_SESSION['message-erreur-global'])) {
        ?>
            <div class="alert alert-danger"
                style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
                <?= $_SESSION['message-erreur-global'] ?>
            </div>
        <?php
        }
        ?>

        <div class="card-body" style="color: black;">
            <div class="table-responsive">
                <?php
                // Récupérer la liste des réservations avec les informations du client et des accompagnateurs

                // $liste_reservations = recuperer_liste_reservations($_SESSION['utilisateur_connecter_client']['id']);

                $clientConnecteID = $_SESSION['utilisateur_connecter_client']['id'];
                // die(var_dump($clientConnecteID));

                $liste_commandes_client = recuperer_liste_commandes_client($clientConnecteID);
                // die(var_dump($liste_commandes_client));

                if (!empty($liste_commandes_client)) {
                ?>
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0"
                        style="text-align: center;">
                        <thead>
                            <tr>
                                <th scope="col">Date & Heure</th>
                                <th scope="col">Numéro de Commande</th>
                                <th scope="col">Numéro de Chambre</th>
                                <th scope="col">Numéro de Réservation</th>
                                <th scope="col">Liste des Repas</th>
                                <th scope="col">Prix Unitaire</th>
                                <th scope="col">Prix Total</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Parcours de la liste des commandes
                            foreach ($liste_commandes_client as $commande) {
                                $num_cmd = $commande['num_cmd'];
                                // die(var_dump($num_cmd));

                                // Récupérer la liste des repas pour cette commande
                                $repas_commande = recuperer_liste_repas_par_commande($num_cmd);
                                // die(var_dump($repas_commande));

                            ?>
                                <tr>
                                    <td><?php echo $commande['creer_le']; ?></td>
                                    <td><?php echo $commande['num_cmd']; ?></td>
                                    <td><?php echo $commande['num_chambre']; ?></td>
                                    <td>
                                        <?php // Récupérer le numéro de reservation
                                        $donneesReservation = recuperer_donnee_reservation_par_son_id($commande['num_res']);

                                        $num_res = !empty($donneesReservation['num_res']) ? $donneesReservation['num_res'] : null;

                                        echo $num_res; ?>
                                    </td>
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
                                    <td>
                                        <?php
                                        if (empty($repas_commande)) {
                                            echo '---';
                                        } else {
                                            foreach ($repas_commande as $repas) {
                                                $info_repas = recuperer_info_repas($repas['cod_repas']);
                                                echo ($info_repas !== null)
                                                    ? number_format($info_repas['pu_repas'], 0, ',', ' ') . '<br>'
                                                    : '---<br>';
                                            }
                                        }
                                        ?>
                                    </td>


                                    <td>
                                        <?php echo number_format($commande['prix_total'], 0, ',', ' '); ?>
                                    </td>

                                    <td>
                                        <div style="display: flex; align-items: center;">

                                            <!-- Button Modifier modal -->
                                            <i class="far fa-edit modifier-icon" style="margin-right: 20px;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modifierModal-<?php echo $num_cmd ?>"
                                                data-num-cmd="<?php echo $num_cmd ?>"
                                                data-nom-repas="<?= htmlspecialchars(json_encode($repas_commande)) ?>"
                                                title="Modifier la commande ">
                                            </i>

                                            <!-- Modal Modifier-->
                                            <div class="modal fade" id="modifierModal-<?php echo $num_cmd ?>"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier
                                                                la commande <?php echo $num_cmd ?></h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Formulaire de modification de la commande -->
                                                            <form action="<?= PATH_PROJECT ?>client/liste_des_commandes/traitement-modifier-commande"
                                                                method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="commande_id"
                                                                    value="<?php echo $num_cmd ?>">
                                                                <input type="hidden" name="reservation_id"
                                                                    value="<?php echo $commande['num_res']; ?>">
                                                                <input type="hidden" name="num_chambre"
                                                                    value="<?php echo $commande['num_chambre']; ?>">


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
                                                                                <label for="modification-nom_repas-<?php echo $num_cmd; ?>-<?php echo $repas['cod_repas']; ?>">Nom
                                                                                    du repas:</label>
                                                                                <select class="form-control nom_repas"
                                                                                    id="modification-nom_repas-<?php echo $num_cmd; ?>-<?php echo $repas['cod_repas']; ?>"
                                                                                    name="nom_repas[]">
                                                                                    <option value="">Sélectionnez un
                                                                                        repas
                                                                                    </option>
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
                                                                                <label for="modification-pu_repas">Prix
                                                                                    unitaire:</label>
                                                                                <input type="text" name="pu_repas[]"
                                                                                    class="form-control pu_repas"
                                                                                    value="<?= $pu_repas ?>"
                                                                                    readonly>
                                                                            </div>

                                                                            <!-- Bouton pour retirer le champ de repas -->
                                                                            <div class="col-md-2 mb-3"
                                                                                style="display: flex; align-items: flex-end;">
                                                                                <button type="button"
                                                                                    class="btn btn-danger"
                                                                                    onclick="supprimerrepas(this)"
                                                                                    style="--bs-btn-color: #fff; --bs-btn-bg: #3b070c; --bs-btn-border-color: #3b070c; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #b30617; --bs-btn-hover-border-color: #b30617;">
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
                                                                <button type="button"
                                                                    class="btn btn-success ajouter-repas"
                                                                    data-repas-id="<?php echo $num_cmd; ?>">
                                                                    +
                                                                </button>

                                                                <!-- Champ de saisie de mot de passe -->
                                                                <div class="form-group">
                                                                    <label for="passwordInput-<?php echo $num_cmd; ?>">Mot
                                                                        de passe :</label>
                                                                    <input type="password" name="password"
                                                                        id="passwordInput-<?php echo $num_cmd; ?>"
                                                                        class="form-control"
                                                                        placeholder="Veuillez entrer votre mot de passe"
                                                                        required>
                                                                </div>


                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Fermer
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Enregistrer les modifications
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Button supprimer modal -->
                                            <i class="far fa-trash-alt supprimer-icon" data-bs-toggle="modal"
                                                data-bs-target="#supprimerModal-<?php echo $num_cmd ?>"
                                                data-nom-repas="<?php echo $info_repas['nom_repas']; ?>"
                                                data-pu-repas="<?php echo $info_repas['pu_repas']; ?>"
                                                title="Supprimer repas ">
                                            </i>

                                            <!-- Modal supprimer -->
                                            <div class="modal fade" id="supprimerModal-<?php echo $num_cmd ?>"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                Supprimer la commande <?php echo $num_cmd ?></h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= PATH_PROJECT ?>client/liste_des_commandes/traitement_supprimer_commande"
                                                                method="post" enctype="multipart/form-data">
                                                                <!-- Début du formulaire de supprimé commande -->
                                                                <input type="hidden" name="commande_id"
                                                                    value="<?php echo $num_cmd ?>">

                                                                <div class="form-group">
                                                                    <label for="passwordImput2-<?php echo $num_cmd; ?>"
                                                                        class="col-12 col-form-label"
                                                                        style="color: #070b3a;">Veuillez entrer votre
                                                                        mot de passe</label>
                                                                    <input type="password" name="password"
                                                                        id="passwordImput2-<?php echo $num_cmd; ?>"
                                                                        class="form-control"
                                                                        placeholder="Veuillez entrer votre mot de passe"
                                                                        value="">
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" name="supprimer"
                                                                        class="btn btn-primary">Valider
                                                                    </button>
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
                    <p style="color: black;">Aucun repas n'a été trouvé!</p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>

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
                <label for="modification-nom_repas-<?php echo $num_cmd; ?>-<?php echo $repas['cod_repas']; ?>">Nom du repas:</label>
                    <select class="form-control nom_repas" id="modification-nom_repas-<?php echo $num_cmd; ?>-<?php echo $repas['cod_repas']; ?>" name="nom_repas[]">
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
// Supprimer les variables de session
unset($_SESSION['donnees-chambre-solo-modifier'], $_SESSION['erreurs-chambre-solo-modifier'], $_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

include('./app/commum/footer_client_icm.php');
?>