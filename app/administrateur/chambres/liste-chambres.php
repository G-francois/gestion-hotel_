<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside.php';

$liste_chambre = recuperer_liste_chambres();
?>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Liste des chambres</li>
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
                if (!empty($liste_chambre)) {
                ?>
                    <table class="table table-striped" id="dataTable"  style="text-align:center;">
                        <thead>
                            <tr>
                                <th>Numéro de chambre</th>
                                <th>Code type</th>
                                <th>Libellés</th>
                                <th>Prix Unitaire</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Parcours de la liste des chambres
                            foreach ($liste_chambre as $chambre) {
                            ?>
                                <tr>
                                    <td><?php echo $chambre['num_chambre']; ?></td>
                                    <td><?php echo $chambre['cod_typ']; ?></td>
                                    <td><?php echo $chambre['lib_typ']; ?></td>
                                    <td><?php echo $chambre['pu']; ?></td>
                                    <td>
                                        <!-- Button de détails modal -->
                                        <i class="fas fa-eye details-icon " style="margin-right: 20px;" data-toggle="modal" data-target="#details-chambre-<?php echo  $chambre["num_chambre"]; ?>" title="Voir les détails">
                                        </i>

                                        <!-- lien bouton pour modifier et supprimer -->
                                        <a href="<?= PATH_PROJECT ?>administrateur/chambres/modifier-chambre/<?= $chambre['num_chambre'] ?>" style="margin-right: 20px;">
                                            <i class="far fa-edit modifier-icon" title="Modifier la chambre"></i>
                                        </a>

                                        <a href="<?= PATH_PROJECT ?>administrateur/chambres/traitement-supprimer-chambre/<?= $chambre["num_chambre"]; ?>" data-toggle="modal" data-target="#supprimer-chambre-<?= $chambre["num_chambre"]; ?>">
                                            <i class="far fa-trash-alt supprimer-icon"></i>
                                        </a>

                                    </td>
                                    <!-- Modal de détails -->
                                    <div class="modal fade" id="details-chambre-<?php echo $chambre['num_chambre']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body" style="text-align: center;">
                                                    <p>
                                                        <img src="<?= $chambre['photos'] == 'Aucune_image' ?  PATH_PROJECT . 'public/images/default_profil.JPG' : $chambre['photos'] ?>" style="width: 250px;" alt="Profile"  class="img-fluid">
                                                    </p>
                                                    <p><strong>Descriptions : </strong> <br><?php echo $chambre['details']; ?></p>
                                                    <p><strong>Nombre de personne(s) : </strong> <?php echo $chambre['personnes']; ?></p>
                                                    <p><strong>Superficies : </strong> <?php echo $chambre['superficies']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal supprimer -->
                                    <div class="modal fade" id="supprimer-chambre-<?= $chambre["num_chambre"]; ?>" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
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