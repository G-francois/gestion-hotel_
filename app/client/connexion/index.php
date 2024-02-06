<?php
$include_icm_header = true;
include('./app/commum/header_.php');
?>


<div class="container" style="margin-top: 70px; margin-bottom: 70px;">
    <div class="row justify-content-center;" style="color:black; justify-content:center;">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg" style="margin-top: 6rem;">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <?php
                                if (isset($_SESSION['validation-compte-message-success']) && !empty($_SESSION['validation-compte-message-success'])) {
                                ?>
                                    <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
                                        <?= $_SESSION['validation-compte-message-success'] ?>
                                    </div>
                                <?php
                                }

                                if (isset($_SESSION['validation-compte-message-erreur']) && !empty($_SESSION['validation-compte-message-erreur'])) {
                                ?>
                                    <div class="alert alert-primary" style="color: white; text-align:center; background-color: red; border-color: snow;">
                                        <?= $_SESSION['validation-compte-message-erreur'] ?>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if (isset($_SESSION['validation-mot-passe-success']) && !empty($_SESSION['validation-mot-passe-success'])) {
                                ?>
                                    <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
                                        <?= $_SESSION['validation-mot-passe-success'] ?>
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Bienvenu(e)</h1>
                                </div>


                                <?php
                                if (isset($_SESSION['connexion-message-erreur-global']) && !empty($_SESSION['connexion-message-erreur-global'])) {
                                ?>
                                    <div class="alert alert-primary" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
                                        <?= $_SESSION['connexion-message-erreur-global'] ?>
                                    </div>
                                <?php
                                }
                                ?>

                                <form action="<?= PATH_PROJECT ?>client/connexion/traitement" method="post" class="user">
                                    <!-- Le champs email ou nom utilisateur-->
                                    <div class="form-group">
                                        <label for="inscription-email">
                                            Email ou Nom d'utilisateur:
                                            <span class="text-danger">(*)</span>
                                        </label>
                                        <input type="text" name="email-nom-utilisateur" id="inscription-email" class="form-control" placeholder="Entrer votre adresse mail ou nom d'utilisateur" value="<?= (isset($donnees["email-nom-utilisateur"]) && !empty($donnees["email-nom-utilisateur"])) ? $donnees["email-nom-utilisateur"] : ''; ?>" required>
                                        <?php if (isset($erreurs["email-nom-utilisateur"]) && !empty($erreurs["email-nom-utilisateur"])) { ?>
                                            <span class="text-danger">
                                                <?php echo $erreurs["email-nom-utilisateur"]; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                    <!-- Le champs mot de passe -->
                                    <div class="form-group">
                                        <label for="inscription-mot-passe">
                                            Mot de passe:
                                            <span class="text-danger">(*)</span>
                                        </label>
                                        <input type="password" name="mot-passe" id="inscription-mot-passe" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="<?= (isset($donnees["mot-passe"]) && !empty($donnees["mot-passe"])) ? $donnees["mot-passe"] : ''; ?>" required>
                                        <?php if (isset($erreurs["mot-passe"]) && !empty($erreurs["mot-passe"])) { ?>
                                            <span class="text-danger">
                                                <?php echo $erreurs["mot-passe"]; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= PATH_PROJECT ?>client/mot_de_passe">Mot de
                                        passe oublié ?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= PATH_PROJECT ?>client/inscription">
                                        Créez un compte !
                                    </a>
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
session_destroy();
?>
<?php
$include_icm_footer = true;
include('./app/commum/footer_.php');
?>