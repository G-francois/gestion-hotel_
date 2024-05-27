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

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image1"></div>
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
                                    <h1 class="h4 text-gray-900 mb-2">Vous avez oublié votre mot de passe ?</h1>
                                    <p class="mb-4">
                                        Nous comprenons, des choses arrivent. Entrez simplement votre adresse mail pour une petite vérification.</p>
                                </div>


                                <form action="<?= PATH_PROJECT ?>administrateur/mot_de_passe/traitement" method="post" class="user" novalidate>
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


                                    <button type="submit" class="btn btn-primary btn-block">Réinitialiser le mot de passe</button>

                                    </a>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= PATH_PROJECT ?>administrateur/mot_de_passe">Mot de passe oublié ?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= PATH_PROJECT ?>administrateur/connexion">Vous avez déjà un compte ? Connectez-vous!</a>
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
include './app/commum/footer_admin _icm.php'
?>