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
            <li class="breadcrumb-item active">Listes des réservations</li>
        </ol>
    </nav>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4 ml-2 mr-2">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Listes des réservations</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date de réservation</th>
                        <th>Client</th>
                        <th>Début occupation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01/12/22</td>
                        <td>Tiger Nixon</td>
                        <td>10/12/22</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Détails
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <p><strong>Fin occupation : </strong>07/02/23</p>
                                            <p><strong>Accompagnateur : </strong>Durand, Victor</p>
                                            <p><strong>Type de chambre : </strong>Solo</p>
                                            <p><strong>Nombre de nuit : </strong>01</p>
                                            <p><strong>Montant dû : </strong>3500 €</p>
                                        </div>
                                        <div class="modal-footer float-right">
                                            <button type="reset" class="btn btn-danger">Supprimer</button>
                                            <button type="submit" class="btn btn-success">Modifier</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>01/12/22</td>
                        <td>Aristide BOGNON</td>
                        <td>10/12/22</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter2">
                                Détails
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <p><strong>Fin occupation : </strong>07/02/23</p>
                                            <p><strong>Accompagnateur : </strong>B.Durand, G.Victor</p>
                                            <p><strong>Type de chambre : </strong>Solo, Doubles</p>
                                            <p><strong>Nombre de nuit : </strong>01</p>
                                            <p><strong>Montant dû : </strong>3500 €</p>
                                        </div>
                                        <div class="modal-footer float-right">
                                            <button type="reset" class="btn btn-danger">Supprimer</button>
                                            <button type="submit" class="btn btn-success">Modifier</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tr>

                    <tr>
                        <td>01/12/22</td>
                        <td>SODJATINMIN BIGNON</td>
                        <td>10/12/22</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter3">
                                Détails
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <p><strong>Fin occupation : </strong>07/02/23</p>
                                            <p><strong>Accompagnateur : </strong>B.Durand, G.Victor</p>
                                            <p><strong>Numéros de chambre : </strong>A-101, B-101</p>
                                            <p><strong>Type de chambre : </strong>Solo, Doubles</p>
                                            <p><strong>Nombre de nuit : </strong>01</p>
                                            <p><strong>Montant dû : </strong>3500 €</p>
                                        </div>
                                        <div class="modal-footer float-right">
                                            <button type="reset" class="btn btn-danger">Supprimer</button>
                                            <button type="submit" class="btn btn-success">Modifier</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tr>

                    <tr>
                        <td>01/12/22</td>
                        <td>JACK SPAKER</td>
                        <td>06/02/23</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter4">
                                Détails
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <p><strong>Fin occupation : </strong>07/02/23</p>
                                            <p><strong>Accompagnateur : </strong>B.Durand, G.Victor, KOKOYE TALA</p>
                                            <p><strong>Numéros de chambre : </strong>D-101</p>
                                            <p><strong>Type de chambre : </strong>Suites</p>
                                            <p><strong>Nombre de nuit : </strong>01</p>
                                            <p><strong>Montant dû : </strong>100 €</p>
                                        </div>
                                        <div class="modal-footer float-right">
                                            <button type="reset" class="btn btn-danger">Supprimer</button>
                                            <button type="submit" class="btn btn-success">Modifier</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- /.container-fluid -->


<?php

include './app/commum/footer.php'

?>