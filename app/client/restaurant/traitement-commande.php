<?php
$donnees = [];
$erreurs = [];
$message_erreur_global = "";
$message_success_global = "";

if (isset($_POST['enregistrer'])) {

    // Récupérer l'ID du client connecté depuis la session
    $clientConnecteID = $_SESSION['utilisateur_connecter_client']['id'];


    // Vérifier si le numéro de réservation est fourni
    if (isset($_POST["num_chambre"]) && !empty($_POST["num_chambre"])) {
        $donnees["num_chambre"] = $_POST["num_chambre"];
        $numChambre = $donnees["num_chambre"];

        // Appeler la fonction pour vérifier l'existence de num_chambre dans la table "chambre"
        $chambreExiste = verifier_existence_num_chambre($numChambre);

        //  die(var_dump($chambreExiste));

        if (!$chambreExiste) {
            $erreurs["num_chambre"] = "Le numéro de la chambre n'existe pas. Veuiller réesayer!";
        } else {
            // Récupérer le numéro de reservation
            $donneesReservations = recuperer_donnee_reservation_par_num_chambre($donnees["num_chambre"]);

            /* Extraire la valeur du champ num_res, 
        vérifiez d'abord si le tableau retourné par la fonction n'est pas vide 
        (!empty($donneesReservation['num_res'])). Si le champ num_res existe dans le tableau, vous l'affectez à la variable $num_res. 
        Sinon, $num_res prend la valeur null 
        */

            $num_res = !empty($donneesReservations['num_res']) ? $donneesReservations['num_res'] : null;
            //die(var_dump($num_res));

            // Appeler la fonction pour vérifier l'existence de num_chambre dans la table "reservation"
            $reservationExiste = verifier_existence_num_res_avec_statut($num_res);
            // die(var_dump($reservationExiste));

            if (!$reservationExiste) {
                $erreurs["num_chambre"] = "Le numéro de la chambre n'appartient à aucune réservation ou peut être que votre reservation n'est pas encore valide.";
            } elseif (!verifier_appartenance_reservation($num_res, $clientConnecteID)) {
                // La réservation existe, mais ne correspond pas au client connecté
                $erreurs["num_chambre"] = "Le numéro de la chambre est pour une réservation qui ne vous appartient pas.";
            }
        }
    } else {
        $erreurs["num_chambre"] = "Le champ numéro de chambre est requis. Veuillez le renseigner.";
    }



    if (empty($_POST['nom_repas']) || count($_POST['nom_repas']) == 0 || empty(array_filter($_POST['nom_repas']))) {
        // Aucun repas n'a été sélectionné, affichez un message d'erreur
        $erreurs["nom_repas"] = "Veuillez sélectionner au moins un repas.";
    }

    // Vérifier si le prix du repas est fourni
    if (isset($_POST["pu_repas"]) && !empty($_POST["pu_repas"])) {
        $donnees["pu_repas"] = $_POST["pu_repas"];
    } else {
        $erreurs["pu_repas"] = "Le champ prix du repas est requis. Veuillez le renseigner.";
    }

    // Si aucune erreur n'a été détectée
    if (empty($erreurs)) {

        $donneesReservation = recuperer_donnees_reservation_par_num_res($num_res);

        // die(var_dump($donneesReservation));
        $num_res = !empty($donneesReservation['id']) ? $donneesReservation['id'] : null;

        // die(var_dump($num_res));

        $numChambre = $donnees["num_chambre"];

        // die(var_dump($num_res));

        if (!empty($donnees) && isset($numChambre)) {

            // $numChambre = $recupererNumChambre['num_chambre'];

            // Vérifier si la chambre est inactive
            if (verifier_chambre_supprimer($numChambre)) {

                // die(var_dump(verifier_chambre_supprimer($numChambre)));

                // Calculate the total price for all selected meals
                $prix_total = 0;
                foreach ($donnees["pu_repas"] as $puRepas) {
                    // Cast the $puRepas value to an integer
                    $puRepas = (int)$puRepas;

                    // Add the integer value to $prix_total
                    $prix_total += $puRepas;
                }

                // Ajouter une commande avec le montant total
                $insertionCommande = enregistrer_une_commande_avec_prix_total($num_res, $numChambre, $prix_total);
                // die(var_dump($insertionCommande));

                // Récupérer le numéro de commande
                $numCommande = recuperer_num_cmd_par_num_res($num_res);
                // die(var_dump($numCommande));

                // Enregistrer la quantité de repas pour chaque repas sélectionné
                foreach ($_POST["nom_repas"] as $codeRepas) {

                    $insertionCommandeQuantite = enregistrer_commande_repas($codeRepas, $numCommande, $numChambre);
                    
                    // die(var_dump($insertionCommandeQuantite));

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
header('location: ' . PATH_PROJECT . 'client/restaurant/commande');
