<?php
if (!check_if_user_connected_client()) {
    header('location: ' . PATH_PROJECT . 'client/connexion/index');
    exit;
}

include('./app/commum/header_client.php');

$liste_chambre = recuperer_infos_chambre();

?>

<style>
    .btn-custom {
        --bs-btn-color: #fff;
        --bs-btn-border-color: #000000;
        --bs-btn-bg: #cda45e;
        --bs-btn-hover-bg: #9d6b15;
        --bs-btn-hover-border-color: #9d6b15;
    }

    .btn-danger-custom {
        --bs-btn-color: #fff;
        --bs-btn-bg: #3b070c;
        --bs-btn-border-color: #3b070c;
        --bs-btn-hover-bg: #b30617;
        --bs-btn-hover-border-color: #b30617;
    }

    .btn-success-custom {
        --bs-btn-color: #fff;
        --bs-btn-bg: #013534;
        --bs-btn-border-color: #000000;
        --bs-btn-hover-bg: #9d6b15;
        --bs-btn-hover-border-color: #000000;
    }

    .loader {
        display: none;
        border: 3px solid #000000;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .loader.show {
        display: inline-block;
    }
</style>

<section>
    <div class="container" id="alertContainer">
        <section id="hero4" class="d-flex align-items-center">
            <div class="container-fluid position-relative text-center text-lg-start aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
                <div class="row mt-2">
                    <div class="col-lg-12 mt-3 mb-3" style="display: flex; justify-content: space-between; align-items: center;">
                        <h1>Espace<span> Réservation</span></h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            <!-- <h1 class="h3 mt-3">Effectuer une réservation</h1> -->

            <span id="container"></span>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button text-danger fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            IMPORTANT ! LISEZ-MOI
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ol>
                                <li>
                                    <strong>Selon le type de chambre choisi, il y a un nombre maximum
                                        d'accompagnateurs qu'il est possible d'ajouter.</strong>
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
                                    <strong>Une même chambre ne peut être ajoutée plusieurs fois sur une même
                                        réservation.</strong>
                                </li>
                                <li>
                                    <strong>La date de début de séjour dans une chambre ne peut être antérieure à la
                                        date actuelle (<?= date('d / m / Y') ?>).</strong>
                                </li>
                            </ol>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-2 border-0 rounded-0">
                <div class="row" style="background-color: #0c0b09">
                    <!-- <div class="col-md-6">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?= PATH_PROJECT ?>public/images/Chambres/Solo/Solo5.JPG" alt="" class="img-fluid" />
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= PATH_PROJECT ?>public/images/Chambres/Suites/Suites5.JPG" class="d-block w-100" alt="..." />
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= PATH_PROJECT ?>public/images/Chambres/Doubles/Doubles.JPG" class="d-block w-100" alt="..." />
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= PATH_PROJECT ?>public/images/Chambres/Triples/Triples5.JPG" class="d-block w-100" alt="..." />
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
                    </div> -->

                    <div class="col-md-6">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">

                                <?php
                                // Utilisez votre fonction pour récupérer la liste des chambres
                                $listeChambres = recuperer_liste_chambres();

                                // Boucle à travers les chambres
                                foreach ($listeChambres as $index => $chambre) {
                                    $type = $chambre['lib_typ'];
                                    $image = $chambre['photos']; // Assurez-vous que votre table contient une colonne pour le chemin de l'image

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
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card-body px-0">
                            <!-- <div style="border-radius: 30px; border: beige solid; padding: 20px;"> -->
                            <form id="reservation"
                                data-endpoint="<?= PATH_PROJECT ?>client/chambres/traitement_reservations">

                                <!-- Le champ Numéro de chambre -->
                                <div class="col-md-12 mb-3">
                                    <label for="num_chambre">Chambres :
                                        <span class="text-danger">(*)</span>
                                    </label>
                                    <select class="form-control chambre-select" id="num_chambre"
                                        name="chambre1[num]" required>
                                        <option value="">Sélectionnez le numéro de chambre</option>

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
                                        <input type="text" name="chambre1[ACCS][acc1][nom_acc]"
                                            id="modification-nom_acc" class="form-control">
                                    </div>

                                    <!-- Le champ contact_acc -->
                                    <div class="col-md-5 mb-1">
                                        <label for="modification-contact_acc">
                                            Contact de l'accompagnateur:
                                        </label>
                                        <input type="text" name="chambre1[ACCS][acc1][contact_acc]"
                                            id="modification-contact_acc" class="form-control">
                                    </div>

                                    <!-- Bouton pour ajouter un accompagnateur -->
                                    <div class="col-md-1 mb-3"
                                        style="display: flex; align-items: flex-end; justify-content: center; margin-top: 21px;">
                                        <button type="button" class="btn btn-custom ajouter-accompagnateur-btn">+
                                        </button>
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
                                            Début de séjour :
                                            <span class="text-danger">(*)</span>
                                        </label>
                                        <div class="input-group mb-3">
                                            <input type="date" name="chambre1[deb_occ]" id="inscription-deb_occ"
                                                class="form-control"
                                                placeholder="Veuillez entrer votre date de début occupation"
                                                value="" min="<?= date('Y-m-d'); ?>" required>
                                        </div>
                                        <?php if (isset($erreurs["deb_occ"]) && !empty($erreurs["deb_occ"])) { ?>
                                            <span class="text-danger">
                                                <?php echo $erreurs["deb_occ"]; ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                    <!-- Le champ date de fins occupations -->
                                    <div class="col-md-6 mb-1">
                                        <label for="inscription-fin_occ">
                                            Fin de séjour:
                                            <span class="text-danger">(*)</span>
                                        </label>
                                        <div class="input-group mb-3">
                                            <input type="date" name="chambre1[fin_occ]" id="inscription-fin_occ"
                                                class="form-control"
                                                placeholder="Veuillez entrer votre date de fin occupation"
                                                value="" min="<?= date('Y-m-d'); ?>" required>
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
                                    <button type="button" class="btn btn-custom" id="ajouter-chambres">Ajouter une
                                        chambre
                                    </button>
                                </div>


                                <!-- Conteneur pour les champs de chambre dynamiques -->
                                <div id="champs-chambres-dynamiques-container">
                                    <!-- Les champs de chambre seront ajoutés ici en fonction des boutons "+" et "-" -->
                                </div>

                                <!-- Bouton pour supprimer un conteneur (initialisé comme caché) -->
                                <div class="col-md-12 mb-3"
                                    style="justify-content: center; display: none;"
                                    id="retirer-chambre-container">
                                    <button type="button" class="btn btn-danger" id="retirer-chambre"
                                        style="--bs-btn-color: #fff; --bs-btn-bg: #b30617; --bs-btn-border-color: #b30617;">
                                        Retirer une chambre
                                    </button>
                                </div>

                                <div class="float-right" style="text-align: right;">
                                    <button type="reset" class="btn btn-danger-custom">
                                        Annuler
                                    </button>
                                    <button type="submit" id="submitButton" class="btn btn-success-custom">
                                        <span>Enregistrer</span>
                                        <span class="loader"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
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

                <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 21px;">
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
                <div class="col-md-12 mb-3">
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
                    <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 21px;">
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
                            <input type="date" name="chambre${incCh}[deb_occ]" class="form-control" placeholder="Veuillez entrer votre date de début occupation" value="" min="<?= date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <!-- Le champ date de fin occupation -->
                    <div class="col-md-6 mb-1">
                        <label for="inscription-fin_occ">Fin de séjour:
                            <span class="text-danger">(*)</span>
                        </label>
                        <div class="input-group mb-3">
                            <input type="date" name="chambre${incCh}[fin_occ]" class="form-control" placeholder="Veuillez entrer votre date de fin occupation" value="" min="<?= date('Y-m-d'); ?>" required>
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


            // // Get the newly created elements
            // var numResSelect = nouvelleChambre.querySelector('.num_chambre');

            // // Add event listeners to the new elements
            // numResSelect.addEventListener('change', function() {
            //     var selectedOption = numResSelect.options[numResSelect.selectedIndex];
            //     var typeChambre = selectedOption.getAttribute('data-type');
            //     var typeChambreInput = nouvelleChambre.querySelector('.typeChambre');
            //     typeChambreInput.value = typeChambre;
            // });

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

                    <div class="col-md-1 mb-3" style="display: flex; align-items: flex-end; justify-content: center; margin-top: 21px;">
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


<?php
include('./app/commum/footer_client_icm.php');
?>