<?php

// Initialisation de la variable d'erreur
$errors = '';


if (isset($_POST["email"]) && !empty($_POST["email"])) {
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


if (!empty($_POST)) {
//  die(var_dump($_POST));
    if (!empty($_POST['editing'])) {

        $numero_reservation = $_POST['editing'];

        if (vérifier_client_reservation_exist_in_db($numClient, $numero_reservation)) {
            $liste_chambres_reservations = recuperer_liste_chambres_reservations($numero_reservation);

            $chambres = [];

            foreach ($liste_chambres_reservations as $_chambre) {
                $chambres[] = $_chambre['num_chambre'];
                $liste_accompagnateurs_chambres_reservations[$_chambre['num_chambre']] = recuperer_accompagnateurs_par_chambre_sur_une_reservation($numero_reservation, $_chambre['num_chambre']);
            }

            $tab_accs = [];

            foreach ($liste_accompagnateurs_chambres_reservations as $tab_acc) {
                $tab_accs = array_merge($tab_accs, $tab_acc);
            }
            //die(var_dump($tab_accs));
        } else {
            if (empty($errors)) {
                $errors = "Vous essayez de modifier une réservation qui n'est pas la vôtre.";
            }
        }

        if (!empty($_POST['password'])) {

            if (!check_password_exist($_POST['password'], $numClient)) {
                if (empty($errors)) {
                    $errors = "Mot de passe incorrect. Veuillez réessayer.";
                }
            }
        } else {
            if (empty($errors)) {
                $errors = "Le champs mot de passe est requis. Veuillez le remplir.";
            }
        }

        unset($_POST['editing'], $_POST['password']);
    }

    if (!empty($_POST)) {
        foreach ($_POST as $k => $chambre) {
            $chambre_infos = [];

            $chambre_infos['num'] = explode('&', $chambre['num'])[0];
            $chambre_infos['type'] = explode('&', $chambre['num'])[1];

            $chambre = array_merge($chambre, $chambre_infos);

            $_POST[$k] = $chambre;
        }

        $num_chambres = [];
        $numAccompagnateurs = [];
        $deb_occs = [];
        $fin_occs = [];
        $montants = [];

        foreach ($_POST as $chambre) {
            if (empty($chambre['num'])) {
                if (empty($errors)) {
                    $errors = "Vous devez sélectionner un numéro de chambre pour chaque chambre à réserver.";
                }
            } else {
                if (empty($numero_reservation)) {
                    if (verifier_chambre_actif_non_supprime($chambre['num'])) {
                        $num_chambres[] = $chambre['num'];
                    } else {
                        if (empty($errors)) {
                            $errors = "Vous essayez d'ajouter deux fois la chambre n°" . $chambre['num'] . " sur la même réservation. Sur une réservation, il ne peut y avoir une même chambre plusieurs fois.";
                        }
                    }
                } else {
                    $num_chambres[] = $chambre['num'];
                }
            }

            if (empty($chambre['type'])) {
                if (empty($errors)) {
                    $errors = "Une action inattendue bloque le processus";
                }
            } else {
                $chambre['type'] == 'Solo' ? $n = 1 : '';
                $chambre['type'] == 'Double' ? $n = 2 : '';
                $chambre['type'] == 'Triple' ? $n = 3 : '';
                $chambre['type'] == 'Suite' ? $n = 4 : '';
            }

            if (!empty($chambre['ACCS'])) {

                foreach ($chambre['ACCS'] as $key => $acc) {
                    if ((empty($acc['nom_acc']) && empty($acc['contact_acc']))) {
                        unset($chambre['ACCS'][$key]);
                    }
                }

                if (!empty($n) && sizeof($chambre['ACCS']) > $n) {
                    if (empty($errors)) {
                        $errors = "Le type (" . $chambre['type'] . ") de la chambre n°" . $chambre['num'] . " n'accepte que " . $n . " accompagnateur(s) au maximum. Vous en avez soumis " . sizeof($chambre['ACCS']) . ".";
                    }
                }
                if (!empty($chambre['ACCS'])) {
                    foreach ($chambre['ACCS'] as $m => $acc) {
                        $m = explode('acc', $m)[1];
                        if ((!empty($acc['nom_acc']) && empty($acc['contact_acc']))
                            || (empty($acc['nom_acc']) && !empty($acc['contact_acc']))
                        ) {
                            if (empty($errors)) {
                                $errors = "Informations manquantes au niveau de l'accompagnateur " . ($m) . " de la chambre n°" . $chambre['num'] . ". Pour chaque accompagnateur ajouter, vous devez soumettre le nom et le contact de ce dernier.";
                            }
                        } elseif ((!empty($acc['nom_acc']) && !empty($acc['contact_acc']))) {

                            if (empty($errors)) {
                                if (vérifier_nom_contact_accompagnateur_exist_in_db($acc['nom_acc'], $acc['contact_acc'])) {

                                    $numAccompagnateur = recuperer_num_acc_par_son_contact($acc['contact_acc']);
                                } elseif (vérifier_contact_accompagnateur_exist_in_db($acc['contact_acc'])) {

                                    if (!empty($numero_reservation)) {

                                        $in_array = [];
                                        foreach ($tab_accs as $accmp) {
                                            $in_array[] = in_array($acc['contact_acc'], $accmp);
                                        }

                                        if (in_array(true, $in_array)) {
                                            mettre_a_jour_accompagnateur($acc['contact_acc'], $acc['nom_acc']);

                                            $numAccompagnateur = recuperer_num_acc_par_son_contact($acc['contact_acc']);
                                        }
                                    } else {
                                        if (empty($errors)) {
                                            $errors = "Le numéro de téléphone " . $acc['contact_acc'] . " ajouté pour l'accompagnateur '" . $acc['nom_acc'] . "' de la chambre n°" . $chambre['num'] . " est déjà inscrit chez nous pour un autre accompagnateur. Veuillez le changer.";
                                        }
                                    }
                                } else {
                                    // Appeler la fonction pour insérer les informations de l'accompagnateur dans la table "accompagnateur"
                                    $resultatInsertionAccompagnateur = enregistrer_accompagnateur($acc['nom_acc'], $acc['contact_acc']);
                                    $numAccompagnateur = recuperer_num_acc_par_son_contact($acc['contact_acc']);
                                }
                            }

                            !empty($numAccompagnateur) ? $numAccompagnateurs[$chambre['num']][] = $numAccompagnateur : '';
                        }
                    }
                }
            }

            if (empty($chambre['deb_occ'])) {
                if (empty($errors)) {
                    $errors = "Chaque chambre réserver doit avoir une date de début de séjour. Veuillez remplir ce champs pour la chambre n°" . $chambre['num'];
                }
            } else {
                if (new DateTime(date('d-m-Y')) > new DateTime($chambre['deb_occ'])) {
                    if (empty($errors)) {
                        $errors = "La date de début de séjour ne peut être antérieure à la date actuelle ( " . date('d / m / Y') . " ). Veuillez corriger ce champs pour la chambre n°" . $chambre['num'];
                    }
                }

                $deb_occ = date('Y-m-d H:i:s', strtotime($chambre['deb_occ'] . ' ' . date('H:i:s') . " +1 hour"));

                if (!empty($numero_reservation)) {
                    foreach ($liste_chambres_reservations as $chambre_reservation) {
                        if (in_array($chambre['num'], $chambres)) {
                            explode(' ', $chambre_reservation['deb_occ'])[0] != $chambre['deb_occ'] ? $deb_occ = $chambre_reservation['deb_occ'] : '';
                        }
                    }
                }
            }

            if (empty($chambre['fin_occ'])) {
                if (empty($errors)) {
                    $errors = "Chaque chambre réserver doit avoir une date de fin de séjour. Veuillez remplir ce champs pour la chambre n°" . $chambre['num'];
                }
            } else {
                $fin_occ = date('Y-m-d H:i:s', strtotime($chambre['fin_occ'] . ' ' . date('H:i:s') . " +1 hour"));

                if (!empty($numero_reservation)) {
                    foreach ($liste_chambres_reservations as $chambre_reservation) {
                        if (in_array($chambre['num'], $chambres)) {
                            explode(' ', $chambre_reservation['fin_occ'])[0] != $chambre['fin_occ'] ? $fin_occ = $chambre_reservation['fin_occ'] : '';
                        }
                    }
                }
            }

            if ((!empty($deb_occ) && !empty($fin_occ)) && (new DateTime($deb_occ) > new DateTime($fin_occ))) {
                if (empty($errors)) {
                    $errors = "La date de début de séjour ne peut être après la date de fin de séjour. Vérifiez vos saisies au niveau de la chambre n°" . $chambre['num'];
                }
            } else {
                $dateDebut = new DateTime($deb_occ);
                $dateFin = new DateTime($fin_occ);
                $prixParNuit = recuperer_prix_chambre($chambre['type']);

                $diff = $dateDebut->diff($dateFin);
                $jours = $diff->days + 1;
                $montant = $jours * $prixParNuit['montant'];

                $deb_occs[] = $deb_occ;
                $fin_occs[] = $fin_occ;
                $montants[] = $montant;
            }

            mettre_a_jour_statut_chambre_reserver($chambre['num'], 0);
        }
    } else {
        if (empty($errors)) {
            $errors = "Une réservation ne peut être sans chambre. Si vous souhaitez annuler ou supprimer cette réservation, cliquez sur l'icône de suppression dans la liste des actions pour cette réservation.";
        }
    }
    
} else {
    if (empty($errors)) {
        $errors = "Veuillez remplir le formulaire de réservation avant soumission.";
    }
}

//die(var_dump($num_chambres, $numAccompagnateurs, $deb_occs, $fin_occs, $montants));

if (!empty($errors)) {

    if (empty($numero_reservation)) {
        foreach ($_POST as $chambre) {
            mettre_a_jour_statut_chambre_reserver($chambre['num'], 1);
        }
    }

    $response = array('success' => false, 'message' => $errors);
} else {

    if (!empty($numero_reservation)) {

        $numRes = $numero_reservation;
    } else {

        $reservations = recuperer_liste_reservations();

        if (empty($reservations)) {
            $numRes = 1;
        } else {

            $dernier_numero_reservation = $reservations[sizeof($reservations) - 1]['num_res'];

            $deuxiemeIndex = explode('-', $dernier_numero_reservation)[1];

            $numRes = $deuxiemeIndex + 1;
        }
    }

    if (!empty($num_chambres) && !empty($deb_occs) && !empty($fin_occs) && !empty($numClient) && !empty($montants)) {

        $montantTotal = 0;

        foreach ($montants as $montant) {
            $montantTotal += $montant;
        }

        if (empty($numero_reservation)) {

            $resultatInsertionReservation = enregistrer_reservation('SLC-' . $numRes . '-' . date('y'), $numClient, $montantTotal);

            if ($resultatInsertionReservation) {

                foreach ($num_chambres as $k => $val) {
                    $resultatInsertionReservationChambres = enregistrer_reservation_chambres('SLC-' . $numRes . '-' . date('y'), $num_chambres[$k], $deb_occs[$k], $fin_occs[$k], $montants[$k]);
                }

                if (!empty($numAccompagnateurs)) {
                    foreach ($numAccompagnateurs as $num_chambre => $numaccompagnateurs) {

                        foreach ($numaccompagnateurs as $k => $numaccompagnateur) {
                            $insertionReservationAccompagnateur = enregistrer_accompagnateur_des_reservations('SLC-' . $numRes . '-' . date('y'), $num_chambre, $numaccompagnateur);
                        }
                    }
                }
            }
        } else {

            mettre_a_jour_reservation($numero_reservation, $montantTotal);

            //die(var_dump($liste_chambres_reservations, $num_chambres));
            foreach ($liste_chambres_reservations as $_chambre) {
                if (!in_array($_chambre['num_chambre'], $num_chambres)) {
                    mettre_a_jour_statut_chambre_reserver($_chambre['num_chambre'], 1);
                }
            }

            supprimer_reservation_chambres($numero_reservation);

            foreach ($num_chambres as $k => $val) {
                enregistrer_reservation_chambres($numero_reservation, $num_chambres[$k], $deb_occs[$k], $fin_occs[$k], $montants[$k]);
            }

            if (!empty($numAccompagnateurs)) {
                supprimer_accompagnateurs_reservation($numero_reservation);

                foreach ($numAccompagnateurs as $num_chambre => $numaccompagnateurs) {
                    foreach ($numaccompagnateurs as $k => $numaccompagnateur) {
                        $insertionReservationAccompagnateur = enregistrer_accompagnateur_des_reservations($numero_reservation, $num_chambre, $numaccompagnateur);
                    }
                }
            }
        }
    }

    $redirectUrl = PATH_PROJECT . 'administrateur/reservations/liste_des_reservations';

    if (!empty($numero_reservation)) {
        $response = array('success' => true, 'message' => 'Votre réservation a bien été modifié.', 'redirectUrl' => $redirectUrl);
    } else {
        $response = array('success' => true, 'message' => 'Votre réservation a bien été effectué. Un retour vous sera faite après validation.', 'redirectUrl' => $redirectUrl);
    }
}

header('Content-Type: application/json');
echo json_encode($response);
