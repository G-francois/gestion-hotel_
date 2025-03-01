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
    $chambre = recuperer_type_chambre_par_son_id($params[3]);
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
                <li class="breadcrumb-item active">Modifier type de chambre</li>
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
                Le type de chambre que vous souhaitez modifier n'existe pas.
                <a class="btn btn-default" href="<?= PATH_PROJECT ?>administrateur/chambres/liste-chambres">Retour vers la liste des chambres</a>
            </div>

        <?php } else { ?>

            <!-- Affiche le formulaire de modification de la chambre -->
            <div>
                <div class="row">

                    <h5 style="color: #cda45e; text-align:center; ">
                        <i class="bi bi-exclamation-triangle me-1"></i> Les champs ci-dessous ne doivent pas être soumis vide. Au cas contraire, elles affichent les anciennes informations.
                    </h5>

                    <form action="<?= PATH_PROJECT . "administrateur/chambres/modifier-type-chambre-traitement" ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>"  method="post" class="user">
                        <div class="form-group row mb-2">
                            <!-- Le champ nom du type de chambre -->
                            <div class="col-sm-6">
                                <label for="inscription-type-chambre" class="col-sm-4 col-form-label">
                                    Nom type:
                                    <span class="text-danger">(*)</span>
                                </label>
                                <input type="text" class="form-control" name="type_chambre" id="inscription-type-chambre" placeholder="Veuillez entrer le nom du type" value="<?= (!empty($donnees["type_chambre"])) ? $donnees["type_chambre"] : $chambre["type_chambre"]; ?>" required>
                                <?php if (!empty($erreurs["type_chambre"])) { ?>
                                    <span class="text-danger">
                                        <?= $erreurs["type_chambre"]; ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <!-- Le champ Détails -->
                            <div class="col-sm-6 ">
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
                        </div>

                        <div class="form-group row mb-2">
                            <!-- Le champ nombre de personne(s) -->
                            <div class="col-sm-6">
                                <label for="inscription-personnes" class="col-sm-6 col-form-label">
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

                            <!-- Le champ superficies -->
                            <div class="col-sm-6">
                                <label for="inscription-superficies" class="col-sm-6 col-form-label">
                                    Superficies:
                                    <span class="text-danger">(*)</span>
                                </label>
                                <input type="text" class="form-control" name="superficies" id="inscription-superficies" placeholder="Veuillez entrer la superficie" value="<?= (!empty($donnees_chambre_modifier["superficie"])) ? $donnees_chambre_modifier["superficie"] : $chambre["superficie"]; ?>" required>
                                <?php if (!empty($erreurs["superficies"])) { ?>
                                    <span class="text-danger">
                                        <?= $erreurs["superficies"]; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <!-- Le champ Prix unitaire -->
                            <div class="col-sm-6">
                                <label for="inscription-prix" class="col-sm-6 col-form-label">
                                    Prix unitaire:
                                    <span class="text-danger">(*)</span>
                                </label>
                                <input type="number" class="form-control" name="pu" id="inscription-prix" placeholder="Veuillez entrer le prix unitaire de chambre" value="<?= (!empty($donnees_chambre_modifier["montant"])) ? $donnees_chambre_modifier["montant"] : $chambre["montant"]; ?>" required>
                                <?php if (!empty($erreurs["pu"])) { ?>
                                    <span class="text-danger">
                                        <?= $erreurs["pu"]; ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <!-- Le bouton modifier -->
                            <div class="col-sm-6  " style="margin-top: 35px;">
                                <input type="submit" value="Modifier" class="btn btn-primary " style="width: -webkit-fill-available; padding: 9px;">
                            </div>
                        </div>

                    </form>
                    <!-- Fin du formulaire -->

                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            
        <?php } ?>
    </section>
</div>

<?php
// Supprimer les variables de session
unset($_SESSION['donnees-type-chambre-modifier'], $_SESSION['erreurs-type-chambre-modifier'], $_SESSION['message-success-global']);

include './app/commum/footer.php';
?>