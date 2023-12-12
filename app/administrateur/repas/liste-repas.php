<?php
// Vérifie si l'repas est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'repas vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}
include './app/commum/header.php';

include './app/commum/aside.php';

$liste_repas = recuperer_liste_repas();
?>

<!-- Commencement du contenu de la page -->
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

    <!-- Tableau de données liste repas -->
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
                // Vérifie si la liste des repas existe et n'est pas vide
                if (isset($liste_repas) && !empty($liste_repas)) {
                ?>
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0" style="text-align: center;">
                        <thead>
                            <tr>
                                <th>Code type</th>
                                <th>Libellés</th>
                                <th>Prix</th>
                                <th>Catégorie</th>
                                <!-- <th>Statut du Repas</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Parcours de la liste des repas
                            foreach ($liste_repas as $repas) {
                            ?>
                                <tr>
                                    <td><?php echo $repas['cod_repas']; ?></td>
                                    <td><?php echo $repas['nom_repas']; ?></td>
                                    <td><?php echo $repas['pu_repas']; ?></td>
                                    <td><?php echo $repas['categorie']; ?></td>
                                    <!-- <td>
                                        <button class="btn <?php echo ($repas['est_actif'] == 1 && $repas['est_supprimer'] == 0) ? 'btn-success' : 'btn-danger'; ?> ">
                                            <?php
                                            if ($repas['est_actif'] == 1 && $repas['est_supprimer'] == 0) {
                                                echo 'Disponible';
                                            } else {
                                                echo 'Supprimé';
                                            }
                                            ?>
                                        </button>
                                    </td> -->
                                    <td>
                                        <!-- Button de détails modal -->
                                        <i class="fas fa-eye details-icon " style="margin-right: 20px;" data-toggle="modal" data-target="#details-repas-<?php echo $repas['cod_repas']; ?>" title="Voir les détails">
                                        </i>

                                        <!-- lien bouton pour modifier et supprimer -->
                                        <a href="<?= PATH_PROJECT ?>administrateur/repas/modifier-repas/<?= $repas['cod_repas'] ?>" style="margin-right: 20px;">
                                            <i class="far fa-edit modifier-icon" title="Modifier la chambre"></i>
                                        </a>

                                        <a href="#" data-toggle="modal" data-target="#supprimer-repas-<?= $repas["cod_repas"]; ?>">
                                            <i class="far fa-trash-alt supprimer-icon"></i>
                                        </a>
                                    </td>

                                    <!-- Modal de détails -->
                                    <div class="modal fade" id="details-repas-<?php echo $repas['cod_repas']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body" style="text-align: center;">
                                                    <p>
                                                        <img src="<?= $repas['photos'] == 'Aucune_image' ?  PATH_PROJECT . 'public/images/default_profil.JPG' : $repas['photos'] ?>" style="width: 250px;" alt="Profile" class="rounded-circle" class="img-fluid">
                                                    </p>
                                                    <p><strong>Descriptions : </strong> <br><?php echo $repas['descriptions']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal supprimer -->
                                    <div class="modal fade" id="supprimer-repas-<?= $repas["cod_repas"]; ?>" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Supprimer le repas <?= $repas["nom_repas"]; ?></h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Etes-vous sûr de vouloir supprimer le repas <?= $repas["nom_repas"]; ?> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= PATH_PROJECT ?>administrateur/repas/traitement-supprimer-repas/<?= $repas['cod_repas'] ?>" class="btn btn-danger">Oui</a>
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
                    // Affiche un message s'il n'y a aucun repas trouvé
                    echo "Aucun repas n'a été trouvé!";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
// Supprime les messages de succès et d'erreur globaux de la session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

include './app/commum/footer.php';
?>