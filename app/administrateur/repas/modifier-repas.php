<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}
include './app/commum/header.php';

include './app/commum/aside.php';

$cod_repas = "";

$repas = array();

// Vérifie si le paramètre contenant le numéro du repas est présent
if (!empty($params[3])) {
    // Récupère les informations du repas à partir de son code
    $repas = recuperer_repas_par_son_code_repas($params[3]);
}

?>
<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/repas/liste-repas">Liste des repas</a></li>
                <li class="breadcrumb-item active">Modifier repas</li>
            </ol>
        </nav>
    </div>

    <?php
    // Vérifie s'il y a un message de succès global à afficher
    if (isset($_SESSION['message-success-global']) && !empty($_SESSION['message-success-global'])) {
    ?>
        <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
            <?= $_SESSION['message-success-global'] ?>
        </div>
    <?php
    }
    ?>

    <?php
    // Vérifie s'il y a un message d'erreur global à afficher
    if (isset($_SESSION['message-erreur-global']) && !empty($_SESSION['message-erreur-global'])) {
    ?>
        <div class="alert alert-danger" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
            <?= $_SESSION['message-erreur-global'] ?>
        </div>
    <?php
    }
    ?>

    <section class="content">
        <?php if (empty($repas)) { ?>

            <!-- Affiche un message d'erreur si le repas n'existe pas -->
            <div class="alert alert-danger" role="alert">
                Le repas que vous souhaitez modifier n'existe pas.
                <a class="btn btn-default" href="?requete=liste-repas">Retour vers la liste des repas</a>
            </div>

        <?php } else { ?>

            <?php
            if (isset($_SESSION['modification-photo-erreur']) && !empty($_SESSION['modification-photo-erreur'])) {
            ?>
                <div class="alert alert-primary" style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
                    <?= $_SESSION['modification-photo-erreur'] ?>
                </div>
            <?php
            }
            ?>

            <?php
            if (isset($_SESSION['suppression-photo-erreurs']) && !empty($_SESSION['suppression-photo-erreurs'])) {
            ?>
                <div class="alert alert-primary" style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
                    <?= $_SESSION['suppression-photo-erreurs'] ?>
                </div>
            <?php
            }
            ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm zoom-effect-container">
                        <img class="bd-placeholder-img card-img-top zoom-effect" width="auto" height="auto" src="<?= $repas['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $repas['photos'] ?>" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
                    </div>

                    <!-- Formulaire de la mise à jour photo -->
                    <form action="<?= PATH_PROJECT . "administrateur/repas/traitement_photo" ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="categorie" value="<?= !empty($repas['categorie']) ? $repas['categorie'] : '' ?>">
                        <div class="row" style="text-align: center; display:flex;">
                            <div class="col-sm-9 text-secondary">
                                <label class="form-label" for="customFile" style="color: gray;">Changer la photo du repas</label>
                                <input type="file" class="form-control" id="image" name="image" />
                            </div>

                            <div class="text-center col-sm-3" style="justify-content: center; margin-top: 31px;">
                                <!-- Bouton du Modal mettre à jour -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal0" style="font-size: revert; padding: 8px;">Modifier</button>

                                <div class="col-md-8 col-lg-12">
                                    <div class="text-center" style="color: #070b3a;">
                                        <!-- Modal du bouton mettre à jour -->
                                        <div class="modal fade" id="modal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Mettre à jour la photo du repas <?php echo $repas['cod_repas']; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <label for="MP" class="col-12 col-form-label" style="color: #070b3a;">Veuiller entrer votre mot de passe pour modifier la photo. </label>
                                                            <br>
                                                            <div class="col-md-8 col-lg-12">
                                                                <input type="password" id="MP" name="password" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                        <button type="submit" name="change_photo" class="btn btn-primary">Valider</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Formulaire de la suppression photo -->
                    <form action="<?= PATH_PROJECT . "administrateur/repas/traitement_suppression_photo"  ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>" method="post" enctype="multipart/form-data" style="display: flex; justify-content: center; align-items: center;">
                        <div class="row">
                            <!-- Bouton du Modal supprimer -->
                            <button type="reset" class="btn btn-primary mt-4" data-toggle="modal" data-target="#modal1"><i class="fa fa-trash"></i> Supprimer</button>

                            <div class="col-md-8 col-lg-12">
                                <div class="text-center" style="color: #070b3a;">
                                    <!-- Modal du bouton supprimer -->
                                    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Supprimer la photo du repas <?php echo $repas['cod_repas']; ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <label for="MP" class="col-12 col-form-label" style="color: #070b3a;">Veuiller entrer votre mot de passe pour supprimer la photo. </label>
                                                        <br>
                                                        <div class="col-md-8 col-lg-12">
                                                            <input type="password" id="MP" name="password" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                    <button type="submit" name="supprimer_photo" class="btn btn-primary">Valider</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-8">
                    <!-- Affiche le formulaire de modification du repas -->
                    <form action="<?= PATH_PROJECT . "administrateur/repas/modifier-repas-traitement" ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>" method="post" class="user" novalidate>
                        <div class="form-group row pt-5">
                            <!-- Champ pour le nom du repas -->
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="inscription-nom" class="col-sm-12 col-form-label">
                                    Nom du repas :
                                    <span class="text-danger">(*)</span>
                                </label>

                                <input type="text" class="form-control" name="nom_repas" id="inscription-nom" placeholder="Veuillez entrer le nom du repas" value="<?= (isset($_POST["nom_repas"]) && !empty($_POST["nom_repas"])) ? $_POST["nom_repas"] : $repas["nom_repas"]; ?>" required>

                                <?php
                                if (isset($erreurs["nom_repas"]) && !empty($erreurs["nom_repas"])) { ?>
                                    <span class="text-danger">
                                        <?php echo $erreurs["nom_repas"]; ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <!-- Champ pour la descriptions -->
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="inscription-descriptions" class="col-sm-12 col-form-label">
                                    Descriptions :
                                    <span class="text-danger">(*)</span>
                                </label>

                                <textarea class="form-control" name="descriptions" id="inscription-descriptions" placeholder="Veuillez entrer la description" required><?= (!empty($donnees_repas_modifier["descriptions"])) ? $donnees_repas_modifier["descriptions"] : $repas["descriptions"]; ?></textarea>
                                    <?php if (isset($erreurs["descriptions"]) && !empty($erreurs["descriptions"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["descriptions"]; ?>
                                        </span>
                                    <?php } ?>

                                <?php
                                if (isset($erreurs["descriptions"]) && !empty($erreurs["descriptions"])) { ?>
                                    <span class="text-danger">
                                        <?php echo $erreurs["descriptions"]; ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <!-- Champ pour le prix unitaire -->
                            <div class="col-sm-6">
                                <label for="inscription-prix" class="col-sm-12 col-form-label">
                                    Prix unitaire :
                                    <span class="text-danger">(*)</span>
                                </label>
                                <input type="number" class="form-control" name="pu_repas" id="inscription-prix" placeholder="Veuillez entrer le prix du repas" value="<?= (isset($_POST["pu_repas"]) && !empty($_POST["pu_repas"])) ? $_POST["pu_repas"] : $repas["pu_repas"]; ?>" required>

                                <?php if (isset($erreurs["pu_repas"]) && !empty($erreurs["pu_repas"])) { ?>
                                    <span class="text-danger">
                                        <?php echo $erreurs["pu_repas"]; ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <!-- Le champ categorie -->
                            <div class="col-sm-6 mb-3">
                                <label for="inscription-categorie" class="col-sm-12 col-form-label">
                                    Catégorie:
                                    <span class="text-danger">(*)</span>
                                </label>
                                <select class="form-control" name="categorie" id="inscription-categorie" required>
                                    <?php
                                    $optionsLibelle = array("Entrees", "Specialites", "Salades");
                                    $selectedValue = (!empty($donnees_repas_modifier["categorie"])) ? $donnees_repas_modifier["categorie"] : $repas["categorie"];
                                    // Ajoute les options du menu déroulant
                                    foreach ($optionsLibelle as $option) {
                                        $selected = ($selectedValue === $option) ? "selected" : "";
                                    ?>
                                        <option value="<?= $option ?>" <?= $selected ?>><?= $option ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <?php if (isset($erreurs["categorie"]) && !empty($erreurs["categorie"])) { ?>
                                    <span class="text-danger">
                                        <?= $erreurs["categorie"]; ?>
                                    </span>
                                <?php } ?>
                            </div>
                            <!-- Le bouton modifier -->
                            <div class="col-sm-12 mb-3" style="margin-top: 35px;">
                                <input type="submit" value="Modifier" class="btn btn-primary btn-block">
                            </div>
                        </div>
                    </form>
                    <!-- Fin du formulaire -->
                </div>
            </div>
        <?php } ?>
    </section>
</div>

<?php
// Supprimer les variables de session
unset($_SESSION['modification-photo-erreur'], $_SESSION['suppression-photo-erreurs'], $_SESSION['message-success-global'], $_SESSION['message-erreur-global'], $_SESSION['erreurs-repas-modifier'], $_SESSION['donnees-repas-modifier']);

include './app/commum/footer.php'

?>