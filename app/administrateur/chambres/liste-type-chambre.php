<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside.php';

$liste_type_chambre = recuperer_type_chambres();
?>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="text-decoration: none; color: #6c7293;" href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item active">Liste des types de chambre</li>
            </ol>
        </nav>
    </div>

    <!-- Tableau de données liste chambre(s)-->
    <div class="card shadow mb-4">
        <?php
        // Affiche un message de succès s'il existe et n'est pas vide
        if (!empty($_SESSION['message-success-global'])) {
        ?>
            <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
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
                // Vérifie si la liste des chambres existe et n'est pas vide
                if (!empty($liste_type_chambre)) {
                ?>
                    <table class="table table-striped" id="dataTable" style="text-align:center;">
                        <thead>
                            <tr>
                                <th>Nom du type</th>
                                <th>Détails</th>
                                <th>Superficies</th>
                                <th>Personnes</th>
                                <th>Prix Unitaire</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Parcours de la liste des chambres
                            foreach ($liste_type_chambre as $chambre) {
                            ?>
                                <tr>
                                    <td><?php echo $chambre['type_chambre']; ?></td>
                                    <td><?php echo $chambre['details']; ?></td>
                                    <td><?php echo $chambre['superficie']; ?></td>
                                    <td><?php echo $chambre['personnes']; ?></td>
                                    <td><?php echo $chambre['montant']; ?> FCFA</td>
                                    <td>

                                        <!-- lien bouton pour modifier et supprimer -->
                                        <a href="<?= PATH_PROJECT ?>administrateur/chambres/modifier-type-chambre/<?= $chambre['id'] ?>" style="margin-right: 20px; color:white; text-decoration :none; ">
                                            <i class="far fa-edit modifier-icon" title="Modifier la chambre"></i>
                                        </a>

                                        <a href="<?= PATH_PROJECT ?>administrateur/chambres/traitement-supprimer-chambre/<?= $chambre["id"]; ?>" data-bs-toggle="modal" data-bs-target="#supprimer-chambre-<?= $chambre["id"]; ?>" style="color:white; text-decoration :none; ">
                                            <i class="far fa-trash-alt supprimer-icon"></i>
                                        </a>

                                    </td>

                                    <!-- Modal supprimer -->
                                    <div class="modal fade" id="supprimer-chambre-<?= $chambre["id"]; ?>" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Supprimer la chambre <?= $chambre["id"]; ?></h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p style="font-size: larger;">Êtes-vous sûr de vouloir supprimer la chambre <?= $chambre["type_chambre"]; ?> ?</p>
                                                </div>
                                                <div class="modal-footer ">
                                                    <a href="<?= PATH_PROJECT ?>administrateur/chambres/traitement-supprimer-type-chambre/<?= $chambre["id"]; ?>" class="btn btn-danger">Oui</a>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin Modal supprimer -->
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    // Affiche un message s'il n'y a aucune chambre trouvée
                    echo "Aucune chambre n'a été trouvée !!!";
                }
                ?>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <?php
    // Supprime les messages de succès et d'erreur globaux de la session
    unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

    include './app/commum/footer.php';
    ?>