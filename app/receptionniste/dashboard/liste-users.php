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
            <li class="breadcrumb-item active">Listes des utilisateurs</li>
        </ol>
    </nav>
</div>

<!-- Tableau de la liste des utilisateurs -->
<div class="card shadow mb-4  ml-2 mr-2">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Listes des utilisateurs</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom(s)</th>
                        <th>Sexe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>KAMADO</td>
                        <td>Tanjiro</td>
                        <td>Masculin</td>
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
                                            <p><strong>Date de naissance : </strong>10/12/13</p>
                                            <p><strong>Email : </strong>kamado.tanjiro@yahoo.com</p>
                                            <p><strong>Nom d'utilisateur : </strong>Tanjiro</p>
                                            <p><strong>Type : </strong>User</p>
                                            <p><strong>Mot de passe : </strong>1234</p>
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
                        <td>G</td>
                        <td>François</td>
                        <td>Masculin</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter1">
                                Détails
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <p><strong>Date de naissance : </strong>10/12/13
                                            <p>
                                            <p><strong>Email : </strong>francog@yahoo.com</p>
                                            <p><strong>Nom d'utilisateur : </strong>FRANCO</p>
                                            <p><strong>Type : </strong>Admin</p>
                                            <p><strong>Mot de passe : </strong>234</p>
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
                        <td>UZUMAKI</td>
                        <td>Naruto</td>
                        <td>Masculin</td>
                        <td>
                            <!-- Button Détails modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter2">
                                Détails
                            </button>

                            <!-- Modal Détails -->
                            <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <p><strong>Date de naissance : </strong>10/10/05
                                            <p>
                                            <p><strong>Email : </strong>uzumaki.naruto@gmail.com</p>
                                            <p><strong>Nom d'utilisateur : </strong>Naruto</p>
                                            <p><strong>Type : </strong>User</p>
                                            <p><strong>Mot de passe : </strong>1234567890</p>
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


<?php

include './app/commum/footer.php'

?>