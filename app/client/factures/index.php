<?php
if (!check_if_user_connected_client()) {
    header('location: ' . PATH_PROJECT . 'client/connexion/index');
    exit;
}

include('./app/commum/header_client.php');


// Récupération des informations du client
$clientId   = $_SESSION['utilisateur_connecter_client']['id'];
$clientName = $_SESSION['utilisateur_connecter_client']['nom'] ?? 'Client Inconnu';

// Récupération de toutes les réservations du client
$liste_reservations = recuperer_liste_reservations($clientId);

$liste_reservations = array_filter($liste_reservations, function ($reservation) {
    return $reservation['statut'] === 'Valider';
});

// Tri des réservations par date de création décroissante (la plus récente en premier)
usort($liste_reservations, function ($a, $b) {
    return strtotime($b['creer_le']) - strtotime($a['creer_le']);
});

// Pagination : 10 réservations par page
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$totalReservations = count($liste_reservations);
$totalPages = ceil($totalReservations / $limit);
$offset = ($page - 1) * $limit;
$reservationsPage = array_slice($liste_reservations, $offset, $limit);

// Récupération de toutes les commandes du client et groupement par réservation et chambre
$liste_commandes_client = recuperer_liste_commandes_client($clientId);
// print_r(recuperer_liste_commandes_client($clientId));

$commandesGrouped = [];

if (!empty($liste_commandes_client)) {
    foreach ($liste_commandes_client as $commande) {
        $chambreId = $commande['num_chambre'];
        $commandesGrouped[$chambreId][] = $commande;
    }
}


?>


<style>
    .facture-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .reservation-block {
        border: 1px solid #ccc;
        padding: 15px;
        margin-bottom: 10px;
    }

    .chambre-block {
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
    }

    .commande-block {
        border: 1px solid #eee;
        padding: 10px;
        margin-bottom: 10px;
    }

    /* body {
        font-family: "Playfair Display", serif;
    } */
</style>


<div class="container">
    <section id="hero4" class="d-flex align-items-center">
        <div class="container position-relative text-center text-lg-start aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
            <div class="row mt-5">
                <div class="col-lg-8 mt-4 mb-4">
                    <h1>Espace<span> Facturation</span></h1>
                </div>
            </div>
        </div>
    </section>
    <!-- En-tête de la facturation -->
    <!-- <div class="facture-header">
        <p>Date : <?= date("d-m-Y H:i:s"); ?></p>
        <p>Client : <?= $clientName; ?></p>
    </div> -->

    <!-- Accordéon pour chaque réservation -->
    <div class="accordion" id="reservationAccordion">
        <?php

        foreach ($reservationsPage as $index => $reservation):
            $totalGeneral = 0; // Initialisation du total général
        ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?= $reservation['num_res']; ?>">
                    <button class="accordion-button <?= $index != 0 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $reservation['num_res']; ?>"
                        aria-expanded="<?= $index == 0 ? 'true' : 'false'; ?>"
                        aria-controls="collapse<?= $reservation['num_res']; ?>" style="font-size: smaller;">
                        Réservation N° <?= $reservation['num_res']; ?> - Créée le <?= date('d-m-Y H:i:s', strtotime($reservation['creer_le'])); ?>
                    </button>
                </h2>
                <div id="collapse<?= $reservation['num_res']; ?>" class="accordion-collapse collapse <?= $index == 0 ? 'show' : ''; ?>"
                    aria-labelledby="heading<?= $reservation['num_res']; ?>" data-bs-parent="#reservationAccordion">
                    <div class="accordion-body">
                        <!-- <p><strong>Montant Total de la Réservation :</strong> <?= $reservation['prix_total']; ?> FCFA</p> -->

                        <?php
                        // Récupération des chambres associées à la réservation
                        $liste_chambres = recuperer_liste_chambres_reservations($reservation['num_res']);
                        ?>
                        <?php if (!empty($liste_chambres)): ?>
                            <?php foreach ($liste_chambres as $chambre): ?>

                                <div class="chambre-block">
                                    <h5>Chambre N° <?= $chambre['num_chambre']; ?></h5>

                                    <!-- Liste des accompagnateurs -->
                                    <?php
                                    $accompagnateurs = recuperer_accompagnateurs_par_chambre_sur_une_reservation($reservation['num_res'], $chambre['num_chambre']);
                                    ?>
                                    <p><strong>Accompagnateurs :</strong>
                                        <?php if (!empty($accompagnateurs)): ?>
                                            <?php foreach ($accompagnateurs as $accompagnateur): ?>
                                                <?= $accompagnateur['nom_acc']; ?> (<?= $accompagnateur['contact']; ?>) <br>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            Aucun accompagnateur
                                        <?php endif; ?>
                                    </p>

                                    <?php
                                    $totalChambreAvecCommande = $chambre['montant'];
                                    if (!empty($commandesGrouped[$chambre['num_chambre']])) {
                                        foreach ($commandesGrouped[$chambre['num_chambre']] as $commande) {
                                            $totalChambreAvecCommande += $commande['prix_total'];
                                        }
                                    }
                                    $totalGeneral += $totalChambreAvecCommande; // Ajouter chaque total de chambre au total général
                                    ?>


                                    <?php
                                    // Récupération des informations sur la chambre
                                    $typ_chambre  = recuperer_type_chambre_pour_affichage($chambre['num_chambre']);
                                    $prix_chambre = recuperer_prix_chambre($typ_chambre);
                                    $deb_occ      = date('d-m-Y', strtotime($chambre['deb_occ']));
                                    $fin_occ      = date('d-m-Y', strtotime($chambre['fin_occ']));

                                    // Calcul du nombre de jours (nuitées) ; ici on ajoute 1 pour inclure la nuitée d'arrivée
                                    $dateDebut = new DateTime($chambre['deb_occ']);
                                    $dateFin   = new DateTime($chambre['fin_occ']);
                                    $diff      = $dateDebut->diff($dateFin);
                                    $jours     = $diff->days + 1;
                                    ?>
                                    <table class="table table-bordered" style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>Type de Chambre</th>
                                                <th>Prix Unitaire (FCFA)</th>
                                                <th>Date de Début</th>
                                                <th>Date de Fin</th>
                                                <th>Nombre de Jours</th>
                                                <th>Coût par Chambre (FCFA)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $typ_chambre; ?></td>
                                                <td><?= number_format($prix_chambre['montant'], 0, ',', ' '); ?></td>
                                                <td><?= $deb_occ; ?></td>
                                                <td><?= $fin_occ; ?></td>
                                                <td><?= $jours; ?> nuitée(s)</td>
                                                <td><?= number_format($chambre['montant'], 0, ',', ' '); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <?php
                                    // On vérifie si des commandes existent pour cette chambre
                                    if (!empty($commandesGrouped[$chambre['num_chambre']])): ?>
                                        <div class="commande-block">
                                            <h6>Commandes pour cette chambre :</h6>
                                            <table class="table table-striped" style="text-align: center;">
                                                <thead>
                                                    <tr>
                                                        <th>Date & Heure</th>
                                                        <th>N° Commande</th>
                                                        <th>Liste des Repas</th>
                                                        <th>Prix Unitaire (FCFA)</th>
                                                        <th>Prix Total (FCFA)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($commandesGrouped[$chambre['num_chambre']] as $commande): ?>
                                                        <tr>
                                                            <td><?= $commande['creer_le']; ?></td>
                                                            <td><?= $commande['num_cmd']; ?></td>
                                                            <td>
                                                                <?php
                                                                $repas_commande = recuperer_liste_repas_par_commande($commande['num_cmd']);
                                                                if (empty($repas_commande)) {
                                                                    echo '---';
                                                                } else {
                                                                    foreach ($repas_commande as $repas) {
                                                                        $info_repas = recuperer_info_repas($repas['cod_repas']);
                                                                        echo ($info_repas !== null) ? $info_repas['nom_repas'] . '<br>' : 'Nom du repas non disponible<br>';
                                                                    }
                                                                }
                                                                ?>
                                                            </td>

                                                            <td>
                                                                <?php
                                                                if (empty($repas_commande)) {
                                                                    echo '---';
                                                                } else {
                                                                    foreach ($repas_commande as $repas) {
                                                                        $info_repas = recuperer_info_repas($repas['cod_repas']);
                                                                        echo ($info_repas !== null)
                                                                            ? number_format($info_repas['pu_repas'], 0, ',', ' ') . '<br>'
                                                                            : '---<br>';
                                                                    }
                                                                }
                                                                ?>
                                                            </td>


                                                            <td><?= number_format($commande['prix_total'], 0, ',', ' '); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        </div>
                                        <!-- Montant Total pour cette chambre avec commande -->
                                        <p class="text-end"><strong>Montant Total (Chambre + Commande) :</strong> <?= number_format($totalChambreAvecCommande, 0, ',', ' '); ?> FCFA</p>

                                        <!-- Ajoute un élément avec la valeur PHP de Montant Total (Chambre + Commande) -->
                                        <span id="montant-total" data-total="<?= number_format($totalChambreAvecCommande, 0, ',', ' '); ?> FCFA" class="d-none"></span>



                                    <?php else: ?>
                                        <p>Aucune commande pour cette chambre.</p>
                                    <?php endif; ?>

                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucune chambre associée à cette réservation.</p>
                        <?php endif; ?>

                        <!-- Montant Total de la reservation -->
                        <div class="text-end mt-4">
                            <h4 id="montantTotal"><strong>Net à Payer :</strong> <?= number_format($totalGeneral, 0, ',', ' '); ?> FCFA</h4>
                        </div>


                        <!-- Bouton de téléchargement PDF pour cette réservation -->
                        <!-- <div class="text-end">
                            <a href="download_invoice.php?num_res=<?= $reservation['num_res']; ?>" class="btn btn-success btn-sm">
                                Télécharger la facture
                            </a>
                        </div> -->

                        <button class="btn btn-success btn-sm generate-pdf" data-reservation="<?= $reservation['num_res']; ?>">
                            Télécharger la facture en PDF
                        </button>


                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Contrôle de pagination -->
    <nav aria-label="Navigation des pages" style="margin-top: 20px;">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Précédent">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li class="page-item <?= $p == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $p; ?>"><?= $p; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Suivant">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php
include('./app/commum/footer_client_icm.php');
?>