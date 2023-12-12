<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon" style="color:var(--blue);">
                    <i class='fas fa-smile'></i>
                </div>
                <div class="sidebar-brand-text mx-3" style="color:var(--blue);font-weight: 700;"><?= isset($_SESSION['utilisateur_connecter_admin']) ?  $_SESSION['utilisateur_connecter_admin']['profil'] : 'Profil' ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-calendar"></i>
                    <span>Réservations</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Ajouter une réservation:</h6>
                        <a class="collapse-item ml-4" href="<?= PATH_PROJECT ?>administrateur/reservations/reservation-solo">Chambre Solo</a>
                        <a class="collapse-item ml-4" href="<?= PATH_PROJECT ?>administrateur/reservations/reservation-double">Chambre Doubles</a>
                        <a class="collapse-item ml-4" href="<?= PATH_PROJECT ?>administrateur/reservations/reservation-triple">Chambre triples</a>
                        <a class="collapse-item ml-4" href="<?= PATH_PROJECT ?>administrateur/reservations/reservation-suit">Chambre Suite</a>
 -->
                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/reservations">Ajouter une réservation</a>

                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/reservations/liste-reservations">Liste des réservations</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-calendar"></i>
                    <span>Commandes</span>
                </a>
                <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Personnaliser:</h6>
                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/commandes">Ajouter une commande</a>
                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/commandes/liste-commandes">Liste des Commandes</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-home"></i>
                    <span>Chambres</span>
                </a>
                <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Personnaliser:</h6>
                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/chambres">Ajouter une chambre</a>
                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/chambres/liste-chambres">Liste des chambres</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa fa-coffee"></i>
                    <span>Repas</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Personnaliser:</h6>
                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/repas">Ajouter un repas</a>
                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/repas/liste-repas">Listes des repas</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fa fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
                <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Personnaliser:</h6>
                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/users">Ajouter un utilisateur</a>
                        <a class="collapse-item" href="<?= PATH_PROJECT ?>administrateur/users/liste-users">Listes des utilisateurs</a>
                    </div>
                </div>
            </li>

            <div>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="<?= PATH_PROJECT ?>administrateur/profil">
                        <i class='fas fa-user-gear'></i>
                        <span>Paramètres</span>
                    </a>
                </li>

                <li class="nav-item" class="logout">
                    <a class="nav-link collapsed" href="<?= PATH_PROJECT ?>administrateur/deconnexion/index">
                        <i class="fas fa-power-off" style="color:red;"></i>
                        <span>Déconnexion</span>
                    </a>
                </li>
            </div>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" alt="...">
                <a class="btn btn-success btn-sm" href="<?= PATH_PROJECT ?>client/site/home">SOUS LES COCOTIERS</a>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- <style>
                #content-wrapper {
                    background: url("<?= PATH_PROJECT ?>public/images/LOGO.png") center;
                    background-size: cover;
                }
            </style> -->
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-link">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= isset($_SESSION['utilisateur_connecter_admin']) ?  $_SESSION['utilisateur_connecter_admin']['nom_utilisateur'] : 'Pseudo' ?></span>
                                <img class="img-profile rounded-circle" src="<?= $_SESSION['utilisateur_connecter_admin']['avatar'] == 'Aucune_image' ? PATH_PROJECT . 'public/images/default_profil.jpg' : $_SESSION['utilisateur_connecter_admin']['avatar'] ?>">
                            </div>



                    </ul>

                </nav>
                <!-- End of Topbar -->