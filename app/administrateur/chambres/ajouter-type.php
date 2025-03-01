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
$liste_type_chambre = recuperer_type_chambres(); ?>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="text-decoration: none; color: #6c7293;" href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item active">Ajouter un type chambre</li>
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

    <!-- Formulaire d'ajout de type chambre-->
    <form action="<?= PATH_PROJECT ?>administrateur/chambres/ajout-type-traitement" method="post" class="user" enctype="multipart/form-data">
        <div class="form-group row pt-5">
            <!-- Le champ nom type-->
            <div class="col-sm-6 mb-3">
                <label for="type_chambre">
                    Nom type :
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="type_chambre" id="type_chambre" class="form-control" placeholder="Entrer le nom du type" value="<?= (!empty($donnees["type_chambre"])) ? $donnees["type_chambre"] : ''; ?>" required>
                <?php if (!empty($erreurs["type_chambre"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["type_chambre"]; ?>
                    </span>
                <?php } ?>
            </div>


            <!-- Le champ details_chambre -->
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="details_chambre">
                    Informations :
                    <span class="text-danger">(*)</span>
                </label>
                <textarea name="details_chambre" id="details_chambre" class="form-control" placeholder="Le détail de la chambre " value="<?= (!empty($donnees["details_chambre"])) ? $donnees["details_chambre"] : ''; ?>" required></textarea>
                <?php if (!empty($erreurs["details_chambre"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["details_chambre"]; ?>
                    </span>
                <?php } ?>
            </div>


            <!-- Le champ details_personne_chambre -->
            <div class="col-sm-6 mt-3 mb-sm-0">
                <label for="details_personne_chambre">
                    Nombre de personne(s):
                    <span class="text-danger">(*)</span>
                </label>
                <input type="number" name="details_personne_chambre" id="details_personne_chambre" class="form-control" placeholder="Le nombre de pesonne(s)" value="<?= (!empty($donnees["details_personne_chambre"])) ? $donnees["details_personne_chambre"] : ''; ?>" required>

                <?php if (!empty($erreurs["details_personne_chambre"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["details_personne_chambre"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le champ details_superficie_chambre -->
            <div class="col-sm-6 mt-3">
                <label for="details_superficie_chambre">
                    Superficie:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="details_superficie_chambre" id="details_superficie_chambre" class="form-control" placeholder="La superficie " value="<?= (!empty($donnees["details_superficie_chambre"])) ? $donnees["details_superficie_chambre"] : ''; ?>" required>

                <?php if (!empty($erreurs["details_superficie_chambre"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["details_superficie_chambre"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le champ Prix unitaire -->
            <div class="col-sm-6 mt-3">
                <label for="prix_unitaire">
                    Prix unitaire :
                    <span class="text-danger">(*)</span>
                </label>
                <input type="number" name="pu" id="prix_unitaire" class="form-control" placeholder="Le prix unitaire" value="<?= (!empty($donnees["pu"])) ? $donnees["pu"] : ''; ?>" required>

                <?php if (!empty($erreurs["pu"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["pu"]; ?>
                    </span>
                <?php } ?>
            </div>


            <!-- Le bouton d'ajout -->
            <div class="col-sm-6 mt-5">
                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </div>

        </div>
    </form>

    <br>
    <br>
    <br>
    <br>
</div>
<!-- Fin du contenu de la page -->


<?php
// Supprimer les variables de session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global'], $_SESSION['erreurs-chambre'], $_SESSION['donnees-chambre']);

include './app/commum/footer.php';
?>