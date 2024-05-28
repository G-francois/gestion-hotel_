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
                <li class="breadcrumb-item active">Ajouter un utilisateur</li>
            </ol>
        </nav>
    </div>

    <?php
    // Vérifier s'il y a un message de succès et s'il n'est pas vide
    if (!empty($_SESSION['ajout-message-success-global'])) {
    ?>
        <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
            <?= $_SESSION['ajout-message-success-global'] ?>
        </div>
    <?php
    }
    ?>

    <?php
    // Vérifier s'il y a un message d'erreur et s'il n'est pas vide
    if (!empty($_SESSION['ajout-message-erreur-global'])) {
    ?>
        <div class="alert alert-danger" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
            <?= $_SESSION['ajout-message-erreur-global'] ?>
        </div>
    <?php
    }
    ?>

    <!-- Formulaire d'ajout d'utilisateur -->
    <form action="<?= PATH_PROJECT ?>administrateur/users/ajout-user-traitement" method="post" class="user" novalidate>
        <div class="form-group row pt-3">
            <!-- Le champ nom -->
            <div class="col-sm-6  mb-2">
                <label for="inscription-nom">
                    Nom:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer votre nom" value="<?= (!empty($donnees["nom"])) ? $donnees["nom"] : ''; ?>" required>
                <?php if (!empty($erreurs["nom"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["nom"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le champ prénom -->
            <div class="col-sm-6 mb-2">
                <label for="inscription-prenom">
                    Prénoms:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="prenom" id="inscription-prenom" class="form-control" placeholder="Veuillez entrer vos prénoms" value="<?= (!empty($donnees["prenom"])) ? $donnees["prenom"] : ''; ?>" required>
                <?php if (!empty($erreurs["prenom"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["prenom"]; ?>
                    </span>
                <?php } ?>
            </div>
        </div>

        <div class="form-group row">
            <!-- Le champ sexe -->
            <div class="col-sm-6  mb-2">
                <label for="sexe">
                    Sexe :
                    <span class="text-danger">(*)</span>
                </label>
                <div style="padding-left: 0; padding-right: 0;">
                    <select class="sexe form-control" id="sexe" name="sexe">
                        <option value="" disabled selected>Sélectionnez le sexe</option>
                        <option value="Masculin">Masculin</option>
                        <option value="Féminin">Féminin</option>
                    </select>
                    <?php if (!empty($erreurs["sexe"])) { ?>
                        <span class="text-danger">
                            <?php echo $erreurs["sexe"]; ?>
                        </span>
                    <?php } ?>
                </div>
            </div>

            <!-- Le champ téléphone -->
            <div class="col-sm-6 mb-2">
                <label for="inscription-telephone">
                    Téléphone:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="telephone" id="inscription-telephone" class="form-control" placeholder="Veuillez entrer votre numéro de téléphone" value="<?= (!empty($donnees["telephone"])) ? $donnees["telephone"] : ''; ?>" required>
                <?php if (!empty($erreurs["telephone"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["telephone"]; ?>
                    </span>
                <?php } ?>
            </div>
        </div>

        <div class="form-group row">
            <!-- Le champ email -->
            <div class="col-sm-6 mb-2">
                <label for="inscription-email">
                    Adresse mail:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="email" name="email" id="inscription-email" class="form-control" placeholder="Veuillez entrer votre adresse mail" value="<?= (!empty($donnees["email"])) ? $donnees["email"] : ''; ?>" required>
                <?php if (!empty($erreurs["email"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["email"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le champ nom d'utilisateur -->
            <div class="col-sm-6 mb-2">
                <label for="inscription-nom-utilisateur">
                    Nom d'utilisateur:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="nom-utilisateur" id="inscription-nom-utilisateur" class="form-control" placeholder="Veuillez entrer votre nom d'utilisateur" value="<?= (!empty($donnees["nom-utilisateur"])) ? $donnees["nom-utilisateur"] : ''; ?>" required>
                <?php if (!empty($erreurs["nom-utilisateur"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["nom-utilisateur"]; ?>
                    </span>
                <?php } ?>
            </div>
        </div>

        <div class="form-group row ">
            <!-- Le champ type d'utilisateur -->
            <div class="col-sm-6  mb-2">
                <label for="profile">
                    Profile :
                    <span class="text-danger">(*)</span>
                </label>
                <div style="padding-left: 0; padding-right: 0;">
                    <select class="sexe form-control" id="profile" name="profil">
                        <option value="" disabled selected>Sélectionnez le type d'utilisateur</option>
                        <option value="ADMINISTRATEUR">ADMINISTRATEUR</option>
                        <option value="RECEPTIONNISTE">RECEPTIONNISTE</option>
                        <option value="CLIENT">CLIENT</option>
                    </select>
                    <?php if (!empty($erreurs["profil"])) { ?>
                        <span class="text-danger">
                            <?php echo $erreurs["profil"]; ?>
                        </span>
                    <?php } ?>
                </div>
            </div>

            <!-- Le champ mot de passe -->
            <div class="col-sm-6 mb-2">
                <label for="inscription-mot-passe">
                    Mot de passe:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="password" name="mot-passe" id="inscription-mot-passe" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="<?= (!empty($donnees["mot-passe"])) ? $donnees["mot-passe"] : ''; ?>" required>
                <?php if (!empty($erreurs["mot-passe"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["mot-passe"]; ?>
                    </span>
                <?php } ?>
            </div>
        </div>

        <div class="form-group row ">
            <!-- Le champ, retapez mot de passe -->
            <div class="col-sm-6 mb-2">
                <label for="inscription-retapez-mot-passe">
                    Retaper mot de passe:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="password" name="retapez-mot-passe" id="inscription-retapez-mot-passe" class="form-control" placeholder="Veuillez retaper votre mot de passe" value="<?= (!empty($donnees["retapez-mot-passe"])) ? $donnees["retapez-mot-passe"] : ''; ?>" required>
                <?php if (!empty($erreurs["retapez-mot-passe"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["retapez-mot-passe"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le boutton ajouter -->
            <div class="col-sm-6" style="margin-top: 31px;">
                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </div>
        </div>
    </form>

</div>
<!-- Fin du contenu de la page -->

<?php
// Supprimer les variables de session
unset($_SESSION['ajout-message-success-global'], $_SESSION['ajout-message-erreur-global'], $_SESSION['donnees-utilisateur'], $_SESSION['erreurs-utilisateur']);

include './app/commum/footer.php'

?>