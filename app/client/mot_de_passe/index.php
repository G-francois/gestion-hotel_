<?php
include('./app/commum/header_client_icm.php');
?>


    <div class="container" style="margin-top: 135px; margin-bottom: 35px;">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg ">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
									<?php
									if (!empty($_SESSION['inscription-message-success-global'])) {
										?>
                                        <div class="alert alert-primary"
                                             style="color: white; background-color: #5cb85c; text-align:center; border-color: snow;">
											<?= $_SESSION['inscription-message-success-global'] ?>
                                        </div>
										<?php
									}
									?>

									<?php
									if (!empty($_SESSION['inscription-message-erreur-global'])) {
										?>
                                        <div class="alert alert-primary"
                                             style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
											<?= $_SESSION['inscription-message-erreur-global'] ?>
                                        </div>
										<?php
									}
									?>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Vous avez oublié votre mot de passe ?</h1>
                                        <p class="mb-4" style="color: black;">
                                            Nous comprenons, des choses arrivent. Entrez simplement votre adresse e-mail
                                            ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de
                                            passe !</p>
                                    </div>


                                    <form action="<?= PATH_PROJECT ?>client/mot_de_passe/traitement" method="post" class="user">
                                        <!-- Le champ email -->
                                        <div class="form-group">
                                            <label for="inscription-email" style="color:black;">
                                                Adresse mail:
                                                <span class="text-danger">(*)</span>
                                            </label>
                                            <input type="email" name="email" id="inscription-email" class="form-control"
                                                   placeholder="Veuillez entrer votre adresse mail"
                                                   value="<?= (!empty($donnees["email"])) ? $donnees["email"] : ''; ?>"
                                                   required>
											<?php if (!empty($erreurs["email"])) { ?>
                                                <span class="text-danger">
                                                <?php echo $erreurs["email"]; ?>
                                            </span>
											<?php } ?>
                                        </div>


                                        <button type="submit" class="btn btn-primary btn-block">Réinitialiser le mot de
                                            passe
                                        </button>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= PATH_PROJECT ?>client/inscription">Créez un compte
                                            !</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?= PATH_PROJECT ?>client/connexion">Vous avez déjà un
                                            compte ? Connectez-vous!</a>
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
include('./app/commum/footer_client_icm.php');
?>