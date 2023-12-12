<?php
if (!check_if_user_connected_recept()) {
    header('location: ' . PATH_PROJECT . 'receptionniste/connexion/index');
    exit;
}

include './app/commum/fonction_tableau.php';

include './app/commum/header.php';

include './app/commum/aside_recept.php';

$liste_repas = recuperer_liste_repas();

// Paramètres de filtrage, recherche et pagination
$sortColumn = $_GET['sortColumn'] ?? 'cod_repas'; // Colonne de tri par défaut
$sortOrder = $_GET['sortOrder'] ?? 'asc'; // Ordre de tri par défaut
$searchTerm = $_GET['searchTerm'] ?? ''; // Terme de recherche par défaut
$filterType = $_GET['filterType'] ?? ''; // Type de filtre par défaut
$itemsPerPage = $_GET['itemsPerPage'] ?? 10; // Nombre d'éléments par page par défaut
$page = $_GET['page'] ?? 1; // Numéro de page par défaut

// Filtrage des données
$data = filtrerTableau($liste_repas, $filterType);
$data = rechercherTableau($data, $searchTerm);

// Tri des données
$data = trierTableau($data, $sortColumn, $sortOrder);

// Pagination des données
$paginationData = paginerTableau($data, $itemsPerPage, $page);
$pagedData = $paginationData['pagedData'];
$totalPages = $paginationData['totalPages'];

?>

<div class="pagetitle ml-2 mr-2">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>receptionniste/dashboard/index">Dashboard</a></li>
            <li class="breadcrumb-item active">Listes des chambres</li>
        </ol>
    </nav>
</div>

<div class="card shadow mb-4  ml-2 mr-2">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="itemsPerPage">Nombre de lignes à afficher :</label>
                <select class="form-control" id="itemsPerPage" onchange="applyFilters()">
                    <option value="10" <?php echo ($itemsPerPage == 10) ? 'selected' : ''; ?>>10</option>
                    <option value="20" <?php echo ($itemsPerPage == 20) ? 'selected' : ''; ?>>20</option>
                    <option value="30" <?php echo ($itemsPerPage == 30) ? 'selected' : ''; ?>>30</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filterType">Type de filtre :</label>
                <select class="form-control" id="filterType" onchange="applyFilters()">
                    <option value="">Tous</option>
                    <option value="disponible" <?php echo ($filterType == 'disponible') ? 'selected' : ''; ?>>Disponible</option>
                    <option value="non-disponible" <?php echo ($filterType == 'non-disponible') ? 'selected' : ''; ?>>Non disponible</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="searchTerm">Rechercher :</label>
                <input type="text" class="form-control" id="searchTerm" value="<?php echo $searchTerm; ?>" onkeyup="applyFilters()">
            </div>
            <div class="col-md-3">
                <label for="itemsPerPage">Lignes affichées : <?php echo count($pagedData); ?> / <?php echo count($data); ?></label>
            </div>
        </div>

        <div class="table-responsive">
            <?php if (!empty($pagedData)) { ?>
                <table class="table table-striped" id="" width="100%" cellspacing="0" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>Code type</th>
                            <th>Libellés</th>
                            <th>Prix</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagedData as $repas) { ?>
                            <tr>
                                <td><?php echo $repas['cod_repas']; ?></td>
                                <td><?php echo $repas['nom_repas']; ?></td>
                                <td><?php echo $repas['pu_repas']; ?></td>
                                <td>
                                    <button class="btn <?php echo ($repas['est_actif'] == 1 && $repas['est_supprimer'] == 0) ? 'btn-success' : 'btn-danger'; ?> ">
                                        <?php echo ($repas['est_actif'] == 1 && $repas['est_supprimer'] == 0) ? 'Disponible' : 'Non disponible'; ?>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>Aucun repas n'a été trouvé !!!</p>
            <?php } ?>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <?php if ($page > 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?sortColumn=<?php echo $sortColumn; ?>&sortOrder=<?php echo $sortOrder; ?>&searchTerm=<?php echo $searchTerm; ?>&filterType=<?php echo $filterType; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&page=<?php echo $page - 1; ?>" tabindex="-1" aria-disabled="true">Précédent</a>
                            </li>
                        <?php } ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?sortColumn=<?php echo $sortColumn; ?>&sortOrder=<?php echo $sortOrder; ?>&searchTerm=<?php echo $searchTerm; ?>&filterType=<?php echo $filterType; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($page < $totalPages) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?sortColumn=<?php echo $sortColumn; ?>&sortOrder=<?php echo $sortOrder; ?>&searchTerm=<?php echo $searchTerm; ?>&filterType=<?php echo $filterType; ?>&itemsPerPage=<?php echo $itemsPerPage; ?>&page=<?php echo $page + 1; ?>">Suivant</a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>


<script>
    function applyFilters() {
        var itemsPerPage = document.getElementById('itemsPerPage').value;
        var filterType = document.getElementById('filterType').value;
        var searchTerm = document.getElementById('searchTerm').value;

        var url = "?sortColumn=<?php echo $sortColumn; ?>&sortOrder=<?php echo $sortOrder; ?>&itemsPerPage=" + itemsPerPage + "&filterType=" + filterType + "&searchTerm=" + searchTerm;

        window.location.href = url;
    }
</script>


<?php
include './app/commum/footer.php';
?>