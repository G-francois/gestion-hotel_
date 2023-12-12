<?php
if (!check_if_user_connected_client()) {
    header('location: ' . PATH_PROJECT . 'client/connexion/index');
    exit;
}
$include_client_header = true;
include('./app/commum/header_.php');

?>

<style>
    .card-body {
        color: black;
    }
</style>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle" style="padding-top: 126px;">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Liste des messages</li>
            </ol>
        </nav>
    </div>

    <!-- Tableau de données liste reservations -->
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

        <div class="card-body" style="color: black;">
            <div class="table-responsive">
                <?php
                // Récupérer la liste des réservations avec les informations du client et des accompagnateurs
                $clientConnecteID = $_SESSION['utilisateur_connecter_client']['id'];

                $liste_messages = recuperer_liste_messages($clientConnecteID);

                if (!empty($liste_messages)) {
                ?>
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0" style="text-align: center;">
                        <thead>
                            <tr>
                                <th scope="col">Numéro de messages</th>
                                <th scope="col">Date & Heure</th>
                                <th scope="col">Nom du client</th>
                                <th scope="col">Type de sujet</th>
                                <th scope="col">Message</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Parcours de la liste des chambres
                            foreach ($liste_messages as $messages) {
                            ?>
                                <tr>
                                    <td><?php echo $messages['id']; ?></td>
                                    <td><?php echo $messages['creer_le']; ?></td>
                                    <td><?php echo $_SESSION['utilisateur_connecter_client']['nom_utilisateur']; ?></td>
                                    <td><?php echo $messages['type_sujet']; ?></td>
                                    <td><?php echo $messages['messages']; ?></td>

                                    <td>
                                        <div style="display: flex; align-items: center;">
                                            <!-- Button Modifier modal -->
                                            <i class="far fa-edit modifier-icon" style="margin-right: 20px;" data-bs-toggle="modal" data-bs-target="#modifierModal-<?php echo $messages['id'] ?>" data-num-messages="<?php echo $messages['id'] ?>" title="Modifier le message ">
                                            </i>

                                            <!-- Modal Modifier-->
                                            <div class="modal fade" id="modifierModal-<?php echo $messages['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier le message <?php echo $messages['id'] ?></h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Formulaire de modification de message -->
                                                            <form action="<?= PATH_PROJECT ?>client/liste_des_messages/traitement-modifier-messages" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="message_id" value="<?php echo $messages['id'] ?>">

                                                                <!-- Le champs sujet du message-->
                                                                <div class="form-group mt-3">
                                                                    <label for="inscription-subject">
                                                                        Sujet du message :
                                                                        <span class="text-danger">(*)</span>
                                                                    </label>
                                                                    <input type="text" class="form-control" name="subject" id="inscription-subject" placeholder="Veuillez entrer le sujet du message" value="<?= !empty($messages['type_sujet']) ? $messages['type_sujet'] : '' ?>" required />
                                                                    <?php if (isset($erreurs["subject"]) && !empty($erreurs["subject"])) { ?>
                                                                        <span class="text-danger">
                                                                            <?php echo $erreurs["subject"]; ?>
                                                                        </span>
                                                                    <?php } ?>
                                                                </div>

                                                                <!-- Le champ message -->
                                                                <div class="form-group mt-3">
                                                                    <textarea class="form-control" name="message" rows="8" required style="background-color: white;"> <?= !empty($messages['messages']) ? $messages['messages'] : '' ?> </textarea>
                                                                    <?php if (isset($erreurs["message"]) && !empty($erreurs["message"])) { ?>
                                                                        <span class="text-danger">
                                                                            <?php echo $erreurs["message"]; ?>
                                                                        </span>
                                                                    <?php } ?>
                                                                </div>


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
                                            <i class="far fa-trash-alt supprimer-icon" data-bs-toggle="modal" data-bs-target="#supprimerModal-<?php echo $messages['id'] ?>" title="Supprimer le message ">
                                            </i>

                                            <!-- Modal supprimer -->
                                            <div class="modal fade" id="supprimerModal-<?php echo $messages['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer la réservation <?php echo $messages['id'] ?></h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= PATH_PROJECT ?>client/liste_des_messages/traitement_supprimer_messages" method="post" enctype="multipart/form-data">
                                                                <!-- Début du formulaire de supprimé commande -->
                                                                <input type="hidden" name="message_id" value="<?php echo $messages['id'] ?>">

                                                                <div class="form-group">
                                                                    <label for="passwordImput" class="col-12 col-form-label" style="color: #070b3a;">Veuillez entrer votre mot de passe</label>
                                                                    <input type="password" name="password" id="passwordImput" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="" required>
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
                    <p style="color: black;">Aucun message(s) n'a été trouvé!</p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>

<!-- Ajoutez ce script JavaScript à la fin de votre page -->
<!-- <script>
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
</script> -->


<?php
// Supprimer les variables de session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

$include_icm_footer = true;
include('./app/commum/footer_.php');
?>