<?php

if (!check_if_user_connected_recept()) {
    header('location: ' . PATH_PROJECT . 'receptionniste/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside_recept.php';
?>

<section class="profile">
    <style>
        .card-body h4 {
            font-size: 24px;
            font-weight: 700;
            color: #2c384e;
            margin: 10px 0 0 0;
        }

        .profile .row label {
            font-weight: 600;
            color: rgba(1, 41, 112, 0.6);
        }


        .espace_profil {
            margin-top: 1rem;
            display: flex;
            font-weight: 600;
            justify-content: space-around;
        }
    
        label {
            color: black;
        }

        /* .card {
            background-color: #eeeeee;
        } */

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
            color: rgba(1, 41, 112, 0.6);
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
            background-color: black;
            border-color: black;
        }

        .col-form-label {
            color: white;
        }

        /* .row {
            background-color: #eeeeee;
        } */
    </style>
    <div class="pagetitle ml-2 mr-2">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>receptionniste/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item"><?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['profil'] : 'Profile' ?></li>
                <li class="breadcrumb-item active">Paramètres</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-5">

            <div class="card ml-2">
                <?php
                if (isset($_SESSION['suppression-erreurs']) && !empty($_SESSION['suppression-erreurs'])) {
                ?>
                    <div class="alert alert-primary" style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
                        <?= $_SESSION['suppression-erreurs'] ?>
                    </div>
                <?php
                }
                ?>

                <?php
                if (isset($_SESSION['desactivation-erreurs']) && !empty($_SESSION['desactivation-erreurs'])) {
                ?>
                    <div class="alert alert-primary" style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
                        <?= $_SESSION['desactivation-erreurs'] ?>
                    </div>
                <?php
                }
                ?>

                <?php
                if (isset($_SESSION['photo-erreurs']) && !empty($_SESSION['photo-erreurs'])) {
                ?>
                    <div class="alert alert-primary" style="color: white; background-color: #9f0808; border-color: snow; text-align:center">
                        <?= $_SESSION['photo-erreurs'] ?>
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

                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <a href="<?= $_SESSION['utilisateur_connecter_recept']['avatar'] == 'no_image' ?  PATH_PROJECT . 'public/images/default_profil.JPG' : $_SESSION['utilisateur_connecter_recept']['avatar'] ?>" class="gallery-lightbox" data-gall="gallery-item">
                            <img src="<?= $_SESSION['utilisateur_connecter_recept']['avatar'] == 'no_image' ?  PATH_PROJECT . 'public/images/default_profil.JPG' : $_SESSION['utilisateur_connecter_recept']['avatar'] ?>" style="width: 130px;" alt="Profile" class="rounded-circle" class="img-fluid">
                        </a>


                        <div class="mt-3">
                            <h4><?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['nom_utilisateur'] : 'Pseudo' ?></h4>
                            <p class="mb-1"><?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['profil'] : 'Profil' ?></p>
                            <p class="font-size-sm">SOUS LES COCOTIERS</p>
                        </div>
                    </div>
                    <form action="<?= PATH_PROJECT ?>receptionniste/dashboard/traitement_photo" method="post" enctype="multipart/form-data">
                        <div class="row" style="text-align: center; display:flex;">
                            <div class="col-sm-9 text-secondary">
                                <label class="form-label" for="customFile" style="color: gray;">Changer ma photo de profil</label>
                                <input type="file" class="form-control" id="image" name="image" />
                            </div>

                            <!-- maj_photo Form -->
                            <div class="text-center col-sm-3" style="justify-content: center; margin-top: 31px;">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal0" style="font-size: revert; padding: 9px;">Mettre à jour</button>
                                <div class="col-md-8 col-lg-12">
                                    <div class="text-center" style="color: #070b3a;">
                                        <!-- Modal -->
                                        <div class="modal fade" id="modal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Mettre à jour la photo de profil</h5>
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
                    </form>
                </div>
            </div>

            <!-- suppression_photo Form -->
            <form action="<?= PATH_PROJECT ?>receptionniste/dashboard/traitement_suppression_photo" method="post" enctype="multipart/form-data" style="display: flex; justify-content: center; align-items: center;">
                <div class="row">
                    <button type="reset" class="btn btn-secondary" data-toggle="modal" data-target="#modal5"><i class="fa fa-trash"></i> Supprimer</button>
                    <div class="col-md-8 col-lg-12">
                        <div class="text-center" style="color: #070b3a;">
                            <!-- Modal -->
                            <div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Supprimer la photo de profil</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for="MP" class="col-12 col-form-label" style="color: #070b3a;">Veuiller entrer votre mot de passe pour supprimer la photo. </label>
                                                <br>
                                                <div class="col-md-8 col-lg-12">
                                                    <input type="password" id="MP" name="password" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
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

            <hr>

            <div class="profile">
                <div class="row">
                    <div class="col-lg-5 col-md-4 label ">Nom et Prénom(s):</div>
                    <div class="col-lg-7 col-md-8"><?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['nom'] : 'Nom' ?> <?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['prenom'] : 'Prenom' ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-5 col-md-4 label ">Sexe:</div>
                    <div class="col-lg-7 col-md-8"><?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['sexe'] : 'Sexe' ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-5 col-md-4 label ">Nom utilisateur :</div>
                    <div class="col-lg-7 col-md-8"><?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['nom_utilisateur'] : 'Nom utilisateur' ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-5 col-md-4 label ">Email :</div>
                    <div class="col-lg-7 col-md-8"><?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['email'] : 'Email' ?></div>
                </div>

                <div class="row">
                    <div class="col-lg-5 col-md-4 label ">Contact :</div>
                    <div class="col-lg-7 col-md-8"><?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['telephone'] : 'Contact' ?></div>
                </div>

            </div>
            <hr>

            <div>
                <!-- suppression Form -->
                <form action="<?= PATH_PROJECT ?>receptionniste/dashboard/traitement_suppression" method="post" enctype="multipart/form-data">
                    <div class="row mb-3 text-center">
                        <div class="col-md-8 col-lg-12">
                            <button type="button" style="padding: 10px; background-color:#9f0808;" name="supprimer-compte" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal2 "><i class="bi bi-trash"></i> Supprimer mon compte</button>

                            <div class="text-center" style="color: #070b3a;">
                                <!-- Modal -->
                                <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <!-- <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Supprimer mon compte</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div> -->
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div>
                                                        <i class="fas fa-exclamation-triangle me-1" style="font-size: xxx-large;color: #d70e0e;"></i>
                                                    </div>
                                                    <label for="MP" class="col-12 col-form-label" style="color: #d11818;">Vous êtes sûre d'effectuer cette action ? Après cette action votre compte sera supprimer de façon définitive.
                                                        Si oui veuiller entrer votre mot de passe pour appliquer l'action. </label>
                                                    <br>
                                                    <div class="col-md-8 col-lg-12">
                                                        <input type="password" id="MP" name="password" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="submit" name="suppression" class="btn btn-primary">Valider</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>

                <!-- desactivation Form -->
                <form action="<?= PATH_PROJECT ?>receptionniste/dashboard/traitement_desactivation" method="post" enctype="multipart/form-data">
                    <div class="row mb-3 text-center">
                        <div class="col-md-8 col-lg-12">
                            <button type="button" style="padding: 10px; background-color:#9f0808;" name="désactiver-compte" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal3" style="margin-top: 8px;">Désactiver mon compte</button>

                            <div class="text-center" style="color: #070b3a;">
                                <!-- Modal -->
                                <div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <!-- <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Désactiver mon compte</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div> -->
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div>
                                                        <i class="fas fa-exclamation-triangle me-1" style="font-size: xxx-large;color: #d70e0e;"></i>
                                                    </div>
                                                    <label for="MP" class="col-12 col-form-label" style="color: #d11818;">Vous êtes sûre d'effectuer cette action ? Après cette action vous ne serez plus en mesure de vous connecter.
                                                        Si oui veuiller entrer votre mot de passe pour appliquer l'action. Pour réactiver votre compte veuiller nous écrire par mail.</label>
                                                    <br>
                                                    <div class="col-md-8 col-lg-12">
                                                        <input type="password" id="MP" name="password" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="submit" name="desactivation" class="btn btn-primary">Valider</button>
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

    <div class="col-md-7">
        <div class="col-lg-12">
            <h5 style="font-weight: 700;">Modification(s) des informations usuelles</h5>
            <div class="card">
                <div class="card-body">
                    <form action="<?= PATH_PROJECT ?>receptionniste/dashboard/traitement_edit_profil" method="post" enctype="multipart/form-data">
                        <h5 style="color: #8bb9c6; text-align:center; ">
                            Les champs ci-dessous ne doivent pas être soumis vide. Au cas contraire elles affichent anciennes informations.
                        </h5>

                        <?php
                        if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
                        ?>
                            <div class="alert alert-primary" style="color: white; background-color: #1cc88a; text-align:center; border-color: snow;">
                                <?= $_SESSION['success'] ?>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                        if (isset($_SESSION['sauvegarder-erreurs']) && !empty($_SESSION['sauvegarder-erreurs'])) {
                        ?>
                            <div class="alert alert-primary" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
                                <?= $_SESSION['sauvegarder-erreurs'] ?>
                            </div>
                        <?php
                        }
                        ?>

                        <div>
                            <div class="row mb-3">
                                <label for="Name" class="col-md-4 col-lg-3 col-form-label">Nom :</label>
                                <div class="col-md-8 col-lg-9">
                                    <input name="nom" type="text" class="form-control <?= isset($_SESSION['erreurs']['nom']) ? 'is-invalid' : '' ?>" id="Name" value="<?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['nom'] : 'Nom' ?>">

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
                                    <input name="prenom" type="text" class="form-control <?= isset($_SESSION['erreurs']['prenom']) ? 'is-invalid' : '' ?>" id="Name1" value="<?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['prenom'] : 'Prenom' ?>">

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
                                <input name="nom_utilisateur" type="text" class="form-control <?= isset($_SESSION['erreurs']['nom_utilisateur']) ? 'is-invalid' : '' ?>" id="user" value="<?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['nom_utilisateur'] : 'Nom utilisateur' ?>">

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
                                <input name="telephone" type="text" class="form-control <?= isset($_SESSION['erreurs']['telephone']) ? 'is-invalid' : '' ?>" id="Phone" value="<?= isset($_SESSION['utilisateur_connecter_recept']) ?  $_SESSION['utilisateur_connecter_recept']['telephone'] : 'Téléphone' ?>">

                                <?php if (isset($erreurs["telephone"]) && !empty($erreurs["telephone"])) { ?>
                                    <span class="text-danger">
                                        <?php echo $erreurs["telephone"]; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="text-center" style="color: #070b3a;">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary text-center" data-toggle="modal" data-target="#modal1">
                                Sauvegarder
                            </button>

                            <div class="text-center" style="color: #070b3a;">
                                <!-- Modal -->
                                <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Modifier les informations de mon compte</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="passwordImput" class="col-12 col-form-label" style="color: #070b3a;">Veuiller entrer votre mot de passe pour appliquer les modifications.</label>
                                                    <input type="password" name="password" id="passwordImput" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">

                                                </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="sauvegarder" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </form><!-- End Profile Edit Form -->
    </div>
    </div>
    </div>

    <!-- Changed password Form -->
    <div class="col-lg-12 mt-5">

        <h5 style="font-weight: 700; ">Changement de mot de passe</h5>
        <div class="card">
            <div class="card-body">
                <form action="<?= PATH_PROJECT ?>receptionniste/dashboard/traitement_password" method="post" enctype="multipart/form-data">
                    <h5 style="color: #8bb9c6; text-align:center; "> Sachez qu'après le changement de votre mot de passe vous serez déconnecté(e).</h5>
                    <br>
                    <div class="row mb-3">
                        <label for="currentPassword" class="col-md-5 col-lg-4 col-form-label" require>Mot de passe actuel</label>
                        <div class="col-md-7 col-lg-8">
                            <input name="password" type="password" class="form-control" placeholder="Veuillez entrer votre mot de passe actuel" id="currentPassword">
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
                        <label for="newPassword" class="col-md-5 col-lg-4 col-form-label">Nouveau Mot de passe</label>
                        <div class="col-md-7 col-lg-8">
                            <input name="newpassword" type="password" class="form-control" placeholder="Veuillez entrer votre nouveau mot de passe" id="newPassword" requi#9f0808>
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
                        <label for="renewPassword" class="col-md-5 col-lg-4 col-form-label">Retaper Nouveau Mot de passe</label>
                        <div class="col-md-7 col-lg-8">
                            <input name="renewpassword" type="password" class="form-control" placeholder="Veuillez retaper votre nouveau mot de passe" id="renewPassword" requi#9f0808>
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
                        <button type="submit" name="change_password" class="btn btn-primary text-center"> Changer mot de passe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<?php
  unset($_SESSION['changement-erreurs'], $_SESSION['suppression-erreurs'],  $_SESSION['desactivation-erreurs'], $_SESSION['success'], $_SESSION['sauvegarder-erreurs'], $_SESSION['photo-erreurs'], $_SESSION['suppression-photo-erreurs'], $_SESSION['erreurs']);
  ?>

<?php
include './app/commum/footer.php';
?>