<?php
// Vérifie si le repas est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige le repas vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}
include './app/commum/header.php';

include './app/commum/aside.php';

// $liste_repas = recuperer_liste_repas();

$data = [];

if (!empty($_SESSION['data'])) {
    $data = $_SESSION['data'];
}

$page = 1;

if (!empty($params[3])) {
    $page = $params[3];
}

$liste_repas_page = liste_repas($page);

if (!empty($data['categorie'])) {
    $liste_repas_page = liste_repas($page, $data['categorie']);
}



$categories = liste_categorie();

?>

<style>
    .repas {
        /* background-color: white; */
        border-radius: 20px;
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .repas img {
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
                <li class="breadcrumb-item active">Liste des repas</li>
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


    <form action="<?= PATH_PROJECT ?>administrateur/repas/traitement-repas" method="post" class="user" novalidate>
        <div class="row">
            <div class="row justify-content-end">
                <div class="col-3">
                    <div class="input-group mb-3">
                        <select class="form-select" aria-label="Sélectionner un type de catégorie" name="categorie" id="type_categorie_select">
                            <option value="">Tout Afficher</option>
                            <?php
                            if (!empty($categories)) {
                                foreach ($categories as $categorie) {
                            ?>
                                    <option <?php echo !empty($data['categorie']) && $data['categorie'] == $categorie ? 'selected' : '' ?> value="<?= $categorie ?>"><?= $categorie ?>
                                    </option>
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
                if (!empty($liste_repas_page)) {
                ?>
                    <?php
                    // Parcours de la liste des repas
                    foreach ($liste_repas_page as $repas) {
                    ?>

                        <div class="repas col-md-3">
                            <div class="card card-custom text-center" style="color: black;">
                                <div class="card-body card-body-custom">
                                    <img src="<?= $repas['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.JPEG' : $repas['photos'] ?>" alt="REPAS" class="rounded-circle img-fluid img-custom mx-auto d-block">
                                    <h5 class="mt-3 card-title"><?php echo $repas['nom_repas']; ?></h5>
                                    <p class="card-text"><?php echo $repas['categorie']; ?></p>
                                </div>

                                <div class="menu-actions">
                                    <!-- Button de détails modal -->
                                    <i class="fas fa-eye details-icon" style="color:green;" data-toggle="modal" data-target="#details-repas-<?php echo $repas['cod_repas']; ?>" title="Voir les détails"></i>

                                    <!-- lien bouton pour modifier et supprimer -->
                                    <a href="<?= PATH_PROJECT ?>administrateur/repas/modifier-repas/<?= $repas['cod_repas'] ?>" style="margin-right: 20px;">
                                        <i class="far fa-edit modifier-icon" style="color: #d99727;" title="Modifier le repas"></i>
                                    </a>

                                    <a href="#" data-toggle="modal" data-target="#supprimer-repas-<?= $repas["cod_repas"]; ?>">
                                        <i class="far fa-trash-alt supprimer-icon" style="color: #9f0808;"></i>
                                    </a>
                                </div>

                                <!-- Modal de détails -->
                                <div class="modal fade" id="details-repas-<?php echo $repas['cod_repas']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body" style="text-align: center; color:black;">
                                                <h5 class="mt-3"><strong><?php echo $repas['nom_repas']; ?></strong></h5>
                                                <p><strong>Descriptions : </strong> <?php echo $repas['descriptions']; ?></p>
                                                <p><strong>Catégorie : </strong> <?php echo $repas['categorie']; ?></p>
                                                <p><strong>Prix unitaire : </strong> <?php echo $repas['pu_repas']; ?> FCFA</p>
                                                <p><strong>État : </strong>
                                                    <button class="btn <?php echo ($repas['est_actif'] == 1 && $repas['est_supprimer'] == 0) ? 'btn-success' : 'btn-danger'; ?>">
                                                        <?php
                                                        if ($repas['est_actif'] == 1 && $repas['est_supprimer'] == 0) {
                                                            echo 'Disponible';
                                                        } else {
                                                            echo 'Supprimé';
                                                        }
                                                        ?>
                                                    </button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal supprimer -->
                                <div class="modal fade" id="supprimer-repas-<?= $repas["cod_repas"]; ?>" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="color: black;">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Supprimer le repas <?= $repas["nom_repas"]; ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Êtes-vous sûr de vouloir supprimer le repas <?= $repas["nom_repas"]; ?> ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?= PATH_PROJECT ?>administrateur/repas/traitement-supprimer-repas/<?= $repas['cod_repas'] ?>" class="btn btn-danger">Oui</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                            </div>
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
                        La page repas que vous souhaitez voir n'existe pas.
                        <a class="" href="<?= PATH_PROJECT ?>administrateur/repas/liste-repas" style="color: #cda45e;">Retour
                            vers la liste des repas</a>
                    </div>
                <?php
                }
                ?>


            </div>

            <!-- Affiche le bouton de réservation uniquement sur la dernière page -->
            <?php if (!empty($liste_repas_page) && count($liste_repas_page) < 8) : ?>
                <div class="row">
                    <div class="col-md-12 text-right mb-4">
                        <a class="btn btn-primary" href="<?= PATH_PROJECT . 'administrateur/repas/index' ?>">
                            <!-- Afficher le bouton de réservation ici -->
                            Ajoutez un repas
                        </a>
                    </div>
                </div>
            <?php endif; ?>


            <!-- Pagination -->
            <nav aria-label="Page navigation example" style="display: flex; justify-content: center;">
                <ul class="pagination">
                    <?php if ($page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="<?= PATH_PROJECT . 'administrateur/repas/liste-repas/' ?><?= $page - 1 ?>">Précédent</a>
                        </li>
                    <?php endif; ?>
                    <li class="page-item active"><a class="page-link" href="#"><?= $page ?></a></li>
                    <?php if (!empty($liste_repas_page) && count($liste_repas_page) == 8) : ?>
                        <li class="page-item"><a class="page-link" href="<?= PATH_PROJECT . 'administrateur/repas/liste-repas/' ?><?= $page + 1 ?>">Suivant</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </form>
</div>

<script>
    document.getElementById('type_categorie_select').addEventListener('change', function() {
        this.form.submit();
    });
</script>


<?php
// Supprime les messages de succès et d'erreur globaux de la session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global']);

include './app/commum/footer.php';
?>