<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside.php';

// Appeler la fonction pour récupérer la liste des clients
$liste_type_chambres = recuperer_type_chambres(); ?>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="text-decoration: none; color: #6c7293;" href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item active">Ajouter une chambre</li>
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

    <!-- Formulaire d'ajout de chambre-->
    <form action="<?= PATH_PROJECT ?>administrateur/chambres/ajout-chambre-traitement" method="post" class="user" enctype="multipart/form-data">
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


            <!-- Le champ nom de chambre -->
            <div class="col-sm-6 mb-3">
                <label for="nom_chb">
                    Nom de chambre :
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="nom_chb" id="nom_chb" class="form-control" placeholder="Veuiller entrer le nom de chambre" value="<?= (!empty($donnees["nom_chb"])) ? $donnees["nom_chb"] : ''; ?>">

                <?php if (isset($erreurs["nom_chb"]) && !empty($erreurs["nom_chb"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["nom_chb"]; ?>
                    </span>
                <?php } ?>
            </div>


            <!-- Le champ Libellé du type de chambre -->
            <div class="col-sm-6 mb-3 mb-sm-0" style="height: 12px;">
                <label for="libelle_type">
                    Type de chambre :
                    <span class="text-danger">(*)</span>
                </label>
                <div style="padding-left: 0; padding-right: 0;">
                    <select class="lib_typ form-control" id="libelle_type" name="lib_typ">
                        <option value="" disabled selected>Sélectionnez le type de chambre</option>

                        <?php foreach ($liste_type_chambres as $type_chambres) : ?>
                            <option><?= $type_chambres['type_chambre'] ?></option>
                        <?php endforeach; ?>

                    </select>
                    <?php if (!empty($erreurs["type_chambres"])) { ?>
                        <span class="text-danger">
                            <?php echo $erreurs["type_chambres"]; ?>
                        </span>
                    <?php } ?>
                </div>
            </div>



            <!-- Le bouton d'ajout -->
            <div class="col-sm-6 mt-5">
                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </div>

        </div>
    </form>
</div>
<!-- Fin du contenu de la page -->

<?php
// Supprimer les variables de session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global'], $_SESSION['erreurs-chambre'], $_SESSION['donnees-chambre']);

include './app/commum/footer.php';
?>