<?php
if (!check_if_user_connected_admin()) {
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside.php';

// Appeler la fonction pour récupérer la liste des clients
$liste_clients = recuperer_liste_clients_actifs();

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Titre de la page -->
    <div class="pagetitle ">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                <li class="breadcrumb-item active">Ajouter une commande</li>
            </ol>
        </nav>
    </div>


    <?php
    // Vérifie s'il y a un message de succès global à afficher
    if (isset($_SESSION['commande-message-success-global']) && !empty($_SESSION['commande-message-success-global'])) {
    ?>
        <div class="alert alert-primary" style="color: white; background-color: #2653d4; text-align:center; border-color: snow;">
            <?= $_SESSION['commande-message-success-global'] ?>
        </div>
    <?php
    }
    ?>
    <?php
    // Vérifie s'il y a un message d'erreur global à afficher
    if (isset($_SESSION['commande-message-erreur-global']) && !empty($_SESSION['commande-message-erreur-global'])) {
    ?>
        <div class="alert alert-primary" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
            <?= $_SESSION['commande-message-erreur-global'] ?>
        </div>
    <?php
    }
    ?>
    <form action="<?= PATH_PROJECT ?>administrateur/commandes/ajout-commande-traitement" method="post" class="user">
        <div class="form-group row pt-5">
            <!-- Le champ email -->
            <div class="col-md-6 mb-3" style="padding-right: 25px;">
                <label for="email"> Email du Client :
                    <span class="text-danger">(*)</span>
                </label>

                <!-- Champ de sélection dynamique avec les adresses e-mail -->
                <select name="email" class="js-example-basic-single" style="width: 100%;">
                    <option value="">Sélectionnez un e-mail du client existant </option>
                    <?php foreach ($liste_clients as $client) : ?>
                        <option><?= $client['email'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Le champ numéro de réservation -->
            <div class="col-md-6 mb-3">
                <label for="num_res">Numéro de Réservation :
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="num_res" id="num_res" class="form-control" placeholder="Entrez le numéro de réservation" required>
                <?php if (isset($erreurs["num_res"]) && !empty($erreurs["num_res"])) { ?>
                    <span class="text-danger">
                        <?= $erreurs["num_res"]; ?>
                    </span>
                <?php } ?>
            </div>


            <div class="row">
                <!-- Le champ Nom du Repas -->
                <div class="col-md-6 mb-3">
                    <label for="nom_repas">Nom du Repas :
                        <span class="text-danger">(*)</span>
                    </label>
                    <select class="form-control" id="nom_repas" name="nom_repas[]">
                        <option value="">Sélectionnez un repas</option>
                        <?php
                        $liste_repas = recuperer_nom_prix_repas();

                        foreach ($liste_repas as $repas) {
                            echo '<option value="' . $repas['cod_repas'] . '" data-prix="' . $repas['pu_repas'] . '">' . $repas['nom_repas'] . '</option>';
                        }
                        ?>
                    </select>
                    <?php if (isset($erreurs["nom_repas"]) && !empty($erreurs["nom_repas"])) { ?>
                        <span class="text-danger">
                            <?= $erreurs["nom_repas"]; ?>
                        </span>
                    <?php } ?>
                </div>

                <!-- Le champ Prix du Repas -->
                <div class="col-md-5 mb-3">
                    <label for="pu_repas">Prix :</label>
                    <input type="text" class="form-control" placeholder="Prix total du repas" id="pu_repas" name="pu_repas[]" readonly>
                    <?php if (isset($erreurs["pu_repas"]) && !empty($erreurs["pu_repas"])) { ?>
                        <span class="text-danger">
                            <?= $erreurs["pu_repas"]; ?>
                        </span>
                    <?php } ?>
                </div>

                <!-- Bouton pour ajouter un repas -->
                <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center;">
                    <button type="button" class="btn btn-success" id="ajouter-repas" style="--bs-btn-color: #fff; --bs-btn-bg: #cda45e; --bs-btn-border-color: #000000; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #9d6b15; --bs-btn-hover-border-color: #000000;">+</button>
                </div>
            </div>

            <!-- Conteneur pour les champs de repas dynamiques -->
            <div id="champs-repas-dynamiques-container">
                <!-- Les champs de repas seront ajoutés ici en fonction des boutons "+" -->
            </div>

            <!-- <div>
                <label for="montant-total">Montant Total :</label>
                <input type="text" class="form-control" id="montant-total" name="montant-total" readonly>
            </div> -->



            <!-- Le bouton d'ajout -->
            <div class="col-sm-6" style="margin-top: 2rem">
                <button type="submit" name="enregistrer" class="btn btn-primary btn-block">Ajouter</button>
            </div>



            <div style="margin-top: 12px; font-weight: bold; font-size: large;" id="total-price"></div>
        </div>
    </form>

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to update the meal price based on selection
        function updateMealPrice() {
            const selectElement = document.getElementById("nom_repas");
            const prixInput = document.getElementById("pu_repas");
            const selectedOption = selectElement.options[selectElement.selectedIndex];

            if (selectedOption) {
                prixInput.value = selectedOption.getAttribute("data-prix");
                updateMontantTotal(); // Update total price immediately after meal selection
            } else {
                prixInput.value = "";
            }
        }

        // Update the initial meal price when the page loads
        updateMealPrice();

        // Attach an event listener to the meal selection dropdown
        document.getElementById("nom_repas").addEventListener("change", updateMealPrice);
    });

    // Function to remove a meal
    function supprimerRepas(idRepas) {
        const champRepas = document.getElementById(`repas-${idRepas}`);
        if (champRepas) {
            champRepas.remove();
            updateMontantTotal(); // Update total price immediately after removing a meal
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialise le compteur de champs de repas
        let compteurRepas = 1;

        // Fonction pour ajouter un champ de repas
        function ajouterRepas() {
            compteurRepas++;
            const champRepas = `
                <div class="row" id="repas-${compteurRepas}">
                    <div class="col-md-6 mb-3">
                        <label for="nom_repas-${compteurRepas}">Nom du Repas : <span class="text-danger">(*)</span></label>
                        <select class="form-control nom_repas" id="nom_repas-${compteurRepas}" name="nom_repas[]-${compteurRepas}">
                            <option value="">Sélectionnez un repas</option>
                            <?php
                            $liste_repas = recuperer_nom_prix_repas();

                            foreach ($liste_repas as $repas) {
                                echo '<option value="' . $repas['cod_repas'] . '" data-prix="' . $repas['pu_repas'] . '">' . $repas['nom_repas'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pu_repas-${compteurRepas}">Prix du Repas :</label>
                        <input type="text" class="form-control pu_repas" placeholder="Le prix du repas sera automatiquement rempli" id="pu_repas-${compteurRepas}" name="pu_repas[]-${compteurRepas}" readonly>
                    </div>
                    <div class="col-md-2 mb-3" style="display: flex; align-items: flex-end; justify-content: center;">
                        <button type="button" class="btn btn-danger" onclick="supprimerRepas(${compteurRepas})" style="--bs-btn-color: #fff; --bs-btn-bg: #3b070c; --bs-btn-border-color: #3b070c; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #b30617; --bs-btn-hover-border-color: #b30617;">-</button>
                    </div>
                </div>
            `;

            document.getElementById("champs-repas-dynamiques-container").insertAdjacentHTML("beforeend", champRepas);
            updateMontantTotal(); // Update total price immediately after adding a meal
        }

        // Gestionnaire d'événements pour le bouton "+" (ajouter un repas)
        document.getElementById("ajouter-repas").addEventListener("click", ajouterRepas);

        // Gestionnaire d'événements pour le changement de sélection
        document.getElementById("champs-repas-dynamiques-container").addEventListener("change", function(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            if (selectedOption) {
                // Trouver l'élément parent du champ sélectionné
                const parentRow = event.target.closest(".row");
                const prixInput = parentRow.querySelector(".pu_repas");
                prixInput.value = selectedOption.getAttribute("data-prix");

                // Mise à jour du montant total lors du changement de sélection
                updateMontantTotal();
            }
        });

    });
</script>

<script>
    // Function to calculate the total price
    function updateMontantTotal() {
        let total = 0;

        // Include the default meal
        const defaultMealPriceInput = document.getElementById("pu_repas");
        if (defaultMealPriceInput) {
            const defaultMealPrice = parseFloat(defaultMealPriceInput.value);
            if (!isNaN(defaultMealPrice)) {
                total += defaultMealPrice;
            }
        }

        // Include the prices of dynamically added meals
        const prixInputs = document.querySelectorAll(".pu_repas");

        prixInputs.forEach(function(input) {
            const prix = parseFloat(input.value);
            if (!isNaN(prix)) {
                total += prix;
            }
        });

        // Format total price and display it in FCFA
        const totalElement = document.getElementById("total-price");
        const formattedTotal = total.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        totalElement.textContent = `Montant Total: ${formattedTotal} FCFA`;
    }
</script>

<?php
// Supprimer les variables de session
unset($_SESSION['commande-message-success-global'], $_SESSION['commande-message-erreur-global'], $_SESSION['donnees-commande'], $_SESSION['erreurs-commande']);

include './app/commum/footer.php'

?>