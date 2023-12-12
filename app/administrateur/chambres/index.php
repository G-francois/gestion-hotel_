<?php
// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!check_if_user_connected_admin()) {
    // Redirige l'utilisateur vers la page de connexion de l'administrateur s'il n'est pas connecté en tant qu'administrateur
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside.php';

?>

<!-- Commencement du contenu de la page -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Ajouter une chambre</li>
            </ol>
        </nav>
    </div>

    <?php
    // Vérifier s'il y a un message de succès et s'il n'est pas vide
    if (isset($_SESSION['message-success-global']) && !empty($_SESSION['message-success-global'])) {
    ?>
        <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
            <?= $_SESSION['message-success-global'] ?>
        </div>
    <?php
    }
    ?>

    <?php
    // Vérifier s'il y a un message d'erreur et s'il n'est pas vide
    if (isset($_SESSION['message-erreur-global']) && !empty($_SESSION['message-erreur-global'])) {
    ?>
        <div class="alert alert-danger" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
            <?= $_SESSION['message-erreur-global'] ?>
        </div>
    <?php
    }
    ?>

    <!-- Formulaire d'ajout de chambre-->
    <form action="<?= PATH_PROJECT ?>administrateur/chambres/ajout-chambre-traitement" method="post" class="user" enctype="multipart/form-data">
        <div class="form-group row pt-5">
            <!-- Le champ photo -->
            <div class="col-sm-6 mb-3">
                <label class="form-label" for="customFile" style="color: gray;">
                    Importer une image
                    <span class="text-danger">(*)</span>
                </label>
                <input type="file" class="form-control" id="image" name="image" />

                <?php if (isset($erreurs["image"]) && !empty($erreurs["image"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["image"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le champ Libellé du type de chambre -->
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="libelle_type">
                    Libellé du type de chambre :
                    <span class="text-danger">(*)</span>
                </label>
                <div style="padding-left: 0px; padding-right: 0px;">
                    <select class="lib_typ form-control" id="libelle_type" name="lib_typ">
                        <option value="" disabled selected>Sélectionnez le libellé du type de chambre</option>
                        <option value="Solo">Solo</option>
                        <option value="Double">Double</option>
                        <option value="Triple">Triple</option>
                        <option value="Suite">Suite</option>
                    </select>
                    <?php if (isset($erreurs["lib_typ"]) && !empty($erreurs["lib_typ"])) { ?>
                        <span class="text-danger">
                            <?php echo $erreurs["lib_typ"]; ?>
                        </span>
                    <?php } ?>
                </div>
            </div>

            <!-- Le champ Code du type de chambre -->
            <div class="col-sm-6 mb-3">
                <label for="cod_typ">
                    Code du type de chambre :
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="cod_typ" id="cod_typ" class="form-control" placeholder="Le code du type de chambre sera automatiquement rempli" value="<?= (isset($donnees["cod_typ"]) && !empty($donnees["cod_typ"])) ? $donnees["cod_typ"] : ''; ?>" readonly>

                <?php if (isset($erreurs["cod_typ"]) && !empty($erreurs["code_type"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["code_typ"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le champ details_chambre -->
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="details_chambre">
                    Informations :
                    <span class="text-danger">(*)</span>
                </label>
                <textarea name="details_chambre" id="details_chambre" class="form-control" placeholder="Le détail de la chambre sera automatiquement rempli" readonly><?php if (isset($donnees["details_chambre"])) {
                                                                                                                                                                            echo $donnees["details_chambre"];
                                                                                                                                                                        } ?></textarea>
                <?php if (isset($erreurs["details_chambre"]) && !empty($erreurs["details_chambre"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["details_chambre"]; ?>
                    </span>
                <?php } ?>
            </div>


            <!-- Le champ details_personne_chambre -->
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="details_personne_chambre">
                    Nombre de pesonne(s):
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="details_personne_chambre" id="details_personne_chambre" class="form-control" placeholder="Le nombre de pesonne(s) sera automatiquement rempli" readonly>

                <?php if (isset($erreurs["details_personne_chambre"]) && !empty($erreurs["details_personne_chambre"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["details_personne_chambre"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le champ details_superficie_chambre -->
            <div class="col-sm-6 mb-3">
                <label for="details_superficie_chambre">
                    Superficie:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="details_superficie_chambre" id="details_superficie_chambre" class="form-control" placeholder="La superficie sera automatiquement rempli" readonly>

                <?php if (isset($erreurs["details_superficie_chambre"]) && !empty($erreurs["details_superficie_chambre"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["details_superficie_chambre"]; ?>
                    </span>
                <?php } ?>
            </div>

            <!-- Le champ Prix unitaire -->
            <div class="col-sm-6 mt-3">
                <label for="prix_unitaire">
                    Prix unitaire :
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="pu" id="prix_unitaire" class="form-control" placeholder="Le prix unitaire sera automatiquement rempli" readonly>

                <?php if (isset($erreurs["pu"]) && !empty($erreurs["pu"])) { ?>
                    <span class="text-danger">
                        <?php echo $erreurs["pu"]; ?>
                    </span>
                <?php } ?>
            </div>


            <!-- Le bouton d'ajout -->
            <div class="col-sm-6 mt-5">
                <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </div>

        </div>
    </form>
</div>
<!-- Fin du contenu de la page -->

<?php
// Supprimer les variables de session
unset($_SESSION['message-success-global'], $_SESSION['message-erreur-global'], $_SESSION['erreurs-chambre'], $_SESSION['donnees-chambre']);

include './app/commum/footer.php';
?>

<script>
    // Fonction pour mettre à jour le champ Code du type de chambre et Prix unitaire
    function updateFields() {
        var libelleType = document.getElementById("libelle_type").value;
        var codTypField = document.getElementById("cod_typ");
        var puField = document.getElementById("prix_unitaire");
        var detailsField = document.getElementById("details_chambre");
        var details_personne_chambreField = document.getElementById("details_personne_chambre");
        var details_superficie_chambreField = document.getElementById("details_superficie_chambre");

        if (libelleType === "Solo") {
            codTypField.value = "01";
            puField.value = "15000";
            detailsField.value = "La chambre solo allie confort et fonctionnalité dans un esprit simple et chaleureux. La taille de la chambre et la vue sur la petite cour pavée rappellent Paris et ses ruelles d’antan. Devant le pupitre, le solitaire peut prendre la plume… Rien ne viendra le perturber. Elle a une superficie de 30m² et ne peut accueillir qu'un seul voyageur.";
            details_personne_chambreField.value = "1"; // Mettre à jour le nombre de personnes
            details_superficie_chambreField.value = "30m²"; // Mettre à jour la superficie
        } else if (libelleType === "Double") {
            codTypField.value = "02";
            puField.value = "25000";
            detailsField.value = "Profitez du balcon et de la vue sur l'esplanade. Cette chambre est conçue pour héberger deux personnes et est équipée d'un grand lit standard (140-160*200) ou de deux lits simples (90*200) et a une superficie de 50m².";
            details_personne_chambre.value = "2";
            details_superficie_chambreField.value = "50m²";
        } else if (libelleType === "Triple") {
            codTypField.value = "03";
            puField.value = "35000";
            detailsField.value = "Idéal pour les excursions en petits groupes. Elle est équipée de 3 couchages et peut donc accueillir 3 personnes. La configuration peut être 3 lits d'une personne ou bien 1 lit double de 2 personnes et 1 d'une personne avec un canapé et a une superficie de 70m².";
            details_personne_chambre.value = "3";
            details_superficie_chambreField.value = "70m²";
        } else if (libelleType === "Suite") {
            codTypField.value = "04";
            puField.value = "50000";
            detailsField.value = "Il possède généralement une salle de bain attenante, un salon et la plupart du temps, un coin repas avec une vue imprenable. Elle a une superficie de 100m² et peut accueillir jusqu'à cinq voyageurs.";
            details_personne_chambre.value = "5";
            details_superficie_chambreField.value = "100m²";
        } else {
            codTypField.value = "";
            puField.value = "";
            detailsField.value = "";
            details_personne_chambre.value = "";
            details_superficie_chambreField.value = "";
        }
    }

    // Appeler la fonction lorsque le libellé du type de chambre change
    var libelleTypeField = document.getElementById("libelle_type");
    libelleTypeField.addEventListener("change", updateFields);

    // Appeler la fonction au chargement de la page
    updateFields();
</script>