<?php
$donnees = [];
$erreurs = [];
$message_erreur_global = "";
$message_success_global = "";

if (isset($_POST['enregistrer'])) {

    // Récupérer l'ID du client connecté depuis la session
    $clientConnecteID = $_SESSION['utilisateur_connecter_client']['id'];


    // Vérifier si le numéro de réservation est fourni
    if (isset($_POST["num_res"]) && !empty($_POST["num_res"])) {
        $donnees["num_res"] = $_POST["num_res"];
        $numRes = $donnees["num_res"];
        // Appeler la fonction pour vérifier l'existence de num_res dans la table "reservation"
        $reservationExiste = verifier_existence_num_res($donnees["num_res"]);

        if (!$reservationExiste) {
            $erreurs["num_res"] = "Le numéro de réservation n'existe pas.";
        }
    } else {
        $erreurs["num_res"] = "Le champ numéro de réservation est requis. Veuillez le renseigner.";
    }

    // Vérifier si le nom du repas est fourni
    if (isset($_POST["nom_repas"]) && !empty($_POST["nom_repas"])) {
        $donnees["nom_repas"] = $_POST["nom_repas"];
    } else {
        $erreurs["nom_repas"] = "Le champ nom de repas est requis. Veuillez le renseigner.";
    }

    // Vérifier si le prix du repas est fourni
    if (isset($_POST["pu_repas"]) && !empty($_POST["pu_repas"])) {
        $donnees["pu_repas"] = $_POST["pu_repas"];
    } else {
        $erreurs["pu_repas"] = "Le champ prix du repas est requis. Veuillez le renseigner.";
    }

    // Si aucune erreur n'a été détectée
    if (empty($erreurs)) {

        $num_res = $donnees["num_res"];

        $recupererNumChambre = recuperer_donnees_reservation_par_num_res($num_res);

        if (!empty($donnees) && isset($recupererNumChambre['num_chambre'])) {

            $numChambre = $recupererNumChambre['num_chambre'];

            // Vérifier si la chambre est inactive
            if (verifier_chambre_supprimer($numChambre)) {

                // Calculate the total price for all selected meals
                $prix_total = 0;
                foreach ($donnees["pu_repas"] as $puRepas) {
                    $prix_total += $puRepas;
                }

                // Ajouter une commande avec le montant total
                $insertionCommande = enregistrer_une_commande_avec_prix_total($num_res, $prix_total);

                // Récupérer le numéro de commande
                $numCommande = recuperer_num_cmd_par_num_res($num_res);

                // die(var_dump($numCommande));

                // Enregistrer la quantité de repas pour chaque repas sélectionné
                foreach ($donnees["nom_repas"] as $codeRepas) {
                    $insertionCommandeQuantite = enregistrer_quantite_repas($codeRepas, $numCommande, $numChambre);

                    // Vérifiez si l'insertion a échoué et gérez les erreurs si nécessaire
                    if (!$insertionCommandeQuantite) {
                        $message_erreur_global = "Erreur lors de l'enregistrement de(s) repas.";
                        break; // Sortez de la boucle si une erreur se produit pour un repas
                    }
                }

                // La commande a été effectuée avec succès
                $message_success_global = "Votre commande a été effectuée avec succès.";
            } else {
                // La commande a échoué
                $message_erreur_global = "Désolé, une erreur s'est produite lors de l'enregistrement de la commande.";
            }
        }
    }
}

// Stocker les erreurs et les messages dans des sessions
$_SESSION['donnees-commande'] = $donnees;
$_SESSION['erreurs-commande'] = $erreurs;
$_SESSION['commande-message-erreur-global'] = $message_erreur_global;
$_SESSION['commande-message-success-global'] = $message_success_global;

// Rediriger vers la page de commande
header('location: ' . PATH_PROJECT . 'administrateur/commandes');
