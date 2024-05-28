<?php

$donnees = [];
$message_erreur_global = "";
$message_success_global = "";
$erreurs = [];


if (!empty($_POST["email"])) {
    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $donnees["email"] = trim(htmlentities($_POST["email"]));
    } else {
        $errors = "Le champs email doit être une adresse mail valide. Veuillez le renseigner.";
    }
} else {
    $errors = "Le champs email est requis. Veuillez le renseigner.";
}


if (check_email_and_profile_admin_in_db($_POST["email"])) {
    $errors = "Cette adresse mail n'est pas autorisée pour faire une réservation car il est utiliser par un autre profil 'ADMINISTRATEUR'.";
}

// Récupération de l'ID client à partir de la session
$numClient = recuperer_id_utilisateur_par_son_mail($donnees["email"]);

if (check_password_exist($_POST['password'], $_SESSION['utilisateur_connecter_admin']['id'])) {
   // Utilisons une seule boucle foreach pour parcourir à la fois ($_POST['nom_repas']) et ($_POST['pu_repas']).
    // Nous utilisons la même clé $key pour accéder aux éléments correspondants dans les deux tableaux.
    // Si à la fois le nom du repas ($nom_repas) et le prix unitaire ($pu_repas) ne sont pas vides,
    // nous les ajoutons aux tableaux $donnees['nom_repas'] et $donnees['pu_repas'].
    $donnees = [
        'nom_repas' => [],
        'pu_repas' => [],
    ];

    foreach ($_POST['nom_repas'] as $key => $nom_repas) {
        $pu_repas = $_POST['pu_repas'][$key];

        if (!empty($nom_repas) && !empty($pu_repas)) {
            $donnees['nom_repas'][] = $nom_repas;
            $donnees['pu_repas'][] = $pu_repas;
        }
    }
    // die(var_dump($donnees));

    if (empty($donnees['nom_repas']) || empty($donnees['pu_repas'])) {
        $message_erreur_global = 'Une erreur est survenue. Il se peut que des informations manquent pour certains repas que vous avez soumis. Un repas soumis doit avoir un nom et un prix.';
    }

    if (!empty($donnees['nom_repas']) && !empty($donnees['pu_repas']) && empty($message_erreur_global)) {
        $num_cmd = $_POST['commande_id'];
        $num_res = $_POST['reservation_id'];
        $num_chambre = $_POST['num_chambre'];
        // die(var_dump($num_chambre));

        supprimer_repas_commande($num_cmd);

        //  die(var_dump(supprimer_repas_commande($num_cmd)));

        // Vérifier si la chambre est inactive
        if (verifier_chambre_supprimer($num_chambre)) {
            // Calculate the total price for all selected meals
            $prix_total = array_sum($donnees["pu_repas"]);

            // die(var_dump($prix_total));

            // Ajouter une commande avec le montant total
            $mise_a_jour_commande = modifier_commande($num_cmd, $prix_total);

            // die(var_dump($mise_a_jour_commande));

            if ($mise_a_jour_commande) {
                // Enregistrer la quantité de repas pour chaque repas sélectionné
                foreach ($donnees["nom_repas"] as $codeRepas) {

                    $insertionCommandeQuantite = enregistrer_commande_repas($codeRepas, $num_cmd, $num_chambre);

                    // die(var_dump($insertionCommandeQuantite));

                    // Vérifiez si l'insertion à échouer et gérez les erreurs si nécessaire
                    if (!$insertionCommandeQuantite) {
                        $message_erreur_global = "Erreur lors de l'enregistrement de(s) repas.";
                        break; // Sortez de la boucle si une erreur se produit pour un repas
                    }
                }
                // La commande a été effectuée avec succès
                $message_success_global = "La commande a été modifiée avec succès.";
            } else {
                // La mise à jour de la commande a échoué
                $message_erreur_global = "Désolé, une erreur s'est produite lors de la mise à jour de la commande.";
            }
        } else {
            // La chambre est inactive.
            $message_erreur_global = "Désolé, la chambre est inactive.";
        }
    }
} else {
    // Mot de passe incorrect
    $message_erreur_global  = "La modification a échoué. Vérifiez votre mot de passe et réessayez.";
}

$_SESSION['donnees-commande'] = $donnees;
$_SESSION['erreurs-commande'] = $erreurs;

// Redirection vers la page de liste des réservations avec un message de succès ou d'erreur
$_SESSION['message-erreur-global'] = $message_erreur_global;
$_SESSION['message-success-global'] = $message_success_global;
header('location: ' . PATH_PROJECT . 'administrateur/commandes/liste-commandes');
