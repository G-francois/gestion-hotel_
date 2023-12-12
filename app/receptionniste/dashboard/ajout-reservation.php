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
            <li class="breadcrumb-item active">Ajouter une réservation</li>
        </ol>
    </nav>
</div>

<form class="form-horizontal" action="<?= PATH_PROJECT ?>client/dashboard/ajout-reserv-traitement" method="POST">
    <div class="card-body" style="color: black;">

        <!-- Le champs nom du client & DATE DE DEBUT -->
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="inscription-nom" class="col-sm-4 col-form-label">Nom du client</label>
                <input type="text" name="nom" id="inscription-nom" class="form-control" placeholder="Veuillez entrer le nom du client" value="<?= (isset($donnees["nom"]) && !empty($donnees["nom"])) ? $donnees["nom"] : ""; ?>" required>
            </div>
            <div class="col-sm-6">
                <label for="date_debut" class="col-sm-4 col-form-label">Date de début</label>
                <input type="date" id="date_debut" name="date_debut" class="form-control" value="<?= (isset($donnees["date-naissance"]) && !empty($donnees["date-naissance"])) ? $donnees["date-naissance"] : ""; ?>" required>
            </div>
        </div>

        <!-- Le champs date -->
        <div class="form-group row">
            <div class="col-sm-6">
                <label for="date_fin" class="col-sm-4 col-form-label">Date de fin</label>
                <input type="date" id="date_fin" name="date_fin" class="form-control" value="<?= (isset($donnees["date-naissance"]) && !empty($donnees["date-naissance"])) ? $donnees["date-naissance"] : ""; ?>" required>
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="typeChambre" class="col-sm-4 col-form-label">Type de chambre : </label>
                <div class="input-group">
                    <select class="form-control" id="typeChambre" name="typeChambre" onchange="afficherChampsAccompagnateur()">
                        <option value="" disabled selected>Sélectionnez le type de chambre</option>
                        <option value="solo">Solo</option>
                        <option value="double">Doubles</option>
                        <option value="triple">Triples</option>
                        <option value="suite">Suites</option>
                    </select>
                </div>
            </div>

        </div>


        <div class="form-group row" id="champsAccompagnateur">
            <!-- Les champs d'accompagnateur et numéro de chambre seront affichés ici -->

        </div>


        <div class="col-lg-12">
            <h5 style="font-weight: bold">Total Days : <span id="staying_day">0</span> Days</h5>
            <h5 style="font-weight: bold">Price: /-</h4>
                <h5 style="font-weight: bold">Total Amount : <span id="total_price">0</span> /-</h5>
        </div>

    </div>

    <div class="card-footer float-right" style=" padding: 0.75rem 1.25rem; border-top:none;">
        <button type="reset" class="btn btn-danger">Annuler</button>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </div>

</form>

<script>
    function afficherChampsAccompagnateur() {
        var typeChambre = document.getElementById("typeChambre").value;
        var champsAccompagnateur = document.getElementById("champsAccompagnateur");

        // Réinitialiser les champs d'accompagnateur
        champsAccompagnateur.innerHTML = "";
        if (typeChambre === "solo") {
            champsAccompagnateur.innerHTML = `
                                    <div class = "col-sm-6" >
                                        <label class = "col-form-label"> Numéro de chambre: </label> 
                                        <select name = "numChambre" class = "form-control" >
                                        <option value="" disabled selected>Veuillez choisir le numéro de chambre</option>
                                            <option value = "1" > Chambre 1 </option> 
                                            <option value = "2" > Chambre 2 </option> 
                                            <option value = "3" > Chambre 3 </option> 
                                        </select> 
                                    </div> `;
            // Pas besoin d'afficher le champ accompagnateur pour la chambre solo
        } else if (typeChambre === "double") {
            champsAccompagnateur.innerHTML = `
                                    <div class = "col-sm-6" >
                                        <label class = "col-form-label"> Numéro de chambre: </label> 
                                        <select name = "numChambre"class = "form-control" >
                                            <option value = ""disabled selected> Veuillez choisir le numéro de chambre </option> 
                                            <option value = "4" > Chambre 4 </option>  
                                            <option value = "5" > Chambre 5 </option>  
                                            <option value = "6" > Chambre 6 </option>  
                                        </select>  
                                    </div>  
                                    <div class = "col-sm-6" >
                                        <label class = "col-form-label"> Champ d 'accompagnateur :</label>  
                                        <input type = "text"name = "accompagnateur"class = "form-control" placeholder="Veuillez entrer le nom de l'accompagnateur">
                                    </div>`;
        } else if (typeChambre === "triple") {
            champsAccompagnateur.innerHTML = `
                                    <div class = "col-sm-6" >
                                        <label class = "col-form-label"> Numéro de chambre: </label> 
                                        <select name = "numChambre"class = "form-control" >
                                            <option value = ""disabled selected> Veuillez choisir le numéro de chambre </option> 
                                            <option value = "7" > Chambre 7 </option>  
                                            <option value = "8" > Chambre 8 </option>  
                                            <option value = "9" > Chambre 9 </option>  
                                        </select>  
                                    </div>
                                    <div class = "col-sm-6" >
                                        <label class = "col-form-label"> Champ d 'accompagnateur :</label>  
                                        <input type = "text"name = "accompagnateur"class = "form-control" placeholder="Veuillez entrer le nom de l'accompagnateur 1">
                                    </div>
                                    <div class = "col-sm-6 mt-3 mt-sm-3" >
                                        <label class = "col-form-label"> Champ d 'accompagnateur :</label>  
                                        <input type = "text"name = "accompagnateur"class = "form-control" placeholder="Veuillez entrer le nom de l'accompagnateur 2" >
                                    </div>`;
        } else if (typeChambre === "suite") {
            champsAccompagnateur.innerHTML = `
                                    <div class = "col-sm-6" >
                                        <label class = "col-form-label"> Numéro de chambre: </label> 
                                        <select name = "numChambre"class = "form-control" >
                                            <option value = ""disabled selected> Veuillez choisir le numéro de chambre </option> 
                                            <option value = "10" > Chambre 10 </option>  
                                            <option value = "11" > Chambre 11 </option>  
                                            <option value = "12" > Chambre 12 </option>  
                                        </select>  
                                    </div>
                                    <div class = "col-sm-6" >
                                        <label class = "col-form-label"> Champ d 'accompagnateur :</label>  
                                        <input type = "text"name = "accompagnateur"class = "form-control" placeholder="Veuillez entrer le nom de l'accompagnateur 1">
                                    </div>
                                    <div class = "col-sm-6 mt-3 mt-sm-3" >
                                        <label class = "col-form-label"> Champ d 'accompagnateur :</label>  
                                        <input type = "text"name = "accompagnateur"class = "form-control" placeholder="Veuillez entrer le nom de l'accompagnateur 2">
                                    </div>
                                    <div class = "col-sm-6 mt-3 mt-sm-3" >
                                        <label class = "col-form-label"> Champ d 'accompagnateur :</label>  
                                        <input type = "text"name = "accompagnateur"class = "form-control" placeholder="Veuillez entrer le nom de l'accompagnateur 3">
                                    </div>
                                    <div class = "col-sm-6 mt-3 mt-sm-3" >
                                        <label class = "col-form-label"> Champ d 'accompagnateur :</label>  
                                        <input type = "text"name = "accompagnateur"class = "form-control" placeholder="Veuillez entrer le nom de l'accompagnateur 4">
                                    </div>`;
        }
    }
</script>

<?php

include './app/commum/footer.php'

?>