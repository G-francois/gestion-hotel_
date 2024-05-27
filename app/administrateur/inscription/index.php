<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page dashboard de l'administrateur s'il est connecté en tant qu'administrateur
        header('location:' . PATH_PROJECT . 'administrateur/reservations/liste-reservations');
	exit;
}

include './app/commum/header.php';
?>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg" style="margin-top: 2rem; margin-bottom: 2rem;">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-register-image1"></div>
                <div class="col-lg-6">
                    <div class="p-5">
                        

                        <?php
                        if (!empty($_SESSION['inscription-message-erreur-global'])) {
                        ?>
                            <div class="alert alert-primary" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
                                <?= $_SESSION['inscription-message-erreur-global'] ?>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Créez un compte Administrateur !</h1>
                        </div>

                        <form action="<?= PATH_PROJECT ?>administrateur/inscription/traitement" method="post" class="user">
                            <!-- Le champ nom -->
                            <div class="form-group">
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
                            <div class="form-group">
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

                            <!-- Le champs sexe -->
                            <div>
                                <div class="form-group" style="margin-bottom: -10px;">
                                    <label for="inscription-sexe">Sexe:
                                        <div class="form-group clearfix d-inline-flex pl-5">
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" name="sexe" checked="" id="sexe-m" value="Masculin">
                                                <label for="sexe-m">Masculin</label>
                                            </div>

                                            <div class="icheck-primary d-inline pl-5">
                                                <input type="radio" name="sexe" checked="" id="sexe-f" value="Feminin">
                                                <label for="sexe-f">Féminin</label>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <span class="text-danger">
                                    <?php
                                    if (!empty($erreurs["sexe"])) {
                                        echo $erreurs["sexe"];
                                    }
                                    ?>
                                </span>
                            </div>


                            <!-- Le champ téléphone -->
                            <div class="form-group">
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

                            <!-- Le champ email -->
                            <div class="form-group">
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
                            <div class="form-group">
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

                            <!-- Le champ mot de passe -->
                            <div class="form-group">
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

                            <!-- Le champ, retapez mot de passe -->
                            <div class="form-group">
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

                            <!-- Le champ terms et conditions -->
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" name="termes-conditions" id="customCheck" required>
                                    <label class="custom-control-label" for="customCheck" style="color: blue; font-size: large;">
                                        J'accepte les termes et conditions
                                        <span class="text-danger">(*)</span>
                                    </label>
                                </div>
                                <?php if (!empty($erreurs["termes-conditions"])) { ?>
                                    <span class="text-danger">
                                        <?php echo $erreurs["termes-conditions"]; ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Inscription</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= PATH_PROJECT ?>/administrateur/mot_de_passe"> Mot de passe oublié ? </a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?= PATH_PROJECT ?>/administrateur/connexion">Vous avez déjà un compte ? Connectez-vous!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
session_destroy();
?>

<?php
include './app/commum/footer_admin _icm.php';
?>