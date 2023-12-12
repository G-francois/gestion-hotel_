<?php

if (!check_if_user_connected_recept()) {
    header('location: ' . PATH_PROJECT . 'receptionniste/connexion/index');
    exit;
}

include './app/commum/header.php';

include './app/commum/aside_recept.php';

$liste_chambre = recuperer_liste_chambres();
?>
<div class="pagetitle ml-2 mr-2">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= PATH_PROJECT ?>receptionniste/dashboard/index">Dashboard</a></li>
            <li class="breadcrumb-item active">Listes des chambres</li>
        </ol>
    </nav>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4  ml-2 mr-2">

    <div class="card-body">
        <div class="table-responsive">
            <?php if (isset($liste_chambre) && !empty($liste_chambre)) {
            ?>
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0" style="text-align:center;">
                    <thead>
                        <tr>
                            <th>Numéro de chambre</th>
                            <th>Code type</th>
                            <th>Libellés</th>
                            <th>Statut</th>
                            <th>Prix Unitaire</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($liste_chambre as $chambre) {
                        ?>
                            <tr>
                                <td><?php echo $chambre['num_chambre']; ?></td>
                                <td><?php echo $chambre['cod_typ']; ?></td>
                                <td><?php echo $chambre['lib_typ']; ?></td>
                                <td><?php echo $chambre['statut']; ?></td>
                                <td><?php echo $chambre['pu']; ?></td>
                            <?php
                        }

                            ?>
                            </tr>
                    </tbody>
                </table>
            <?php
            } else {

                echo "Aucune chambre n'a été trouvés!!!";
            }
            ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->




<?php

include './app/commum/footer.php'

?>