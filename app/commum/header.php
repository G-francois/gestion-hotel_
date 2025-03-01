<?php
// Gérer les sessions pour la page d'inscription, de connexion et de mot de passe oublié de l'administrateur
if (!empty($_SESSION['inscription-erreurs-admin'])) {
    $erreurs = $_SESSION['inscription-erreurs-admin'];
}

if (!empty($_SESSION['donnees-utilisateur-admin'])) {
    $donnees = $_SESSION['donnees-utilisateur-admin'];
}

if (!empty($_SESSION['connexion-erreurs-admin'])) {
    $erreurs = $_SESSION['connexion-erreurs-admin'];
}

if (!empty($_SESSION['verification-erreurs-admin'])) {
    $erreurs = $_SESSION['verification-erreurs-admin'];
}

if (!empty($_SESSION['enregistrer-erreurs-admin'])) {
    $erreurs = $_SESSION['enregistrer-erreurs-admin'];
}

// Gérer les sessions pour la page d'inscription, de connexion et de mot de passe oublié de la réceptionniste
if (!empty($_SESSION['inscription-erreurs'])) {
    $erreurs = $_SESSION['inscription-erreurs'];
}

if (!empty($_SESSION['donnees-utilisateur'])) {
    $donnees = $_SESSION['donnees-utilisateur'];
}

if (isset($_SESSION['connexion-erreurs']) && !empty($_SESSION['connexion-erreurs'])) {
    $erreurs = $_SESSION['connexion-erreurs'];
}

if (isset($_SESSION['verification-erreurs']) && !empty($_SESSION['verification-erreurs'])) {
    $erreurs = $_SESSION['verification-erreurs'];
}

if (isset($_SESSION['enregistrer-erreurs']) && !empty($_SESSION['enregistrer-erreurs'])) {
    $erreurs = $_SESSION['enregistrer-erreurs'];
}
?>

<?php
// Gérer les sessions pour le paramétrage du profil de l'administrateur
if (isset($_SESSION['changement-erreurs-admin']) && !empty($_SESSION['changement-erreurs-admin'])) {
    $erreurs = $_SESSION['changement-erreurs-admin'];
}

if (isset($_SESSION['sauvegarder-erreurs-admin']) && !empty($_SESSION['sauvegarder-erreurs-admin'])) {
    $erreurs = $_SESSION['sauvegarder-erreurs-admin'];
}

if (!empty($_SESSION['suppression-erreurs-admin'])) {
    $erreurs = $_SESSION['suppression-erreurs-admin'];
}

if (!empty($_SESSION['suppression-photo-erreurs-admin'])) {
    $erreurs = $_SESSION['suppression-photo-erreurs-admin'];
}

if (!empty($_SESSION['desactivation-erreurs-admin'])) {
    $erreurs = $_SESSION['desactivation-erreurs-admin'];
}

if (!empty($_SESSION['photo-erreurs-admin'])) {
    $erreurs = $_SESSION['photo-erreurs-admin'];
}

if (!empty($_SESSION['erreurs-admin'])) {
    $erreurs = $_SESSION['erreurs-admin'];
}
?>

<?php
// Gérer les sessions pour le paramétrage du profil de la réceptionniste
if (!empty($_SESSION['changement-erreurs'])) {
    $erreurs = $_SESSION['changement-erreurs'];
}

if (!empty($_SESSION['sauvegarder-erreurs'])) {
    $erreurs = $_SESSION['sauvegarder-erreurs'];
}

if (!empty($_SESSION['suppression-erreurs'])) {
    $erreurs = $_SESSION['suppression-erreurs'];
}

if (!empty($_SESSION['suppression-photo-erreurs'])) {
    $erreurs = $_SESSION['suppression-photo-erreurs'];
}

if (!empty($_SESSION['desactivation-erreurs'])) {
    $erreurs = $_SESSION['desactivation-erreurs'];
}

if (!empty($_SESSION['photo-erreurs'])) {
    $erreurs = $_SESSION['photo-erreurs'];
}

if (!empty($_SESSION['erreurs'])) {
    $erreurs = $_SESSION['erreurs'];
}
?>

<?php
// Gérer les sessions pour la page d'ajout de repas de l'administrateur
if (!empty($_SESSION['donnees-repas'])) {
    $donnees = $_SESSION['donnees-repas'];
}

if (!empty($_SESSION['erreurs-repas'])) {
    $erreurs = $_SESSION['erreurs-repas'];
}

// Gérer les sessions pour la page de modification de repas de l'administrateur
if (!empty($_SESSION['donnees-repas-modifier'])) {
    $donnees = $_SESSION['donnees-repas-modifier'];
}

if (!empty($_SESSION['erreurs-repas-modifier'])) {
    $erreurs = $_SESSION['erreurs-repas-modifier'];
}

// Gérer les sessions pour la page d'ajout de chambre de l'administrateur
if (!empty($_SESSION['donnees-chambre'])) {
    $donnees = $_SESSION['donnees-chambre'];
}

if (!empty($_SESSION['erreurs-chambre'])) {
    $erreurs = $_SESSION['erreurs-chambre'];
}

// Gérer les sessions pour la page de modification de chambre de l'administrateur
if (!empty($_SESSION['donnees-chambre-modifier'])) {
    $donnees = $_SESSION['donnees-chambre-modifier'];
}

if (!empty($_SESSION['erreurs-chambre-modifier'])) {
    $erreurs = $_SESSION['erreurs-chambre-modifier'];
}

// Gérer les sessions pour la page d'ajout d'utilisateur de l'administrateur
if (!empty($_SESSION['donnee-utilisateur'])) {
    $donnees = $_SESSION['donnee-utilisateur'];
}

if (!empty($_SESSION['erreurs-utilisateur'])) {
    $erreurs = $_SESSION['erreurs-utilisateur'];
}

// Gérer les sessions pour la page de modification d'utilisateur de l'administrateur
if (!empty($_SESSION['donnees-utilisateur-modifier'])) {
    $donnees = $_SESSION['donnees-utilisateur-modifier'];
}

if (!empty($_SESSION['erreurs-utilisateur-modifier'])) {
    $erreurs = $_SESSION['erreurs-utilisateur-modifier'];
}

// Gérer les sessions pour la page de commande de l'administrateur
if (!empty($_SESSION['donnees-commande'])) {
    $donnees = $_SESSION['donnees-commande'];
}

if (!empty($_SESSION['erreurs-commande'])) {
    $erreurs = $_SESSION['erreurs-commande'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HOTEL SOUS LES COCOTIERS MANAGEMENT SYSTEM</title>
    <!-- Favicons -->
    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="icon" />
    <link href="<?= PATH_PROJECT ?>public/images/al_copyrighter.png" rel="apple-touch-iconQ" />

    <!-- Custom fonts for this template-->
    <link href="<?= PATH_PROJECT ?>public/outils/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= PATH_PROJECT ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= PATH_PROJECT ?>public/vendor/bootstrap/css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= PATH_PROJECT ?>public/outils/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= PATH_PROJECT ?>public/css/sb-admin-2.css" rel="stylesheet">

    <script src="<?= PATH_PROJECT ?>public/outils/jquery/jquery.min.js"></script>
    <script src="<?= PATH_PROJECT ?>public/js/ajax.js"></script>

    <!-- Inclure Select2 CSS -->
    <link href="<?= PATH_PROJECT ?>public/outils/select2/css/select2.min.css" rel="stylesheet" />

    <link href="<?= PATH_PROJECT ?>public/css/style.css" rel="stylesheet" />

    <style>
        .bg-gradient-primary {
            margin-top: 0;
            background: #1a1814;
            background-clip: border-box;
            border-right: 1px solid #37332a;
        }

        .sidebar .nav-item .nav-link span {
            font-size: 0.9rem;
        }

        .sidebar .nav-item {
            background: transparent;
            margin-left: 6px;
        }

        .profile-desc {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 1.17rem;
            line-height: 1.25;
        }

        .profile-desc .profile-pic {
            display: flex;
            align-items: center;
        }

        .img-xs {
            width: 40px;
            height: 40px;
        }

        .profile-desc .profile-pic .count-indicator .count {
            position: absolute;
            left: 3.2%;
            width: 10px;
            height: 10px;
            color: #ffffff;
            border-radius: 100%;
            text-align: center;
            font-size: 0.625rem;
            line-height: 1.5;
            top: 48px;
            border: 2px solid #2c2e33;
        }

        .bg-success {
            --bs-bg-opacity: 1;
            background-color: rgba(var(--bs-success-rgb), var(--bs-bg-opacity)) !important;
        }

        .profile-desc .profile-name {
            margin-left: 1rem;
            display: none;
        }

        @media (min-width: 768px) {

            .sidebar .profile-desc .profile-name {
                display: inline;

            }

            .sidebar.toggled .profile-desc .profile-name {
                display: none;
            }


            .sidebar.toggled .profile-desc {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                padding: 0.6rem 1.17rem;
                line-height: 1.25;

            }

            .sidebar.toggled .profile-desc .profile-pic .count-indicator .count {
                position: absolute;
                left: 4%;
                width: 10px;
                height: 10px;
                color: #ffffff;
                border-radius: 100%;
                text-align: center;
                font-size: 0.625rem;
                line-height: 1.5;
                top: 48px;
                border: 2px solid #2c2e33;
            }
        }
    </style>

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

</head>