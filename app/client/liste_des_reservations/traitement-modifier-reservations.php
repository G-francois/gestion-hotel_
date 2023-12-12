<?php
$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];

// Vérification de l'existence du mot de passe
if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_client']['id'])) {

    // Récupération de l'ID de la réservation
    $num_res = $_POST['reservation_id'];

    // Variable pour suivre les erreurs
    $erreur_occure = false;

    // Vérification des types de chambre et des accompagnateurs
    if (!empty($_POST['type_chambre']) && $_POST['type_chambre'] == 'Doubles') {
        // Validation des accompagnateurs pour les chambres doubles
        if (is_array($_POST['nom_acc']) && sizeof($_POST['nom_acc']) <= 1) {
            // Boucle à travers les noms des accompagnateurs
            foreach ($_POST['nom_acc'] as $nom_acc) {
                if (!empty($nom_acc)) {
                    $donnees['nom_acc'][] = $nom_acc;
                }
            }
        } else {
            $message_erreur_global = 'Une erreur est survenue. Soit une action inattendue bloque le processus soit vous essayez de soumettre plus d\'accompagnateurs qu\'il est possible d\'ajouter.';
        }

        // Validation des contacts des accompagnateurs pour les chambres doubles
        if (is_array($_POST['contact_acc']) && sizeof($_POST['contact_acc']) <= 1) {
            foreach ($_POST['contact_acc'] as $contact_acc) {
                if (!empty($contact_acc)) {
                    $donnees['contact_acc'][] = $contact_acc;
                }
            }
        } else {
            $message_erreur_global = 'Une erreur est survenue. Soit une action inattendue bloque le processus soit vous essayez de soumettre plus d\'accompagnateurs qu\'il est possible d\'ajouter.';
        }
    }

    // Vérification des types de chambre et des accompagnateurs
    if (!empty($_POST['type_chambre']) && $_POST['type_chambre'] == 'Triples') {
        // Validation des accompagnateurs pour les chambres triples
        if (is_array($_POST['nom_acc']) && sizeof($_POST['nom_acc']) <= 2) {
            foreach ($_POST['nom_acc'] as $nom_acc) {
                if (!empty($nom_acc)) {
                    $donnees['nom_acc'][] = $nom_acc;
                }
            }
        } else {
            $message_erreur_global = 'Une erreur est survenue. Soit une action inattendue bloque le processus soit vous essayez de soumettre plus d\'accompagnateurs qu\'il est possible d\'ajouter.';
        }

        // Validation des contacts des accompagnateurs pour les chambres triples
        if (is_array($_POST['contact_acc']) && sizeof($_POST['contact_acc']) <= 2) {
            foreach ($_POST['contact_acc'] as $contact_acc) {
                if (!empty($contact_acc)) {
                    $donnees['contact_acc'][] = $contact_acc;
                }
            }
        } else {
            $message_erreur_global = 'Une erreur est survenue. Soit une action inattendue bloque le processus soit vous essayez de soumettre plus d\'accompagnateurs qu\'il est possible d\'ajouter.';
        }
    }

    // Vérification des types de chambre et des accompagnateurs
    if (!empty($_POST['type_chambre']) && $_POST['type_chambre'] == 'Suite') {
        // Validation des accompagnateurs pour les suites
        if (is_array($_POST['nom_acc']) && sizeof($_POST['nom_acc']) <= 4) {
            foreach ($_POST['nom_acc'] as $nom_acc) {
                if (!empty($nom_acc)) {
                    $donnees['nom_acc'][] = $nom_acc;
                }
            }
        } else {
            $message_erreur_global = 'Une erreur est survenue. Soit une action inattendue bloque le processus soit vous essayez de soumettre plus d\'accompagnateurs qu\'il est possible d\'ajouter.';
        }

        // Validation des contacts des accompagnateurs pour les suites
        if (is_array($_POST['contact_acc']) && sizeof($_POST['contact_acc']) <= 4) {
            foreach ($_POST['contact_acc'] as $contact_acc) {
                if (!empty($contact_acc)) {
                    $donnees['contact_acc'][] = $contact_acc;
                }
            }
        } else {
            $message_erreur_global = 'Une erreur est survenue. Soit une action inattendue bloque le processus soit vous essayez de soumettre plus d\'accompagnateurs qu\'il est possible d\'ajouter.';
        }
    }

    // Vérification des informations sur les accompagnateurs
    if (!empty($donnees['nom_acc']) && !empty($donnees['contact_acc'])) {
        if (sizeof($donnees['nom_acc']) != sizeof($donnees['contact_acc'])) {
            $message_erreur_global = 'Une erreur est survenue. Il se peut que des informations manquent pour certains accompagnateurs que vous avez soumis. Un accompagnateur soumis doit avoir un nom et un contact.';
        }
    }

    // Si aucune erreur n'est survenue jusqu'à présent
    if (!empty($donnees['nom_acc']) && !empty($donnees['contact_acc']) && empty($message_erreur_global)) {

        // Création d'un tableau pour stocker les numéros d'accompagnateurs à mettre à jour
        $accompagnateurs_a_mettre_a_jour = [];

        // Boucle pour vérifier et mettre à jour les accompagnateurs
        foreach ($donnees['nom_acc'] as $key => $nom) {
            if (vérifier_nom_contact_accompagnateur_exist_in_db($nom, $donnees['contact_acc'][$key])) {
                $numAccompagnateur = recuperer_num_acc_par_son_contact($donnees['contact_acc'][$key]);
                $accompagnateurs_a_mettre_a_jour[] = $numAccompagnateur;
            } else {
                if (vérifier_contact_accompagnateur_exist_in_db($donnees['contact_acc'][$key])) {
                    $erreur_occure = true;
                    $message_erreur_global = "Un des contacts accompagnateurs est déjà utilisé. Veuillez le changer.";
                } else {
                    $resultatInsertionAccompagnateur = enregistrer_accompagnateur($nom, $donnees['contact_acc'][$key]);
                    $numAccompagnateur = recuperer_num_acc_par_son_contact($donnees['contact_acc'][$key]);
                    $accompagnateurs_a_mettre_a_jour[] = $numAccompagnateur;
                }
            }
        }

        // Si aucune erreur ne s'est produite pendant la vérification des accompagnateurs
        if (!$erreur_occure) {
            // Suppression des accompagnateurs de la réservation actuelle
            supprimer_accompagnateurs_reservation($num_res);
            
            // Mise à jour de la réservation avec les nouveaux accompagnateurs
            foreach ($accompagnateurs_a_mettre_a_jour as $numAccompagnateur) {
                mis_a_jour_accompagnateur_des_reservations($num_res, $numAccompagnateur);
            }

            $message_success_global = "La réservation a été modifiée avec succès !";
        }
    } elseif (empty($donnees['nom_acc']) && empty($donnees['contact_acc']) && empty($message_erreur_global)) {

        // Si les données sur les accompagnateurs sont vides, supprimez les accompagnateurs de la réservation
        supprimer_accompagnateurs_reservation($num_res);
    }
} else {
    $message_erreur_global  = "La modification a échoué. Veuillez vérifier votre mot de passe et réessayer.";
}

// Stockage des messages dans les variables de session et redirection vers la page de liste des réservations
$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'client/liste_des_reservations');
