<?php

if (!check_if_user_connected_recept()) {
    header('location: ' . PATH_PROJECT . 'receptionniste/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside_recept.php';
?>
<div class="pagetitle ml-2 mr-2">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>receptionniste/dashboard/index">Dashboard</a></li>
            <li class="breadcrumb-item active">Ajouter une commande</li>
        </ol>
    </nav>
</div>

    <form class="form-horizontal" action="?requette=ajout-auteur-traitement" method="POST">
        <div class="card-body">

            <!-- Le champs date & numeros de réservation -->
            <div class="form-group row">
                <div class="col-sm-6">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Date de commande</label>
                    <input type="date" name="date-commande" id="inscription-date-commande" class="form-control" placeholder="Veuillez entrer la date" value="<?= (isset($donnees["date-naissance"]) && !empty($donnees["date-naissance"])) ? $donnees["date-naissance"] : ""; ?>" required>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de réservation</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéros de réservation du client" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>



            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Nom du repas</label>
                    <div class="input-group">
                        <select class="form-control" name="type" id="type">
                            <option value="" disabled selected>Sélectionnez le nom du repas</option>
                            <option value="admin">Attiékê</option>
                            <option value="user">Gâteau au crâbe</option>
                            <option value="admin">Sélection de césar</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="nom-auteur" class="col-sm-4 col-form-label">Numéros de chambre</label>
                    <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le numéro de chambre" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
                </div>

            </div>
            <!-- Le champs date -->



            <div class="col-lg-12">
                <h5 style="font-weight: bold"> Nombre Total de Repas : <span id="staying_day">0</span> Repas</h5>
                <h5 style="font-weight: bold">Prix: /-</h4>
                    <h5 style="font-weight: bold">Montant Total : <span id="total_price">0</span> /-</h5>
            </div>

        </div>

        <div class="card-footer float-right">
            <button type="reset" class="btn btn-danger">Annuler</button>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>

    </form>

<?php

include './app/commum/footer.php'

?>