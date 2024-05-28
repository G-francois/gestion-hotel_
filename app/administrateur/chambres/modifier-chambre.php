<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}
include './app/commum/header.php';

include './app/commum/aside.php';

$chambre = array();

// Vérifie si le paramètre contenant le numéro de chambre est présent
if (!empty($params[3])) {
    // Récupère les informations de la chambre à partir de son numéro
    $chambre = recuperer_chambre_par_son_num_chambre($params[3]);
}

?>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/chambres/liste-chambres">Liste des chambres</a></li>
                <li class="breadcrumb-item active">Modifier chambre</li>
            </ol>
        </nav>
    </div>

    <?php
    // Vérifie s'il y a un message de succès global à afficher
    if (!empty($_SESSION['message-success-global'])) {
    ?>
        <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
            <?= $_SESSION['message-success-global'] ?>
        </div>
    <?php
    }
    ?>

    <?php
    // Vérifie s'il y a un message d'erreur global à afficher
    if (!empty($_SESSION['message-erreur-global'])) {
    ?>
        <div class="alert alert-danger" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
            <?= $_SESSION['message-erreur-global'] ?>
        </div>
    <?php
    }
    ?>

    <section class="content">
        <?php if (empty($chambre)) { ?>

            <!-- Affiche un message d'erreur si la chambre n'existe pas -->
            <div class="alert alert-danger" role="alert">
                La chambre que vous souhaitez modifier n'existe pas.
                <a class="btn btn-default" href="<?= PATH_PROJECT ?>administrateur/chambres/liste-chambres">Retour vers la liste des chambres</a>
            </div>

        <?php } else { ?>

            <!-- Affiche le formulaire de modification de la chambre -->
            <div>
                <?php
                if (!empty($_SESSION['modification-photo-erreur'])) {
                ?>
                    <div class="alert alert-primary" style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
                        <?= $_SESSION['modification-photo-erreur'] ?>
                    </div>
                <?php
                }
                ?>

                <?php
                if (!empty($_SESSION['suppression-photo-erreurs'])) {
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
                            <img class="bd-placeholder-img card-img-top zoom-effect" width="auto" height="auto" src="<?= $chambre['photos'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_chambre.jpeg' : $chambre['photos'] ?>" focusable="false" role="img" aria-label="Placeholder: Thumbnail" alt="">
                        </div>

                        <!-- Formulaire de la mise à jour photo -->
                        <form action="<?= PATH_PROJECT . "administrateur/chambres/traitement_photo" ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>" method="post" enctype="multipart/form-data">
                            <div class="row" style="text-align: center; display:flex;">
                                <div class="col-sm-9 text-secondary">
                                    <label class="form-label" for="customFile" style="color: gray;">Changer la photo de la chambre</label>
                                    <input type="file" class="form-control" id="image" name="image" />
                                </div>

                                <div class="text-center col-sm-3" style="justify-content: center; margin-top: 31px;">
                                    <!-- Bouton du Modal mettre à jour -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal0" style="font-size: revert; padding: 8px;">MModifier</button>

                                    <div class="col-md-8 col-lg-12">
                                        <div class="text-center" style="color: #070b3a;">
                                            <!-- Modal du bouton mettre à jour -->
                                            <div class="modal fade" id="modal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Mettre à jour la photo de la chambre <?php echo $chambre['num_chambre']; ?></h5>
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
                        <form action="<?= PATH_PROJECT . "administrateur/chambres/traitement_suppression_photo"  ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>" method="post" enctype="multipart/form-data" style="display: flex; justify-content: center; align-items: center;">
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
                                                        <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Supprimer la photo de la chambre <?php echo $chambre['num_chambre']; ?></h5>
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

                        <h5 style="color: #cda45e; text-align:center; ">
                            <i class="bi bi-exclamation-triangle me-1"></i> Les champs ci-dessous ne doivent pas être soumis vide. Au cas contraire, elles affichent les anciennes informations.
                        </h5>
                        
                        <form action="<?= PATH_PROJECT . "administrateur/chambres/modifier-chambre-traitement" ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>" novalidate method="post" class="user">
                            <div class="form-group row">
                                <!-- Le champ Libellé du type de chambre -->
                                <div class="col-sm-6 mb-2">
                                    <label for="inscription-libelle" class="col-sm-4 col-form-label">
                                        Libellé:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <select class="form-control" name="lib_typ" id="inscription-libelle" required>
                                        <?php
                                        $optionsLibelle = array("Solo", "Double", "Triple", "Suite");
                                        $selectedValue = (!empty($donnees_chambre_modifier["lib_typ"])) ? $donnees_chambre_modifier["lib_typ"] : $chambre["lib_typ"];
                                        // Ajoute les options du menu déroulant
                                        foreach ($optionsLibelle as $option) {
                                            $selected = ($selectedValue === $option) ? "selected" : "";
                                        ?>
                                            <option value="<?= $option ?>" <?= $selected ?>><?= $option ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php if (!empty($erreurs["lib_typ"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["lib_typ"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>

                                <!-- Le champ Code du type de chambre -->
                                <div class="col-sm-6 mb-2 mb-sm-0">
                                    <label for="inscription-code" class="col-sm-4 col-form-label">
                                        Code:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="number" class="form-control" name="cod_typ" id="inscription-code" placeholder="Veuillez entrer le code type de chambre" value="<?= (!empty($donnees["cod_typ"])) ? $donnees["cod_typ"] : $chambre["cod_typ"]; ?>" required>
                                    <?php if (!empty($erreurs["cod_typ"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["cod_typ"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <!-- Le champ Détails -->
                                <div class="col-sm-6">
                                    <label for="inscription-details" class="col-sm-6 col-form-label">
                                        Détails:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <textarea class="form-control" name="details" id="inscription-details" placeholder="Veuillez entrer le(s) detail(s)" required><?= (!empty($donnees_chambre_modifier["details"])) ? $donnees_chambre_modifier["details"] : $chambre["details"]; ?></textarea>
                                    <?php if (!empty($erreurs["details"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["details"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>

                                <!-- Le champ nombre de personne(s) -->
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="inscription-code" class="col-sm-6 col-form-label">
                                        Nombre de personne(s):
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="number" class="form-control" name="personnes" id="inscription-personnes" placeholder="Veuillez entrer le nombre de personne(s)" value="<?= (!empty($donnees["personnes"])) ? $donnees["personnes"] : $chambre["personnes"]; ?>" required>
                                    <?php if (!empty($erreurs["personnes"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["personnes"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <!-- Le champ superficies -->
                                <div class="col-sm-6">
                                    <label for="inscription-superficies" class="col-sm-6 col-form-label">
                                        Superficies:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" class="form-control" name="superficies" id="inscription-superficies" placeholder="Veuillez entrer la superficies" value="<?= (!empty($donnees_chambre_modifier["superficies"])) ? $donnees_chambre_modifier["superficies"] : $chambre["superficies"]; ?>" required>
                                    <?php if (!empty($erreurs["superficies"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["superficies"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>

                                <!-- Le champ Prix unitaire -->
                                <div class="col-sm-6">
                                    <label for="inscription-prix" class="col-sm-6 col-form-label">
                                        Prix unitaire:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="number" class="form-control" name="pu" id="inscription-prix" placeholder="Veuillez entrer le prix unitaire de chambre" value="<?= (!empty($donnees_chambre_modifier["pu"])) ? $donnees_chambre_modifier["pu"] : $chambre["pu"]; ?>" required>
                                    <?php if (!empty($erreurs["pu"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["pu"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group row">
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
unset($_SESSION['modification-photo-erreur'], $_SESSION['suppression-photo-erreurs'], $_SESSION['donnees-chambre-modifier'], $_SESSION['erreurs-chambre-modifier'], $_SESSION['message-success-global']);

include './app/commum/footer.php';
?>