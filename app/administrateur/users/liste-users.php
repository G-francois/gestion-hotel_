<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}
include './app/commum/header.php';

include './app/commum/aside.php';

// $liste_utilisateur = recuperer_liste_utilisateurs();

if (!empty($_SESSION['data'])) {
    $data = $_SESSION['data'];
}

$page = 1;

if (!empty($params[3])) {
    $page = $params[3];
}

$liste_utilisateurs_page = liste_utilisateurs($page);

if (!empty($data['profil'])) {
    $liste_utilisateurs_page = liste_utilisateurs($page, $data['profil']);
}

$profiles = liste_profiles();

?>

<style>
    .users {
        /* background-color: white; */
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .users img {
        width: 200px;
        height: 200px;
        border: 5px solid rgba(255, 255, 255, 0.2);
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
                <li class="breadcrumb-item active">Liste des utilisateurs</li>
            </ol>
        </nav>
    </div>

    <!-- Tableau de données liste utilisateurs -->
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

    <form action="<?= PATH_PROJECT ?>administrateur/users/traitement-users" method="post" class="user" style="color: black;" novalidate>
        <div class="row">
            <div class="row justify-content-end">
                <div class="col-3">
                    <div class="input-group mb-3">
                        <select class="form-select" aria-label="Sélectionner un type de profil" name="profil" id="type_profiles_select">
                            <option value="">Tout Afficher</option>
                            <?php
                            if (!empty($profiles)) {
                                foreach ($profiles as $profil) {
                            ?>
                                    <option <?= !empty($data['profil']) && $data['profil'] == $profil ? 'selected' : '' ?> value="<?= $profil ?>"><?= $profil ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <?php
                // Vérifie si la liste des repas existe et n'est pas vide
                if (!empty($liste_utilisateurs_page)) {
                ?>
                    <?php
                    // Parcours de la liste des repas
                    foreach ($liste_utilisateurs_page as $utilisateur) {
                    ?>

                        <div class="users col-md-3">
                            <div class="card card-custom text-center" style="color: black;">
                                <div class="card-body card-body-custom">
                                    <img src="<?= $utilisateur['avatar'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_profil.JPG' : $utilisateur['avatar'] ?>" class="rounded-circle img-fluid img-custom mx-auto">
                                    <div>
                                        <h5 class="mt-3 card-title"><?php echo $utilisateur['nom']; ?> <?php echo $utilisateur['prenom']; ?></h5>
                                        <p class="card-text"><?php echo $utilisateur['email']; ?></p>
                                        <p class="card-text"><?php echo $utilisateur['profil']; ?></p>
                                    </div>
                                </div>

                                <div class="menu-actions">
                                    <!-- Button de détails modal -->
                                    <i class="fas fa-eye details-icon " style=" color:green; margin-right: 20px;"  data-toggle="modal" data-target="#details-utilisateur-<?php echo $utilisateur['id']; ?>" title="Voir les détails">
                                    </i>

                                    <!-- lien bouton pour modifier et supprimer -->
                                    <a href="<?= PATH_PROJECT ?>administrateur/users/modifier-user/<?= $utilisateur['id'] ?>" style="color: #d99727; margin-right: 20px;">
                                        <i class="far fa-edit modifier-icon" title="Modifier utilisateur"></i>
                                    </a>

                                    <a href="#" data-toggle="modal" data-target="#supprimer-utilisateur-<?= $utilisateur["id"]; ?>" style="color: #7e0707;">
                                        <i class="far fa-trash-alt supprimer-icon"></i>
                                    </a>

                                </div>
                            </div>



                            <!-- Modal de détails -->
                            <div class="modal fade" id="details-utilisateur-<?php echo $utilisateur['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content" style="color: black;">
                                        <div class="modal-body text-center">
                                            <p><strong>Nom d'utilisateur : </strong><?php echo $utilisateur['nom_utilisateur']; ?></p>
                                            <p><strong>Sexe : </strong><?php echo $utilisateur['sexe']; ?></p>
                                            <p><strong>Téléphone : </strong><?php echo $utilisateur['telephone']; ?></p>
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
                                            <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <?php echo $utilisateur['nom_utilisateur']; ?> ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="<?= PATH_PROJECT ?>administrateur/users/traitement_suppression_compte_users" method="POST">
                                                <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur['id']; ?>">
                                                <button type="submit" class="btn btn-danger">Oui</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    <?php
                    }
                    ?>


                <?php
                } else {
                ?>
                    <!-- Affiche un message d'erreur si la chambre n'existe pas -->
                    <div style="color: white; margin-bottom: 210px;">
                        La page utilisateur que vous souhaitez voir n'existe pas.
                        <a class="" href="<?= PATH_PROJECT ?>administrateur/users/liste-users" style="color: #cda45e;">Retour
                            vers la liste des utilisateurs</a>
                    </div>
                <?php
                }
                ?>


            </div>

            <!-- Affiche le bouton de réservation uniquement sur la dernière page -->
            <?php if (!empty($liste_utilisateurs_page) && count($liste_utilisateurs_page) < 8) : ?>
                <div class="row">
                    <div class="col-md-12 text-right mb-4">
                        <a class="btn btn-primary" href="<?= PATH_PROJECT . 'administrateur/users/index' ?>">
                            Ajoutez un utilisateur
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Pagination -->
            <nav aria-label="Page navigation example" style="display: flex; justify-content: center;">
                <ul class="pagination">
                    <?php if ($page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="<?= PATH_PROJECT . 'administrateur/users/liste-users/' ?><?= $page - 1 ?>">Précédent</a>
                        </li>
                    <?php endif; ?>
                    <li class="page-item active"><a class="page-link" href="#"><?= $page ?></a></li>
                    <?php if (!empty($liste_utilisateurs_page) && count($liste_utilisateurs_page) == 8) : ?>
                        <li class="page-item"><a class="page-link" href="<?= PATH_PROJECT . 'administrateur/users/liste-users/' ?><?= $page + 1 ?>">Suivant</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </form>
</div>

<script>
    document.getElementById('type_profiles_select').addEventListener('change', function() {
        this.form.submit();
    });
</script>


<?php
// Suppression des messages de succès et d'erreur global de la session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

include './app/commum/footer.php'
?>