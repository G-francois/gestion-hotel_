<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside.php';
?>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item active">Ajouter un repas</li>
            </ol>
        </nav>
    </div>

    <?php
    // Vérifier s'il y a un message de succès et s'il n'est pas vide
    if (!empty($_SESSION['message-success-global'])) {
    ?>
        <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
            <?= $_SESSION['message-success-global'] ?>
        </div>
    <?php
    }
    ?>

    <?php
    // Vérifier s'il y a un message d'erreur et s'il n'est pas vide
    if (!empty($_SESSION['message-erreur-global'])) {
    ?>
        <div class="alert alert-danger" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
            <?= $_SESSION['message-erreur-global'] ?>
        </div>
    <?php
    }
    ?>

    <!-- Formulaire d'ajout de repas -->
    <form action="<?= PATH_PROJECT ?>administrateur/repas/ajout-repas-traitement" method="post" class="user" enctype="multipart/form-data" >

        <div class="form-group row pt-5">

            <!-- Le champ photo -->
            <div class="col-sm-6 mb-3">
                <label class="form-label" for="customFile" style="color: gray;">
                    Importer une image
                    <span class="text-danger">(*)</span>
                </label>
                <input type="file" class="form-control" id="image" name="image" />

                <?php if (!empty($erreurs["image"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["image"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Champ pour le nom du repas -->
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="inscription-nom" class="col-sm-4 col-form-label">
                    Nom du repas :
                    <span class="text-danger">(*)</span>
                </label>

                <input type="text" name="nom_repas" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le nom du repas" value="<?= (!empty($donnees["nom_repas"])) ? $donnees["nom_repas"] : ''; ?>" required>

                <?php
                if (!empty($erreurs["nom_repas"])) {
                ?>
                    <span class="text-danger">
                        <?php echo $erreurs["nom_repas"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Champ pour les descriptions -->
            <div class="col-sm-6 mb-3">
                <label for="inscription-descriptions" class="col-sm-4 col-form-label">
                    Descriptions :
                    <span class="text-danger">(*)</span>
                </label>

                <input type="text" name="descriptions" id="inscription-descriptions" class="form-control" placeholder="Veuillez entrer la description" value="<?= (!empty($donnees["descriptions"])) ? $donnees["descriptions"] : ''; ?>" required>

                <?php if (!empty($erreurs["descriptions"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["descriptions"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Champ pour le prix unitaire -->
            <div class="col-sm-6 mb-3">
                <label for="inscription-prix" class="col-sm-4 col-form-label">
                    Prix unitaire :
                    <span class="text-danger">(*)</span>
                </label>

                <input type="number" name="pu_repas" id="inscription-prix" class="form-control" placeholder="Veuillez entrer le prix du repas" value="<?= (!empty($donnees["pu_repas"])) ? $donnees["pu_repas"] : ''; ?>" required>

                <?php if (!empty($erreurs["pu_repas"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["pu_repas"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le champ categorie -->
            <div class="col-sm-6 mb-3 mt-1">
                <label for="categorie">
                    Catégories :
                    <span class="text-danger">(*)</span>
                </label>
                <div style="padding-left: 0; padding-right: 0;">
                    <select class="categorie form-control" id="categorie" name="categorie">
                        <option value="" disabled selected>Sélectionnez la catégorie</option>
                        <option value="Entrees">Entrées</option>
                        <option value="Salades">Salades</option>
                        <option value="Specialites">Spécialités</option>
                    </select>
                    <?php if (!empty($erreurs["categorie"])) { ?>
                        <span class="text-danger">
                            <?php echo $erreurs["categorie"]; ?>
                        </span>
                    <?php } ?>
                </div>
            </div>

            <!-- Le bouton d'ajout -->
            <div class="col-md-6" style="padding-top: 37px;">
                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </div>
        </div>

    </form>
</div>

<!-- Fin du contenu de la page -->

<?php
// Supprimer les variables de session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global'], $_SESSION['erreurs-repas'], $_SESSION['donnees-repas']);

include './app/commum/footer.php'

?>