<?php

$include_client_header = true;
include('./app/commum/header_.php');

?>

<section>
    <div class="container">
        <div class="row">
            <h1 class="h3 mt-3">Commander un repas</h1>
            <div class="card my-2 border-0 rounded-0">
                <div class="row" style="background-color: #0c0b09">
                    <div class="col-md-6">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?= PATH_PROJECT ?>public/images/specials-1.png" alt="" class="img-fluid" />
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= PATH_PROJECT ?>public/images/specials-3.png" class="d-block w-100" alt="..." />
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= PATH_PROJECT ?>public/images/specials-4.png" class="d-block w-100" alt="..." />
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <!-- <div class="col-md-6">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">

                                <?php
                                // Utilisez votre fonction pour récupérer la liste des repas
                                $listeRepas = recuperer_liste_repas();

                                // Boucle à travers les repas
                                foreach ($listeRepas as $index => $repas) {
                                    $type = $repas['categorie'];
                                    $image = $repas['photos']; // Assurez-vous que votre table contient une colonne pour le chemin de l'image

                                    // Ajoutez la classe active à la première chambre
                                    $activeClass = ($index === 0) ? 'active' : '';
                                ?>

                                    <div class="carousel-item <?= $activeClass; ?>">
                                        <img src="<?= $image ?>" alt="<?= $type ?>" class="img-fluid" />
                                    </div>

                                <?php
                                }
                                ?>

                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div> -->


                    <div class="col-md-6">
                        <div class="card-body px-0">
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
                            <?php
                            if (check_if_user_connected_client()) {
                            ?>
                                <h5 style="color: #cda45e; text-align:center; margin-bottom: 20px;">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Vous pouvez consulter la liste de vos commande dans le tableau de bord liste des commandes après une commande.
                                </h5>
                            <?php
                            }
                            ?>
                            <form action="<?= PATH_PROJECT ?>client/restaurant/traitement-commande" method="post" class="user">

                                <!-- Le champ numéro de réservation -->
                                <div class="col-md-12 mb-3">
                                    <label for="num_chambre">Numéro de la chambre :
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <input type="number" name="num_chambre" id="num_chambre" class="form-control" placeholder="Entrez le numéro de la chambre" required>
                                    <?php if (isset($erreurs["num_chambre"]) && !empty($erreurs["num_chambre"])) { ?>
                                        <span class="text-danger">
                                            <?= $erreurs["num_chambre"]; ?>
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
                                    <div class="col-md-4 mb-3">
                                        <label for="pu_repas">Prix :</label>
                                        <input type="text" class="form-control" placeholder="Prix total du repas" id="pu_repas" name="pu_repas[]" readonly>
                                        <?php if (isset($erreurs["pu_repas"]) && !empty($erreurs["pu_repas"])) { ?>
                                            <span class="text-danger">
                                                <?= $erreurs["pu_repas"]; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                    <!-- Bouton pour ajouter un repas -->
                                    <div class="col-md-2 mb-3" style="display: flex; align-items: flex-end; justify-content: center;">
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

                                <div class="float-right" style="text-align: right;">
                                    <button type="reset" class="btn btn-danger" style="--bs-btn-color: #fff; --bs-btn-bg: #3b070c; --bs-btn-border-color: #3b070c; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #b30617; --bs-btn-hover-border-color: #b30617;">
                                        Annuler
                                    </button>
                                    <button type="submit" name="enregistrer" class="btn btn-success" style="--bs-btn-color: #fff; --bs-btn-bg: #013534; --bs-btn-border-color: #000000; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #9d6b15; --bs-btn-hover-border-color: #000000;">
                                        Enregistrer
                                    </button>
                                </div>

                                <div id="total-price"></div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



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
        totalElement.textContent = `Total: ${formattedTotal} FCFA`;
    }
</script>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fonction pour mettre à jour le prix du repas
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

        // Mise à jour du montant total lors du changement de sélection
        updateMontantTotal();

        // Gestionnaire d'événement pour le changement de sélection
        document.getElementById("nom_repas").addEventListener("change", updateMealPrice);


        // Fonction pour supprimer un champ de repas
        function supprimerRepas(idRepas) {
            const champRepas = document.getElementById(`repas-${idRepas}`);
            if (champRepas) {
                champRepas.remove();
                compteurRepas--;
                updateMontantTotal(); // Update total price immediately after removing a meal
            }
        }
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

            // Display the total price in the "total-price" element
            const totalElement = document.getElementById("total-price");
            totalElement.textContent = "Total: F" + total.toFixed(); // Format total to two decimal places
        }

        // Fonction pour supprimer un champ de repas
        function supprimerRepas(idRepas) {
            const champRepas = document.getElementById(`repas-${idRepas}`);
            if (champRepas) {
                champRepas.remove();
                compteurRepas--;
                updateMontantTotal(); // Update total price immediately after removing a meal
            }
        }

        // Initialise le compteur de champs de repas
        let compteurRepas = 1;

        // Fonction pour ajouter un champ de repas
        function ajouterRepas() {
            compteurRepas++;
            const champRepas = `
            <div class="row" id="repas-${compteurRepas}">
                <div class="col-md-6 mb-3">
                    <label for="nom_repas-${compteurRepas}">Nom du Repas : <span class="text-danger">(*)</span></label>
                    <select class="form-control nom_repas" id="nom_repas-${compteurRepas}" name="nom_repas-${compteurRepas}">
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
                    <input type="text" class="form-control pu_repas" placeholder="Le prix du repas sera automatiquement rempli" id="pu_repas-${compteurRepas}" name="pu_repas-${compteurRepas}" readonly>
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

    });
</script> -->



<?php
// Supprimer les variables de session
unset($_SESSION['commande-message-success-global'], $_SESSION['commande-message-erreur-global'], $_SESSION['donnees-commande'], $_SESSION['erreurs-commande']);

$include_icm_footer = true;
include('./app/commum/footer_.php');
?>