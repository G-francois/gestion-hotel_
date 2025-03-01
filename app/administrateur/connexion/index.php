<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page dashboard de l'administrateur s'il est connecté en tant qu'administrateur
        header('location:' . PATH_PROJECT . 'administrateur/reservations/liste-reservations');
	exit;
}
include './app/commum/header.php'
?>


<div class="container" style="margin-top: 120px; ">
    <div class="container" style="margin-top: 120px; max-width: 1420px;">
        <div class="row justify-content-center;" style="color:black; justify-content:center;">


            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Contenu imbriqué à l'intérieur du corps de la carte -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image1"></div>
                            <div class="col-lg-6">
                                <div class="p-5">

                                    <!-- Titre -->
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenue <?= isset($_SESSION['nom-utilisateur-inscrit']) ?  $_SESSION['nom-utilisateur-inscrit'][1] . " " . $_SESSION['nom-utilisateur-inscrit'][0] : '' ?></h1>
                                    </div>
                                    <?php
                                    // Vérifier s'il y a un message de succès d'inscription et s'il n'est pas vide
                                    if (!empty($_SESSION['inscription-message-success-global'])) {
                                    ?>
                                        <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
                                            <?= $_SESSION['inscription-message-success-global'] ?>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    // Vérifier s'il y a un message d'erreur de connexion et s'il n'est pas vide
                                    if (!empty($_SESSION['connexion-message-erreur-global'])) {
                                    ?>
                                        <div class="alert alert-primary" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
                                            <?= $_SESSION['connexion-message-erreur-global'] ?>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <form action="<?= PATH_PROJECT ?>administrateur/connexion/traitement" method="post" class="user">
                                        <!-- Champ pour l'email ou le nom d'utilisateur -->
                                        <div class="form-group">
                                            <label for="inscription-email">
                                                Email ou Nom d'utilisateur :
                                                <span class="text-danger">(*)</span>
                                            </label>
                                            <input type="text" name="email-nom-utilisateur" id="inscription-email" class="form-control" placeholder="Entrer votre adresse mail ou nom d'utilisateur" value="<?= (!empty($donnees["email-nom-utilisateur"])) ? $donnees["email-nom-utilisateur"] : ''; ?>" required>
                                            <?php if (!empty($erreurs["email-nom-utilisateur"])) { ?>
                                                <span class="text-danger">
                                                    <?php echo $erreurs["email-nom-utilisateur"]; ?>
                                                </span>
                                            <?php } ?>
                                        </div>

                                        <!-- Champ pour le mot de passe -->
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

                                        <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= PATH_PROJECT ?>/administrateur/mot_de_passe">Mot de passe oublié ?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?= PATH_PROJECT ?>/administrateur/inscription">Créez un compte !</a>
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
    // Supprimer les variables de session inutiles
    unset($_SESSION['inscription-message-success-global'], $_SESSION['connexion-message-erreur-global'],  $_SESSION['connexion-erreurs-admin']);

    include './app/commum/footer_admin _icm.php';
    ?>
