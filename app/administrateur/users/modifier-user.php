<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}
include './app/commum/header.php';

include './app/commum/aside.php';

$utilisateurs = array();

// Vérifie si le paramètre contenant le numéro de l'utilisateur est présent
if (!empty($params[3])) {
    // Récupère les informations de l'utilisateur à partir de son numéro
    $utilisateurs = recuperer_user_par_son_id($params[3]);
}

// die(var_dump($utilisateurs));

?>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/users/liste-users">Liste des utilisateurs</a></li>
                <li class="breadcrumb-item active">Modifier utilisateur</li>
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
        <?php if (empty($utilisateurs)) { ?>
            <!-- Affiche un message d'erreur si la utilisateur n'existe pas -->
            <div class="alert alert-danger" role="alert">
                L'utilisateur que vous souhaitez modifier n'existe pas.
                <a class="btn btn-default" href="<?= PATH_PROJECT ?>administrateur/users/liste-users">Retour vers la liste des utilisateur</a>
            </div>

        <?php } else { ?>

            <!-- Affiche le formulaire de modification de la utilisateur -->
            <div>
                <?php
                if (isset($_SESSION['modification-photo-success']) && !empty($_SESSION['modification-photo-success'])) {
                ?>
                    <div class="alert alert-primary" style="color: white; background-color: #0d6efd; border-color: snow; text-align:center">
                        <?= $_SESSION['modification-photo-success'] ?>
                    </div>
                <?php
                }
                ?>
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
                if (isset($_SESSION['suppression-photo-success']) && !empty($_SESSION['suppression-photo-success'])) {
                ?>
                    <div class="alert alert-primary" style="color: white; background-color: #0d6efd; border-color: snow; text-align:center">
                        <?= $_SESSION['suppression-photo-success'] ?>
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
                            <img class="bd-placeholder-img card-img-top zoom-effect" width="auto" height="auto" src="<?= $utilisateurs['avatar'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_profil.jpg' : $utilisateurs['avatar'] ?>" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
                        </div>

                        <!-- Formulaire de la mise à jour photo -->
                        <form action="<?= PATH_PROJECT . "administrateur/users/traitement_photo" ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>" method="post" enctype="multipart/form-data">
                            <div class="row" style="text-align: center; display:flex;">
                                <div class="col-sm-9 text-secondary">
                                    <label class="form-label" for="customFile" style="color: gray;">Changer la photo de l'utilisateur</label>
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
                                                            <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Mettre à jour la photo de la utilisateur <?php echo $utilisateurs['nom_utilisateur']; ?></h5>
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
                        <form action="<?= PATH_PROJECT . "administrateur/users/traitement_suppression_photo"  ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>" method="post" enctype="multipart/form-data" style="display: flex; justify-content: center; align-items: center;">
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
                                                        <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Supprimer la photo de la utilisateur <?php echo $utilisateurs['nom_utilisateur']; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <label for="MP1" class="col-12 col-form-label" style="color: #070b3a;">Veuiller entrer votre mot de passe pour supprimer la photo. </label>
                                                            <br>
                                                            <div class="col-md-8 col-lg-12">
                                                                <input type="password" id="MP1" name="password" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
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
                            <i class="bi bi-exclamation-triangle me-1"></i> Les champs ci-dessous ne doivent pas être soumis vide. Au cas contraire elles affichent les anciennes informations.
                        </h5>

                        <form action="<?= PATH_PROJECT . "administrateur/users/modifier-user-traitement" ?><?= !empty($params[3]) ? "/" . $params[3] : "" ?>" novalidate method="post" class="user">

                            <div class="form-group row">
                                <!-- Le champ nom -->
                                <div class="col-sm-6">
                                    <label for="inscription-nom" class="col-sm-6 col-form-label">
                                        Nom(s):
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" class="form-control" name="nom" id="inscription-nom" placeholder="Veuillez entrer le nom" value="<?= (!empty($donnees_utilisateur_modifier["nom"])) ? $donnees_utilisateur_modifier["nom"] : $utilisateurs["nom"]; ?>" required>
                                    <?php if (isset($erreurs["nom"]) && !empty($erreurs["nom"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["nom"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>

                                <!-- Le champ Prenom -->
                                <div class="col-sm-6">
                                    <label for="inscription-prenom" class="col-sm-6 col-form-label">
                                        Prénom(s):
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" class="form-control" name="prenom" id="inscription-prenom" placeholder="Veuillez entrer le prénom" value="<?= (!empty($donnees_utilisateur_modifier["prenom"])) ? $donnees_utilisateur_modifier["prenom"] : $utilisateurs["prenom"]; ?>" required>
                                    <?php if (isset($erreurs["prenom"]) && !empty($erreurs["prenom"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["prenom"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group row">

                                <!-- Le champ sexe -->
                                <div class="col-sm-6">
                                    <label for="inscription-sexe" class="col-sm-4 col-form-label">
                                        Sexe:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <select class="form-control" name="sexe" id="inscription-sexe" required>
                                        <?php
                                        $optionssexe = array("Masculin", "Feminin");
                                        $selectedValue = (!empty($donnees_utilisateur_modifier["sexe"])) ? $donnees_utilisateur_modifier["sexe"] : $utilisateurs["sexe"];
                                        // Ajoute les options du menu déroulant
                                        foreach ($optionssexe as $option) {
                                            $selected = ($selectedValue === $option) ? "selected" : "";
                                        ?>
                                            <option value="<?= $option ?>" <?= $selected ?>><?= $option ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php if (isset($erreurs["sexe"]) && !empty($erreurs["sexe"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["sexe"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>

                                <!-- Le champ contact -->
                                <div class="col-sm-6">
                                    <label for="inscription-contact" class="col-sm-4 col-form-label">
                                        Contact:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="number" class="form-control" name="telephone" id="inscription-contact" placeholder="Veuillez entrer le contact" value="<?= (!empty($donnees_utilisateur_modifier["telephone"])) ? $donnees_utilisateur_modifier["telephone"] : $utilisateurs["telephone"]; ?>" required>
                                    <?php if (isset($erreurs["telephone"]) && !empty($erreurs["telephone"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["telephone"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>

                            </div>

                            <div class="form-group row">
                                <!-- Le champ email -->
                                <div class="col-sm-6">
                                    <label for="inscription-email" class="col-sm-6 col-form-label">
                                        Email:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" class="form-control" name="email" id="inscription-email" placeholder="Veuillez entrer l'email" value="<?= (!empty($donnees_utilisateur_modifier["email"])) ? $donnees_utilisateur_modifier["email"] : $utilisateurs["email"]; ?>" required>
                                    <?php if (isset($erreurs["email"]) && !empty($erreurs["email"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["email"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>

                                <!-- Le champ nom utilsateur -->
                                <div class="col-sm-6">
                                    <label for="inscription-nom_utilisateur" class="col-sm-6 col-form-label">
                                        Nom Utilsateur:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="text" class="form-control" name="nom_utilisateur" id="inscription-nom_utilisateur" placeholder="Veuillez entrer le nom utilisateur" value="<?= (!empty($donnees_utilisateur_modifier["nom_utilisateur"])) ? $donnees_utilisateur_modifier["nom_utilisateur"] : $utilisateurs["nom_utilisateur"]; ?>" required>
                                    <?php if (isset($erreurs["nom_utilisateur"]) && !empty($erreurs["nom_utilisateur"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["nom_utilisateur"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <!-- Le champ profil -->
                                <div class="col-sm-6">
                                    <label for="inscription-profil" class="col-sm-4 col-form-label">
                                        Profil:
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <select class="form-control" name="profil" id="inscription-profil" required>
                                        <?php
                                        $optionsprofil = array("CLIENT", "ADMINISTRATEUR");
                                        $selectedValue = (!empty($donnees_utilisateur_modifier["profil"])) ? $donnees_utilisateur_modifier["profil"] : $utilisateurs["profil"];
                                        // Ajoute les options du menu déroulant
                                        foreach ($optionsprofil as $option) {
                                            $selected = ($selectedValue === $option) ? "selected" : "";
                                        ?>
                                            <option value="<?= $option ?>" <?= $selected ?>><?= $option ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php if (isset($erreurs["profil"]) && !empty($erreurs["profil"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["profil"]; ?>
                                        </span>
                                    <?php } ?>
                                </div>

                                <!-- Le bouton modifier -->
                                <div class="col-md-6 mb-3" style="margin-top: 35px;">
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
unset($_SESSION['modification-photo-success'], $_SESSION['modification-photo-erreur'], $_SESSION['suppression-photo-success'], $_SESSION['suppression-photo-erreurs'], $_SESSION['donnees-utilisateur-modifier'], $_SESSION['erreurs-utilisateur-modifier'], $_SESSION['message-success-global']);

include './app/commum/footer.php';
?>