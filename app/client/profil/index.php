<?php
if (!check_if_user_connected_client()) {
	header('location: ' . PATH_PROJECT . 'client/connexion/index');
	exit;
}

include('./app/commum/header_client.php');


?>


    <!-- LES STYLES UTILISEE LORS DE LA PAGE PROFIL DU CLIENT -->

    <style>
        label {
            color: black;
        }

        .card-title {
            font-size: 18px;
            font-weight: 500;
            color: rgb(1, 41, 112);
            font-family: Poppins, sans-serif;
            padding: 20px 0px 15px;
        }

        .profile.card-title {
            color: rgb(1, 41, 112);
        }

        .profile .label {
            font-weight: 600;
            color: #cda45e;
        }

        .profile .row {
            margin-bottom: 20px;
        }

        .profile .card-title {
            color: rgb(1, 41, 112);
        }

        .profile .profile-card h2 {
            font-size: 24px;
            font-weight: 700;
            color: rgb(44, 56, 78);
            margin: 10px 0px 0px;
        }

        .profile .profile-edit label {
            font-weight: 600;
            color: rgba(1, 41, 112, 0.6);
        }

        .col-form-label {
            padding-top: calc(0.375rem + 1px);
            padding-bottom: calc(0.375rem + 1px);
            margin-bottom: 0px;
            font-size: inherit;
            line-height: 1.5;
        }

        .btn-primary {
            --bs-btn-color: #fff;
            --bs-btn-bg: #013534;
            --bs-btn-border-color: # #1a1814;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #9d6b15;
            --bs-btn-hover-border-color: # #1a1814
        }

        .btn-danger {
            --bs-btn-color: #fff;
            --bs-btn-bg: #3b070c;
            --bs-btn-border-color: #3b070c;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #b30617;
            --bs-btn-hover-border-color: #b30617;
        }

        .card {
            background-color: #1a1814;
        }

        .col-form-label {
            color: white;
        }
    </style>

    <main id="main" class="container-fluid" style="padding-top: 14px;">

        <section class="profile" style="padding-top: 80px;">
            <div class="row">
                <div class="col-lg-4">
                    <!-- ======= Hero Section ======= -->
                    <section id="hero4" class="d-flex align-items-center">
                        <div class="container position-relative text-center text-lg-start" data-aos="zoom-in"
                             data-aos-delay="100">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h1>Espace<span> Profil</span></h1>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- End Hero -->
                    <div class="card">
						<?php
						if (isset($_SESSION['suppression-erreurs']) && !empty($_SESSION['suppression-erreurs'])) {
							?>
                            <div class="alert alert-primary"
                                 style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
								<?= $_SESSION['suppression-erreurs'] ?>
                            </div>
							<?php
						}
						?>

						<?php
						if (isset($_SESSION['desactivation-erreurs']) && !empty($_SESSION['desactivation-erreurs'])) {
							?>
                            <div class="alert alert-primary"
                                 style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
								<?= $_SESSION['desactivation-erreurs'] ?>
                            </div>
							<?php
						}
						?>

						<?php
						if (isset($_SESSION['photo-erreurs']) && !empty($_SESSION['photo-erreurs'])) {
							?>
                            <div class="alert alert-primary"
                                 style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
								<?= $_SESSION['photo-erreurs'] ?>
                            </div>
							<?php
						}
						?>

						<?php
						if (isset($_SESSION['suppression-photo-erreurs']) && !empty($_SESSION['suppression-photo-erreurs'])) {
							?>
                            <div class="alert alert-primary"
                                 style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
								<?= $_SESSION['suppression-photo-erreurs'] ?>
                            </div>
							<?php
						}
						?>

                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center" style="color: #cda45e;">
                                <a href="<?= $_SESSION['utilisateur_connecter_client']['avatar'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_profil.JPG' : $_SESSION['utilisateur_connecter_client']['avatar'] ?>"
                                   class="gallery-lightbox" data-gall="gallery-item">
                                    <img src="<?= $_SESSION['utilisateur_connecter_client']['avatar'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_profil.JPG' : $_SESSION['utilisateur_connecter_client']['avatar'] ?>"
                                         style="width: 130px;" alt="Profile" class="rounded-circle" class="img-fluid">
                                </a>

                                <div class="mt-3">
                                    <h4><?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['nom_utilisateur'] : 'Pseudo' ?></h4>
                                    <p class="mb-1"
                                       style="color: white;"><?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['profil'] : 'Profil' ?></p>
                                    <p class="font-size-sm" style="color: white;">SOUS LES COCOTIERS</p>
                                </div>
                            </div>

                            <!-- Formulaire de mise à jour photo -->
                            <form action="<?= PATH_PROJECT ?>client/profil/traitement_photo" method="post"
                                  enctype="multipart/form-data">
                                <div class="row" style="text-align: center; display:flex;">
                                    <div class="col-sm-9 text-secondary">
                                        <label class="form-label" for="customFile" style="color: gray;">Changer ma photo
                                            de profil</label>
                                        <input type="file" class="form-control" id="image" name="image"/>
                                    </div>


                                    <div class="modal-footer text-center col-sm-3"
                                         style="justify-content: center; margin-top: 31px;">
                                        <!-- Button maj_photo modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#ModifierModal"
                                                style="font-size: revert; padding: 9px;">
                                            Modifier
                                        </button>
                                        <div class="col-md-8 col-lg-12">
                                            <div class="text-center" style="color: #070b3a;">
                                                <!-- Modal maj_photo -->
                                                <div class="modal fade" id="ModifierModal" tabindex="-1"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    style="text-transform: uppercase;">Mettre à jour la
                                                                    photo de profil</h1>
                                                                <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="MP" class="col-12 col-form-label"
                                                                           style="color: #070b3a;">Veuiller entrer votre
                                                                        mot de passe pour modifier la photo. </label>
                                                                    <br>
                                                                    <div class="col-md-8 col-lg-12">
                                                                        <input type="password" id="MP" name="password"
                                                                               class="form-control"
                                                                               placeholder="Veuillez entrer votre mot de passe"
                                                                               value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Annuler
                                                                </button>
                                                                <button type="submit" name="change_photo"
                                                                        class="btn btn-primary">Valider
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </form>
                        </div>
                    </div>

                    <!-- suppression_photo Form -->
                    <form action="<?= PATH_PROJECT ?>client/profil/traitement_suppression_photo" method="post"
                          enctype="multipart/form-data"
                          style="display: flex; justify-content: center; align-items: center;">
                        <div class="row">
                            <!-- Button suppression_photo modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#suppression_photoModal">
                                <i class="bi bi-trash"></i>
                                Supprimer
                            </button>

                            <div class="col-md-8 col-lg-12">
                                <div class="text-center" style="color: #070b3a;">
                                    <!-- Modal suppression_photo -->
                                    <div class="modal fade" id="suppression_photoModal" tabindex="-1"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel"
                                                        style="text-transform: uppercase;">Supprimer la photo de
                                                        profil</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <label for="MP1" class="col-12 col-form-label"
                                                               style="color: #070b3a;">Veuiller entrer votre mot de
                                                            passe pour supprimer la photo. </label>
                                                        <br>
                                                        <div class="col-md-8 col-lg-12">
                                                            <input type="password" id="MP1" name="password"
                                                                   class="form-control"
                                                                   placeholder="Veuillez entrer votre mot de passe"
                                                                   value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Annuler
                                                    </button>
                                                    <button type="submit" name="supprimer_photo"
                                                            class="btn btn-primary">Valider
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>

                    <div class="profile" style="color: white;">
                        <div class="row">
                            <div class="col-lg-5 col-md-4 label ">Nom et Prénom(s):</div>
                            <div class="col-lg-7 col-md-8"><?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['nom'] : 'Nom' ?> <?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['prenom'] : 'Prenom' ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-5 col-md-4 label ">Nom utilisateur :</div>
                            <div class="col-lg-7 col-md-8"><?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['nom_utilisateur'] : 'Nom utilisateur' ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-5 col-md-4 label ">Email :</div>
                            <div class="col-lg-7 col-md-8"><?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['email'] : 'Email' ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-5 col-md-4 label ">Contact :</div>
                            <div class="col-lg-7 col-md-8"><?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['telephone'] : 'Contact' ?></div>
                        </div>

                    </div>
                    <hr>

                    <div>
                        <!-- suppression Form -->
                        <form action="<?= PATH_PROJECT ?>client/profil/traitement_suppression" method="post"
                              enctype="multipart/form-data">
                            <div class="row mb-3 text-center">
                                <div class="col-md-8 col-lg-12">
                                    <!-- Button suppression modal -->
                                    <button type="button" style="padding: 10px; background-color:#9f0808;"
                                            class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#suppressionModal">
                                        <i class="bi bi-trash"></i>
                                        Supprimer mon compte
                                    </button>

                                    <div class="text-center" style="color: #070b3a;">
                                        <!-- Modal suppression -->
                                        <div class="modal fade" id="suppressionModal" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- <div class="modal-header">
													  <h1 class="modal-title fs-5" id="exampleModalLabel" style="text-transform: uppercase;">Supprimer mon compte</h1>
													  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div> -->
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <div>
                                                                <i class="bi bi-exclamation-triangle me-1"
                                                                   style="font-size: xxx-large;color: #d70e0e;"></i>
                                                            </div>
                                                            <label for="MP2" class="col-12 col-form-label"
                                                                   style="color: #d11818;">Vous êtes sûre d'effectuer
                                                                cette action ? Après cette action votre compte sera
                                                                supprimer de façon définitive.
                                                                Si oui veuiller entrer votre mot de passe pour appliquer
                                                                l'action. </label>
                                                            <br>
                                                            <div class="col-md-8 col-lg-12">
                                                                <input type="password" id="MP2" name="password"
                                                                       class="form-control"
                                                                       placeholder="Veuillez entrer votre mot de passe"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Annuler
                                                        </button>
                                                        <button type="submit" name="supprimer_photo"
                                                                class="btn btn-primary">Valider
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- desactivation Form -->
                        <form action="<?= PATH_PROJECT ?>client/profil/traitement_desactivation" method="post"
                              enctype="multipart/form-data">
                            <div class="row mb-3 text-center">
                                <div class="col-md-8 col-lg-12">
                                    <!-- Button desactivation modal -->
                                    <button type="button" style="padding: 10px; background-color:#9f0808;"
                                            class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#desactivationModal">
                                        Désactiver mon compte
                                    </button>

                                    <div class="text-center" style="color: #070b3a;">
                                        <!-- Modal desactivation -->
                                        <div class="modal fade" id="desactivationModal" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- <div class="modal-header">
													  <h1 class="modal-title fs-5" id="exampleModalLabel" style="text-transform: uppercase;">Désactiver mon compte</h1>
													  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div> -->
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <div>
                                                                <i class="bi bi-exclamation-triangle me-1"
                                                                   style="font-size: xxx-large;color: #d70e0e;"></i>
                                                            </div>
                                                            <label for="MP3" class="col-12 col-form-label"
                                                                   style="color: #d11818;">Vous êtes sûre d'effectuer
                                                                cette action ? Après cette action vous ne serez plus en
                                                                mesure de vous connecter.
                                                                Si oui veuiller entrer votre mot de passe pour appliquer
                                                                l'action. Pour réactiver votre compte veuiller contacter
                                                                un administrateur.</label>
                                                            <br>
                                                            <div class="col-md-8 col-lg-12">
                                                                <input type="password" id="MP3" name="password"
                                                                       class="form-control"
                                                                       placeholder="Veuillez entrer votre mot de passe"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Annuler
                                                        </button>
                                                        <button type="submit" name="desactivation"
                                                                class="btn btn-primary">Valider
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            </div>

            <!-- section de modification des informations usuelles -->
            <div class="col-md-8">
                <div class="col-lg-12">
                    <h5 style="margin-bottom: 13px; margin-top: 80px; font-size: 32px; font-weight: 700; color: #cda45e;">
                        Modification(s) des informations usuelles</h5>
                    <div class="card">
                        <div class="card-body">
                            <form action="<?= PATH_PROJECT ?>client/profil/traitement_edit_profil" method="post"
                                  enctype="multipart/form-data">
                                <h5 style="color: #cda45e; text-align:center; ">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Les champs ci-dessous ne doivent pas
                                    être soumis vide. Au cas contraire elles affichent les anciennes informations.
                                </h5>

								<?php
								if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
									?>
                                    <div class="alert alert-primary"
                                         style="color: white; background-color: #364e46; text-align:center; border-color: snow;">
										<?= $_SESSION['success'] ?>
                                    </div>
									<?php
								}
								?>

								<?php
								if (isset($_SESSION['sauvegarder-erreurs']) && !empty($_SESSION['sauvegarder-erreurs'])) {
									?>
                                    <div class="alert alert-primary"
                                         style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
										<?= $_SESSION['sauvegarder-erreurs'] ?>
                                    </div>
									<?php
								}
								?>

                                <div>
                                    <div class="row mb-3">
                                        <label for="Name" class="col-md-4 col-lg-3 col-form-label">Nom :</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="nom" type="text"
                                                   class="form-control <?= isset($_SESSION['erreurs']['nom']) ? 'is-invalid' : '' ?>"
                                                   id="Name"
                                                   value="<?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['nom'] : 'Nom' ?>">

											<?php if (isset($erreurs["nom"]) && !empty($erreurs["nom"])) { ?>
                                                <span class="text-danger">
                        <?php echo $erreurs["nom"]; ?>
                      </span>
											<?php } ?>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Name1" class="col-md-4 col-lg-3 col-form-label">Prénom(s) :</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="prenom" type="text"
                                                   class="form-control <?= isset($_SESSION['erreurs']['prenom']) ? 'is-invalid' : '' ?>"
                                                   id="Name1"
                                                   value="<?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['prenom'] : 'Prenom' ?>">

											<?php if (isset($erreurs["prenom"]) && !empty($erreurs["prenom"])) { ?>
                                                <span class="text-danger">
                        <?php echo $erreurs["prenom"]; ?>
                      </span>
											<?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="user" class="col-md-4 col-lg-3 col-form-label">Nom utilisateur :</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="nom_utilisateur" type="text"
                                               class="form-control <?= isset($_SESSION['erreurs']['nom_utilisateur']) ? 'is-invalid' : '' ?>"
                                               id="user"
                                               value="<?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['nom_utilisateur'] : 'Nom utilisateur' ?>">

										<?php if (isset($erreurs["nom_utilisateur"]) && !empty($erreurs["nom_utilisateur"])) { ?>
                                            <span class="text-danger">
                      <?php echo $erreurs["nom_utilisateur"]; ?>
                    </span>
										<?php } ?>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Contact : </label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="telephone" type="text"
                                               class="form-control <?= isset($_SESSION['erreurs']['telephone']) ? 'is-invalid' : '' ?>"
                                               id="Phone"
                                               value="<?= isset($_SESSION['utilisateur_connecter_client']) ? $_SESSION['utilisateur_connecter_client']['telephone'] : 'Téléphone' ?>">

										<?php if (isset($erreurs["telephone"]) && !empty($erreurs["telephone"])) { ?>
                                            <span class="text-danger">
                      <?php echo $erreurs["telephone"]; ?>
                    </span>
										<?php } ?>
                                    </div>
                                </div>


                                <div class="text-center" style="color: #070b3a;">
                                    <!-- Button Modifier_informations modal -->
                                    <button type="button" class="btn btn-primary text-center" data-bs-toggle="modal"
                                            data-bs-target="#ModifierinformationsModal">
                                        Sauvegarder
                                    </button>

                                    <div class="text-center" style="color: #070b3a;">
                                        <!-- Modal Modifier_informations -->
                                        <div class="modal fade" id="ModifierinformationsModal" tabindex="-1"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel"
                                                            style="text-transform: uppercase;">Modifier les informations
                                                            de mon compte</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="passwordImput" class="col-12 col-form-label"
                                                                   style="color: #070b3a;">Veuiller entrer votre mot de
                                                                passe pour appliquer les modifications.</label>
                                                            <input type="password" name="password" id="passwordImput"
                                                                   class="form-control"
                                                                   placeholder="Veuillez entrer votre mot de passe"
                                                                   value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="sauvegarder"
                                                                class="btn btn-primary">Valider
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Fin du formulaire de modification du profil -->
                        </div>
                    </div>
                </div>

                <!-- Changed password Form -->
                <div class="col-lg-12 mt-5">

                    <h5 style="margin-bottom: 13px; font-size: 32px; font-weight: 700; color: #cda45e;">Changement de
                        mot de passe</h5>
                    <div class="card">
                        <div class="card-body">
                            <form action="<?= PATH_PROJECT ?>client/profil/traitement_password" method="post"
                                  enctype="multipart/form-data">
                                <h5 style="color: #cda45e; text-align:center; ">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Sachez qu'après le changement de
                                    votre mot de passe vous serez déconnecté(e).
                                </h5>
                                <br>
                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-5 col-lg-4 col-form-label" require>Mot de
                                        passe actuel</label>
                                    <div class="col-md-7 col-lg-8">
                                        <input name="password" type="password" class="form-control"
                                               placeholder="Veuillez entrer votre mot de passe actuel"
                                               id="currentPassword" required>
                                        <span class="text-danger">
                    <?php
					if (isset($erreurs["password"]) && !empty($erreurs["password"])) {
						echo $erreurs["password"];
					}
					?>
                  </span>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-5 col-lg-4 col-form-label">Nouveau Mot de
                                        passe</label>
                                    <div class="col-md-7 col-lg-8">
                                        <input name="newpassword" type="password" class="form-control"
                                               placeholder="Veuillez entrer votre nouveau mot de passe" id="newPassword"
                                               required>
                                        <span class="text-danger">
                    <?php
					if (isset($erreurs["newpassword"]) && !empty($erreurs["newpassword"])) {
						echo $erreurs["newpassword"];
					}
					?>
                  </span>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-5 col-lg-4 col-form-label">Retaper Nouveau
                                        Mot de passe</label>
                                    <div class="col-md-7 col-lg-8">
                                        <input name="renewpassword" type="password" class="form-control"
                                               placeholder="Veuillez retaper votre nouveau mot de passe"
                                               id="renewPassword" required>
                                        <span class="text-danger">
                    <?php
					if (isset($erreurs["renewpassword"]) && !empty($erreurs["renewpassword"])) {
						echo $erreurs["renewpassword"];
					}
					?>
                  </span>
                                    </div>

                                </div>

                                <div style="text-align: center;">
                                    <button type="submit" name="change_password" class="btn btn-primary text-center">
                                        Changer mot de passe
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <!-- End #main -->
<?php
unset($_SESSION['changement-erreurs'], $_SESSION['suppression-erreurs'], $_SESSION['desactivation-erreurs'], $_SESSION['success'], $_SESSION['sauvegarder-erreurs'], $_SESSION['photo-erreurs'], $_SESSION['suppression-photo-erreurs'], $_SESSION['erreurs']);

include('./app/commum/footer_client_icm.php');
?>