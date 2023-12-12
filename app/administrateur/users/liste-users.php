<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}
include './app/commum/header.php';

include './app/commum/aside.php';

$liste_utilisateur = recuperer_liste_utilisateurs();
?>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item active">Listes des utilisateurs</li>
            </ol>
        </nav>
    </div>

    <!-- Tableau de données liste utilisateurs -->
    <?php
    // Affichage du message de succès global s'il existe
    if (isset($_SESSION['message-success-global']) && !empty($_SESSION['message-success-global'])) {
    ?>
        <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
            <?= $_SESSION['message-success-global'] ?>
        </div>
    <?php
    }
    ?>

    <?php
    // Affichage du message d'erreur global s'il existe
    if (isset($_SESSION['message-erreur-global']) && !empty($_SESSION['message-erreur-global'])) {
    ?>
        <div class="alert alert-danger" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
            <?= $_SESSION['message-erreur-global'] ?>
        </div>
    <?php
    }
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- <style>
                .card-body {
                    background: url("<?= PATH_PROJECT ?>public/images/LOGO.png") center;
                    background-size: cover;
                }
            </style> -->
            <div class="table-responsive">
                <?php
                // Vérifie si la liste des utilisateurs existe et n'est pas vide
                if (isset($liste_utilisateur) && !empty($liste_utilisateur)) {
                ?>
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0" style="text-align:center;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom(s)</th>
                                <th>Profil</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Parcours de la liste des utilisateurs
                            foreach ($liste_utilisateur as $utilisateur) {
                            ?>
                                <tr>
                                    <td><?php echo $utilisateur['id']; ?></td>
                                    <td><?php echo $utilisateur['nom']; ?></td>
                                    <td><?php echo $utilisateur['prenom']; ?></td>
                                    <td><?php echo $utilisateur['profil']; ?></td>
                                    <td>
                                        <!-- Button de détails modal -->
                                        <i class="fas fa-eye details-icon " style="margin-right: 20px;" data-toggle="modal" data-target="#details-utilisateur-<?php echo $utilisateur['id']; ?>" title="Voir les détails">
                                        </i>

                                        <!-- lien bouton pour modifier et supprimer -->
                                        <a href="<?= PATH_PROJECT ?>administrateur/users/modifier-user/<?= $utilisateur['id'] ?>" style="margin-right: 20px;">
                                            <i class="far fa-edit modifier-icon" title="Modifier la chambre"></i>
                                        </a>

                                        <a href="#" data-toggle="modal" data-target="#supprimer-utilisateur-<?= $utilisateur["id"]; ?>">
                                            <i class="far fa-trash-alt supprimer-icon"></i>
                                        </a>

                                    </td>

                                    <!-- Modal de détails -->
                                    <div class="modal fade" id="details-utilisateur-<?php echo $utilisateur['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body text-center">
                                                    <p>
                                                        <img src="<?= $utilisateur['avatar'] == 'Aucune_image' ?  PATH_PROJECT . 'public/images/default_profil.JPG' : $utilisateur['avatar'] ?>" style="width: 130px;" alt="Profile" class="rounded-circle" class="img-fluid">
                                                    </p>
                                                    <p><strong>Téléphone : </strong><?php echo $utilisateur['telephone']; ?></p>
                                                    <p><strong>Email : </strong><?php echo $utilisateur['email']; ?></p>
                                                    <p><strong>Nom d'utilisateur : </strong><?php echo $utilisateur['nom_utilisateur']; ?></p>
                                                    <p><strong>Sexe : </strong><?php echo $utilisateur['sexe']; ?></p>
                                                    <p><strong>Créer le : </strong><?php echo $utilisateur['creer_le']; ?></p>
                                                    <p>
                                                        <button class="btn <?php echo ($utilisateur['est_actif'] == 1 && $utilisateur['est_supprimer'] == 0) ? 'btn-success' : (($utilisateur['est_actif'] == 0 && $utilisateur['est_supprimer'] == 1) ? 'btn-danger' : 'btn-warning'); ?> ">
                                                            <?php
                                                            // Affichage de l'état du compte de l'utilisateur
                                                            if ($utilisateur['est_actif'] == 1 && $utilisateur['est_supprimer'] == 1) {
                                                                echo 'Compte actif mais supprimé';
                                                            } elseif ($utilisateur['est_actif'] == 0 && $utilisateur['est_supprimer'] == 1) {
                                                                echo 'Compte supprimé';
                                                            } elseif ($utilisateur['est_actif'] == 1 && $utilisateur['est_supprimer'] == 0) {
                                                                echo 'Compte actif';
                                                            } else {
                                                                echo 'Compte désactivé';
                                                            }
                                                            ?>
                                                        </button>
                                                    </p>
                                                </div>
                                                <div class="modal-footer float-right">
                                                    <!-- Formulaire d'activation -->
                                                    <form action="<?= PATH_PROJECT ?>administrateur/users/traitement_activer_compte_user" method="POST">
                                                        <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id']; ?>">
                                                        <button type="submit" class="btn btn-success"><i class="fas fa-user-check" title="Activer le compte"></i></button>
                                                    </form>

                                                    <!-- Formulaire de désactivation -->
                                                    <form action="<?= PATH_PROJECT ?>administrateur/users/traitement_desactiver_compte_user" method="POST">
                                                        <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id']; ?>">
                                                        <button type="submit" class="btn btn-warning"><i class="fas fa-user-slash" title="Désactiver le compte"></i></button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal de suppression -->
                                    <div class="modal fade" id="supprimer-utilisateur-<?php echo $utilisateur['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Supprimer l'utilisateur <?php echo $utilisateur['nom_utilisateur']; ?></h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Etes-vous sûr de vouloir supprimer l'utilisateur <?php echo $utilisateur['nom_utilisateur']; ?> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="<?= PATH_PROJECT ?>administrateur/dashboard/traitement_suppression_compte_users" method="POST">
                                                        <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id']; ?>">
                                                        <button type="submit" class="btn btn-danger">Oui</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                                    </form>
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
                    echo "Aucun utilisateur n'a été trouvé !!!";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
// Suppression des messages de succès et d'erreur global de la session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

include './app/commum/footer.php'
?>