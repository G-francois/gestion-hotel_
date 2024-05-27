<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page dashboard de l'administrateur s'il est connecté en tant qu'administrateur
        header('location:' . PATH_PROJECT . 'administrateur/reservations/liste-reservations');
	exit;
}
include './app/commum/header.php'
?>

<div class="container" style="margin-top: 145px;">
    <div class="row justify-content-center;" style="color:black; justify-content:center;">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image1"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                            <?php
                                if (!empty($_SESSION['inscription-message-success-global'])) {
                                ?>
                                    <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
                                        <?= $_SESSION['inscription-message-success-global'] ?>
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Nouveau mot de passe</h1>
                                </div>


                                <form action="<?= PATH_PROJECT ?>administrateur/mot_de_passe/traitement_new_mot_passe" method="post" class="user" novalidate>

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

                                    <button type="submit" class="btn btn-primary btn-block">Enrégistrer</button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= PATH_PROJECT ?>administrateur/connexion/index">Vous avez déjà un compte ? Connectez-vous!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= PATH_PROJECT ?>administrateur/inscription/index">Créez un compte !</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<?php
unset($_SESSION['inscription-message-success-global'], $_SESSION['enregistrer-erreurs']);

include './app/commum/footer_admin _icm.php'
?>