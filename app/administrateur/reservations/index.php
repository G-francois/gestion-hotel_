<?php
if (!check_if_user_connected_admin()) {
    header('location: ' . PATH_PROJECT . 'administrateur/connexion/index');
    exit;
}


include './app/commum/header.php';

include './app/commum/aside.php';

$liste_chambre = recuperer_infos_chambre();

$liste_utilisateur = recuperer_liste_utilisateurs();

// Appeler la fonction pour récupérer la liste des clients
$liste_clients = recuperer_liste_clients_actifs();

?>


<section style="padding: 10px 0;">
    <div class="container-fluid" id="alertContainer">
        <!-- Titre de la page -->
        <div class="pagetitle">
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a style="text-decoration: none; color: #cda45e;" href="<?= PATH_PROJECT ?>administrateur/dashboard/index">Dashboard</a></li>
                    <li class="breadcrumb-item active">Ajouter une reservation</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-5 pb-3">
                <span id="container"></span>
                <div class="accordion" id="accordionExample" style="margin-top: 30px;">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button text-danger fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                IMPORTANT ! LISEZ-MOI
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body" style="color: black;">
                                <ol>
                                    <li>
                                        <strong>Selon le type de chambre choisi, il y a un nombre maximum d'accompagnateurs qu'il est possible d'ajouter.</strong>
                                        <ul>
                                            <li>
                                                Type Solo : Maximum 1 accompagnateur
                                            </li>
                                            <li>
                                                Type Double : Maximum 2 accompagnateurs
                                            </li>
                                            <li>
                                                Type Triple : Maximum 3 accompagnateurs
                                            </li>
                                            <li>
                                                Type Suite : Maximum 4 accompagnateurs
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <strong>Une même chambre ne peut être ajouter plusieurs fois sur une même réservation.</strong>
                                    </li>
                                </ol>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card-body px-0">
                    <!-- <div style="border-radius: 30px; border: beige solid; padding: 20px;"> -->
                    <form id="reservation" data-endpoint="<?= PATH_PROJECT ?>administrateur/reservations/traitement_reservations">

                        <!-- Le champ email -->
                        <div class="col-md-12 mb-4" style="padding-left: 0px;">
                            <label for="email"> Email du Client :
                                <span class="text-danger">(*)</span>
                            </label>

                            <!-- Champ de sélection dynamique avec les adresses e-mail -->
                            <select name="email" class="js-example-basic-single" style="width: 100%;">
                                <option value="">Sélectionnez un e-mail existant</option>
                                <?php foreach ($liste_clients as $client) : ?>
                                    <option><?= $client['email'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($erreurs["email"]) && !empty($erreurs["email"])) { ?>
                                <span class="text-danger">
                                    <?= $erreurs["email"]; ?>
                                </span>
                            <?php } ?>
                        </div>

                        <!-- Le champ Numéro de chambre -->
                        <div class="col-md-12 mb-4" style="padding-left: 0rem;">
                            <label for="num_chambre">Chambres :
                                <span class="text-danger">(*)</span>
                            </label>
                            <select class="form-control chambre-select" id="num_chambre" name="chambre1[num]" style=" color:black;">
                                <option value="" data-type="standard" data-prix="0">Sélectionnez le numéro de chambre</option>

                                <?php
                                foreach ($liste_chambre as $chambre) {
                                    $option_value = 'Chambre N°' . $chambre['num_chambre'] . ' - Type : ' . $chambre['lib_typ'];
                                    $prix_par_chambre = $chambre['pu'];
                                    echo '<option value="' . $chambre['num_chambre'] . '&' . $chambre['lib_typ'] . '" data-type="' . $chambre['lib_typ'] . '" data-prix="' . $prix_par_chambre[$chambre['num_chambre']] . '">' . $option_value . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Le champ nom et contact accompagnateur -->
                        <div class="row">
                            <!-- Le champ nom_acc -->
                            <div class="col-md-6 mb-1">
                                <label for="modification-nom_acc">
                                    Nom de l'accompagnateur:
                                </label>
                                <input type="text" name="chambre1[ACCS][acc1][nom_acc]" id="modification-nom_acc" class="form-control">
                            </div>

                            <!-- Le champ contact_acc -->
                            <div class="col-md-5 mb-1">
                                <label for="modification-contact_acc">
                                    Contact de l'accompagnateur:
                                </label>
                                <input type="text" name="chambre1[ACCS][acc1][contact_acc]" id="modification-contact_acc" class="form-control">
                            </div>

                            <!-- Bouton pour ajouter un accompagnateur -->
                            <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center;margin-top:2rem;">
                                <button type="button" class="btn btn-success ajouter-accompagnateur-btn">+</button>
                            </div>


                            <!-- Conteneur pour les champs d'accompagnateur dynamiques -->
                            <div id="champs-accompagnateur-dynamiques-container">
                                <!-- Les champs d'accompagnateur seront ajoutés ici en fonction des boutons "+" -->
                            </div>
                        </div>

                        <!-- Le champ début et fin occupation -->
                        <div class="row">
                            <!-- Le champ date de début occupation -->
                            <div class="col-md-6 mb-1">
                                <label for="inscription-deb_occ">
                                    Début de séjour:
                                    <span class="text-danger">(*)</span>
                                </label>
                                <div class="input-group mb-3">
                                    <input type="date" name="chambre1[deb_occ]" id="inscription-deb_occ" class="form-control" placeholder="Veuillez entrer votre date de début occupation" min="<?= date('Y-m-d'); ?>" value="" required>
                                </div>
                                <?php if (isset($erreurs["deb_occ"]) && !empty($erreurs["deb_occ"])) { ?>
                                    <span class="text-danger">
                                        <?php echo $erreurs["deb_occ"]; ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <!-- Le champ date de fin occupation -->
                            <div class="col-md-6 mb-1">
                                <label for="inscription-fin_occ">
                                    Fin de séjour:
                                    <span class="text-danger">(*)</span>
                                </label>
                                <div class="input-group mb-3">
                                    <input type="date" name="chambre1[fin_occ]" id="inscription-fin_occ" class="form-control" placeholder="Veuillez entrer votre date de fin occupation" min="<?= date('Y-m-d'); ?>" value="" required>
                                </div>

                                <?php if (isset($erreurs["fin_occ"]) && !empty($erreurs["fin_occ"])) { ?>
                                    <span class="text-danger">
                                        <?php echo $erreurs["fin_occ"]; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- </div> -->


                        <div class="col-lg-12 mt-4">
                            <!-- <h5 style="font-weight: bold">Nombre total de jours : <span id="nombre_jour">0</span></h5> -->
                            <!-- <h5 style="font-weight: bold">Montant total : <span id="prix_total">0</span> </h5> -->
                        </div>

                        <!-- Bouton pour ajouter un conteneur -->
                        <div class="col-md-12 mb-3" style="justify-content: center; display: flex;">
                            <button type="button" class="btn btn-success" id="ajouter-chambres">Ajouter une chambre</button>
                        </div>

                        <!-- Conteneur pour les champs de chambre dynamiques -->
                        <div id="champs-chambres-dynamiques-container">
                            <!-- Les champs de chambre seront ajoutés ici en fonction des boutons "+" et "-" -->
                        </div>

                        <!-- Bouton pour supprimer un conteneur (initialisé comme caché) -->
                        <div class="col-md-12 mb-3" style="justify-content: center; display: flex; display: none;" id="retirer-chambre-container">
                            <button type="button" class="btn btn-danger" id="retirer-chambre" style="--bs-btn-color: #fff; --bs-btn-bg: #b30617; --bs-btn-border-color: #b30617;">Retirer une chambre</button>
                        </div>

                        <br>

                        <div class="float-right" style="text-align: right;">
                            <button type="reset" class="btn btn-danger">
                                Annuler
                            </button>
                            <button type="submit" id="submitButton" class="btn btn-primary">
                                <span>Enregistrer</span>
                                <span class="loader"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ajouterAccompagnateurBtn = document.querySelector('.ajouter-accompagnateur-btn');
        //var ajouterAccompagnateur2Btn = document.querySelector('.ajouter-accompagnateur2-btn');
        var ajouterChambreBtn = document.querySelector('#ajouter-chambres');
        var retirerChambreBtn = document.querySelector('#retirer-chambre');
        var incAc = 2

        // Écouteur d'événement pour le bouton "+" (ajouter accompagnateur)
        ajouterAccompagnateurBtn.addEventListener('click', function() {
            // Ajoutez ici le code pour ajouter dynamiquement les champs d'accompagnateur
            var container = document.getElementById('champs-accompagnateur-dynamiques-container');
            var nouvelAccompagnateur = document.createElement('div');
            nouvelAccompagnateur.innerHTML = `
            <div class="row">
                <div class="col-md-6 mb-1">
                    <label for="nouveau-nom_acc">Nom de l'accompagnateur:</label>
                    <input type="text" name="chambre1[ACCS][acc${incAc}][nom_acc]" class="form-control">
                </div>
                <div class="col-md-5 mb-1">
                    <label for="nouveau-contact_acc">Contact de l'accompagnateur:</label>
                    <input type="text" name="chambre1[ACCS][acc${incAc}][contact_acc]" class="form-control">
                </div>

                <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 2rem;">
                    <button type="button" class="btn btn-danger" onclick="supprimerAccompagnateur(this)">-</button>
                </div>
            </div>
        `;
            container.appendChild(nouvelAccompagnateur);
            incAc++
        });

        var incCh = 1

        // Écouteur d'événement pour le bouton "Ajouter une chambre"
        ajouterChambreBtn.addEventListener('click', function(event) {
            // Ajoutez ici le code pour ajouter dynamiquement les champs pour une nouvelle chambre
            //console.log(event.target)
            if (event.target === ajouterChambreBtn) {
                incCh++
                var container = document.getElementById('champs-chambres-dynamiques-container');
                var nouvelleChambre = document.createElement('div');
                nouvelleChambre.innerHTML = `
                <!-- Le champ Numéro de chambre -->
                <div class="col-md-12 mb-3" style="padding-left: 0rem;">
                    <label for="num_chambre">Chambres :
                        <span class="text-danger">(*)</span>
                    </label>
                    <select class="form-control num_chambre" name="chambre${incCh}[num]" required>
                        <option value="" data-type="standard">Sélectionnez le numéro de chambre</option>
                        <?php
                        $liste_chambre = recuperer_infos_chambre();
                        foreach ($liste_chambre as $chambre) {
                            $option_value = 'Chambre N°' . $chambre['num_chambre'] . ' - Type : ' . $chambre['lib_typ'];
                            echo '<option value="' . $chambre['num_chambre'] . '&' . $chambre['lib_typ'] . '" data-type="' . $chambre['lib_typ'] . '">' . $option_value . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Le champ nom et contact accompagnateur -->
                <div class="row">
                    <!-- Le champ nom_acc -->
                    <div class="col-md-6 mb-1">
                        <label for="modification-nom_acc">Nom de l'accompagnateur:</label>
                        <input type="text" name="chambre${incCh}[ACCS][acc1][nom_acc]" class="form-control">
                    </div>

                    <!-- Le champ contact_acc -->
                    <div class="col-md-5 mb-1">
                        <label for="modification-contact_acc">Contact de l'accompagnateur:</label>
                        <input type="text" name="chambre${incCh}[ACCS][acc1][contact_acc]" class="form-control">
                    </div>

                    <!-- Bouton pour ajouter un accompagnateur -->
                    <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 2rem;">
                        <button type="button" class="btn btn-success ajouter-accompagnateur2-btn">+</button>
                    </div>

                    <!-- Conteneur pour les champs d'accompagnateur dynamiques -->
                    <div class="champs-accompagnateur2-dynamiques-container">
                        <!-- Les champs d'accompagnateur seront ajoutés ici en fonction des boutons "+" -->
                    </div>
                </div>

                <!-- Le champ début et fin occupation -->
                <div class="row">
                    <!-- Le champ date de début occupation -->
                    <div class="col-md-6 mb-1">
                        <label for="inscription-deb_occ">Début de séjour:
                            <span class="text-danger">(*)</span>
                        </label>
                        <div class="input-group mb-3">
                            <input type="date" name="chambre${incCh}[deb_occ]" class="form-control" placeholder="Veuillez entrer votre date de début occupation"  min="<?= date('Y-m-d'); ?>" value="" required>
                        </div>
                    </div>

                    <!-- Le champ date de fin occupation -->
                    <div class="col-md-6 mb-1">
                        <label for="inscription-fin_occ">Fin de séjour:
                            <span class="text-danger">(*)</span>
                        </label>
                        <div class="input-group mb-3">
                            <input type="date" name="chambre${incCh}[fin_occ]" class="form-control" placeholder="Veuillez entrer votre date de fin occupation"  min="<?= date('Y-m-d'); ?>" value="" required>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-4">
                        <!-- <h5 style="font-weight: bold">Nombre total de jours : <span id="nombre_jour">0</span></h5>-->
                        <!-- <h5 style="font-weight: bold">Montant total : <span id="prix_total">0</span> </h5> -->
                    </div>

                    <!-- Bouton pour supprimer un conteneur -->
                    <div class="col-md-12 mb-3" style="justify-content: center; display: flex;">
                        <button type="button" class="btn btn-danger" onclick="retirerChambre(this)" style="--bs-btn-color: #fff; --bs-btn-bg: #b30617; --bs-btn-border-color: #b30617;">Retirer une chambre</button>
                    </div>
                </div>
                `;
                container.appendChild(nouvelleChambre);
            }


            // Get the newly created elements
            var numResSelect = nouvelleChambre.querySelector('.num_chambre');

            // Add event listeners to the new elements
            numResSelect.addEventListener('change', function() {
                var selectedOption = numResSelect.options[numResSelect.selectedIndex];
                var typeChambre = selectedOption.getAttribute('data-type');
                var typeChambreInput = nouvelleChambre.querySelector('.typeChambre');
                typeChambreInput.value = typeChambre;
            });

            var ajouterAccompagnateur2Btn = nouvelleChambre.querySelector('.ajouter-accompagnateur2-btn');
            //console.log(ajouterAccompagnateur2Btn)
            var incAcc = 2

            ajouterAccompagnateur2Btn.addEventListener('click', function(event) {
                // Ajoutez ici le code pour ajouter dynamiquement les champs d'accompagnateur
                //console.log(event.target === ajouterAccompagnateur2Btn)
                if (event.target === ajouterAccompagnateur2Btn) {
                    var container = nouvelleChambre.querySelector('.champs-accompagnateur2-dynamiques-container');
                    var nouvelAccompagnateur2 = document.createElement('div');
                    nouvelAccompagnateur2.innerHTML = `
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <label for="nouveau-nom_acc">Nom de l'accompagnateur:</label>
                        <input type="text" name="chambre${incCh}[ACCS][acc${incAcc}][nom_acc]" class="form-control">
                    </div>
                    <div class="col-md-5 mb-1">
                        <label for="nouveau-contact_acc">Contact de l'accompagnateur:</label>
                        <input type="text" name="chambre${incCh}[ACCS][acc${incAcc}][contact_acc]" class="form-control">
                    </div>

                    <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 2rem;">
                        <button type="button" class="btn btn-danger" onclick="supprimerAccompagnateur(this)">-</button>
                    </div>
                </div>
            `;
                    container.appendChild(nouvelAccompagnateur2);
                    incAcc++
                }
            });
        });

    });

    // Fonction pour supprimer un champ d'accompagnateur
    function supprimerAccompagnateur(element) {
        var row = element.closest('.row');
        row.remove();
    }



    // Fonction pour retirer une chambre
    function retirerChambre(element) {
        var container = document.getElementById('champs-chambres-dynamiques-container');
        var dernierChambre = container.lastElementChild;
        if (dernierChambre) {
            container.removeChild(dernierChambre);
        }
    }
</script>




<!-- <script>
    // Fonction pour calculer le nombre de jours entre deux dates
    function calculerDifferenceJours(debut, fin) {
        const diffTime = Math.abs(fin - debut);
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1; // Ajouter 1 jour
        return diffDays;
    }

    function mettreAJourPrix() {
        const select = document.getElementById('num_chambre');
        const selectedOption = select.options[select.selectedIndex];
        const prixParJour = parseFloat(selectedOption.getAttribute('data-prix')); // Assurez-vous que le prix est un nombre

        // Ajout de la sortie console pour vérifier le prix
        console.log('Prix récupéré:', prixParJour);

        const dateDebut = new Date(document.getElementById('inscription-deb_occ').value);
        const dateFin = new Date(document.getElementById('inscription-fin_occ').value);

        if (dateFin <= dateDebut) {
            alert("La date de fin doit être après la date de début.");
            document.getElementById('nombre_jour').innerText = '0';
            document.getElementById('prix_total').innerText = '0 F';
            return;
        }

        const jours = calculerDifferenceJours(dateDebut, dateFin);
        const montantTotal = prixParJour * jours;

        document.getElementById('nombre_jour').innerText = jours.toString();
        document.getElementById('prix_total').innerText = montantTotal.toFixed(2) + ' F'; // Utiliser toFixed pour formater en deux décimales
    }

    // Écouteurs d'événements pour mettre à jour les calculs lorsqu'une date est changée
    document.getElementById('inscription-deb_occ').addEventListener('change', mettreAJourPrix);
    document.getElementById('inscription-fin_occ').addEventListener('change', mettreAJourPrix);

    // Appeler la fonction initiale pour afficher le montant total au chargement de la page
    mettreAJourPrix();
</script> -->


<!-- <script>
    // Fonction pour afficher/cacher les ensembles de champs d'accompagnateurs en fonction du nombre sélectionné
    function toggleAccompagnateursFields() {
        var nombreAccompagnateurs = parseInt(document.getElementById("nombre-accompagnateurs").value);

        for (var i = 1; i <= 4; i++) {
            var accompagnateurFields = document.getElementById("accompagnateur-" + i);

            if (accompagnateurFields) {
                // Vérifier si l'élément existe avant d'accéder à sa propriété style
                if (i <= nombreAccompagnateurs) {
                    accompagnateurFields.style.display = "flex";
                } else {
                    accompagnateurFields.style.display = "none";
                }
            } else {
                console.error("Element not found: accompagnateur-" + i);
            }
        }
    }


    function toggleAccompagnateursFields() {
        var nombreAccompagnateurs = parseInt(document.getElementById("nombre-accompagnateurs").value);

        for (var i = 1; i < 3; i++) {
            var accompagnateurFields = document.getElementById("accompagnateur-" + i);

            if (accompagnateurFields) {
                // Vérifier si l'élément existe avant d'accéder à sa propriété style
                if (i <= nombreAccompagnateurs) {
                    accompagnateurFields.style.display = "flex";
                } else {
                    accompagnateurFields.style.display = "none";
                }
            } else {
                console.error("Element not found: accompagnateur-" + i);
            }
        }
    }
</script> -->
<?php
include './app/commum/footer.php'

?>