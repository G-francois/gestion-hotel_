<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Cette fonction permet de se connecter à une base de donnée.
 * Elle retourne l'instance / objet de la base de donnée, si la connexion a la base de donnée est succès.
 *
 * @return PDO|string $db L'instance / objet de la base de donnée.
 */
function connect_db(): PDO|string
{
	try {
		$db = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD);
	} catch (\Exception $e) {
		$db = "Oups! Une erreur s'est produite lors de la connexion a la base de donnée. Message original : $e";
	}

	return $db;
}

/**
 * recuperer_reservations_expirees
 *
 * @return array
 */
function recuperer_reservations_expirees(): array
{
	$reservations = [];

	$db = connect_db();

	if (is_object($db)) {
		$requete = "SELECT num_res, num_chambre FROM reservation_chambres WHERE fin_occ < NOW() AND est_actif = 1 AND est_supprimer = 0";
		$requete_preparee = $db->prepare($requete);

		$requete_executee = $requete_preparee->execute();

		if ($requete_executee) {
			$donnees = $requete_preparee->fetchAll(PDO::FETCH_ASSOC);

			if (!empty($donnees) && is_array($donnees)) {
				$reservations = $donnees;
			}
			//else {
			//	Ajoutez ce message de débogage
			//	echo "Aucune réservation expirée trouvée.";
			//}
		}
	}

	return $reservations;
}

/**
 * Cette fonction permet de récupérer les ID des réservations à partir des numéros de réservation
 *
 * @param array $numerosReservations
 * @return array
 */
function recuperer_id_reservations_par_num_res(array $numerosReservations): array
{
	$idsReservations = [];

	$db = connect_db();

	if (is_object($db) && !empty($numerosReservations)) {
		// Créez une chaîne de placeholders "?" en fonction du nombre de numéros de réservation fournis
		$placeholders = implode(',', array_fill(0, count($numerosReservations), '?'));

		$requete = "SELECT id FROM reservations WHERE num_res IN ($placeholders)";

		$request_prepare = $db->prepare($requete);

		// Utilisez bindValue pour associer chaque numéro de réservation à son placeholder
		foreach ($numerosReservations as $key => $numRes) {
			//$request_prepare->bindValue(($key + 1), $numRes, PDO::PARAM_STR);
			$request_prepare->bindValue(($key + 1), $numRes);
		}

		if ($request_prepare->execute()) {
			$idsReservations = $request_prepare->fetchAll(PDO::FETCH_COLUMN);
		}
	}

	return $idsReservations;
}

/**
 * Cette fonction permet de mettre à jour le champ est_actif dans la table commande
 * pour les commandes associées aux ID de réservation fournis.
 *
 * @param array $idsReservations
 * @return bool
 */
function mettre_a_jour_est_actif_commandes(array $idsReservations): bool
{
	$db = connect_db();

	if (is_object($db) && !empty($idsReservations)) {
		// Créez une chaîne de placeholders "?" en fonction du nombre d'ID de réservation fournis
		$placeholders = implode(',', array_fill(0, count($idsReservations), '?'));

		// Préparez la requête de mise à jour
		$requete = "UPDATE commande SET est_actif = 0, est_supprimer = 1 WHERE num_res IN ($placeholders)";
		$requete_preparee = $db->prepare($requete);

		// Exécutez la requête avec les ID de réservation en tant que valeurs de remplacement
		return $requete_preparee->execute($idsReservations);
	}

	return false;
}

/**
 * Cette fonction permet de récupérer les numéros de commande associés aux ID de réservation fournis.
 *
 * @param array $idsReservations
 * @return array|bool Un tableau contenant les numéros de commande ou false en cas d'erreur.
 */
function recuperer_tous_num_cmd_par_num_res(array $idsReservations): bool|array
{
	$db = connect_db();

	if (is_object($db)) {
		if (!empty($idsReservations)) {
			$placeholders = implode(',', array_fill(0, count($idsReservations), '?'));

			$requete_select = "SELECT num_cmd FROM commande WHERE num_res IN ($placeholders)";
			$requete_preparee_select = $db->prepare($requete_select);

			$requete_executee_select = $requete_preparee_select->execute($idsReservations);

			if ($requete_executee_select) {
				// Ajoutez ces messages de débogage
				// echo "Requête exécutée avec succès. Résultats : ";
				// var_dump($resultats_select);

				return $requete_preparee_select->fetchAll(PDO::FETCH_COLUMN);
			}
			// else {
			//	Ajoutez ces messages de débogage
			//	echo "Erreur lors de l'exécution de la requête. Informations sur la requête : ";
			//	var_dump($requete_preparee_select->errorInfo());
			//}
		}
		//else {
		//	 Ajoutez ces messages de débogage
		//	 echo "Les IDs de réservation sont vides.";
		//}
	}
	//else{
	//	// Ajoutez ces messages de débogage
	//	// echo "La base de données est invalide.";
	//}

	return false;
}

/**
 * Cette fonction permet de mettre à jour le champ est_actif dans la table commande_repas
 * pour les numéros de commande fournis.
 *
 * @param array $numerosCommande
 * @return bool
 */
function mettre_a_jour_est_actif_commande_repas(array $numerosCommande): bool
{
	// Vérifiez si le tableau n'est pas vide
	if (empty($numerosCommande)) {
		return false;
	}

	$db = connect_db();

	if (is_object($db)) {
		// Créez une chaîne de placeholders "?" en fonction du nombre de numéros de commande fournis
		$placeholders = implode(',', array_fill(0, count($numerosCommande), '?'));

		// Préparez la requête de mise à jour
		$requete = "UPDATE commande_repas SET est_actif = 0, est_supprimer = 1 WHERE num_cmd IN ($placeholders)";
		$requete_preparee = $db->prepare($requete);

		// Exécutez la requête avec les numéros de commande en tant que valeurs de remplacement
		return $requete_preparee->execute($numerosCommande);
	}

	return false;
}

/**
 * mettre_a_jour_est_actif_chambre
 *
 * @param mixed $numeros_chambre
 * @return bool
 */
function mettre_a_jour_est_actif_chambre(array $numeros_chambre): bool
{
	// Vérifiez si la liste des numéros de chambre est vide
	if (empty($numeros_chambre)) {
		return false;
	}

	$db = connect_db();

	if (is_object($db)) {
		// Créez une chaîne de placeholders "?" en fonction du nombre de numéros de chambre fournis
		$placeholders = implode(',', array_fill(0, count($numeros_chambre), '?'));

		// Préparez la requête de mise à jour
		$requete = "UPDATE chambre SET est_actif = 1 WHERE num_chambre IN ($placeholders)";
		$requete_preparee = $db->prepare($requete);

		// Exécutez la requête avec les numéros de chambre en tant que valeurs de remplacement
		return $requete_preparee->execute($numeros_chambre);
	}

	return false;
}

/**
 * mettre_a_jour_est_actif_reservations
 *
 * @param mixed $numReservations
 * @return bool
 */
function mettre_a_jour_est_actif_reservations(array $numReservations): bool
{


	// Vérifiez si la liste des numéros de reservations est vide
	if (empty($numReservations)) {
		return false;
	}

	$success = false;

	$db = connect_db();

	if (is_object($db)) {
		$numReservationsList = implode(',', array_map('intval', $numReservations));
		$requete = "UPDATE reservations SET est_actif = 0 WHERE num_res IN ($numReservationsList)";
		$requete_preparee = $db->prepare($requete);

		$requete_executee = $requete_preparee->execute();

		if ($requete_executee) {
			$success = true;
		}
	}

	return $success;
}

/**
 * Vérifie si la page actuelle correspond au nom de la page donné.
 *
 * @param string $page_name Le nom de la page à vérifier.
 * @return string Une chaîne indiquant si la page est active ou non.
 */
function is_current_page(string $page_name): string
{
	// Récupérer le chemin actuel de la page
	$current_page = $_SERVER['REQUEST_URI'];

	// Comparer le chemin actuel avec le nom de la page
	if (str_contains($current_page, $page_name)) {
		return 'active';
	}

	return '';
}

/**
 * Récupère la liste des chambres pour la page d'accueil.
 *
 * @return array Un tableau contenant les détails des chambres récupérées.
 */
function recuperer_liste_chambres_acceuil(): array
{
	$db = connect_db();
	$liste_chambre = [];

	if (is_object($db)) {
		$requete = 'SELECT * FROM chambre ORDER BY creer_le DESC LIMIT 6';

		$verifier_liste_chambres = $db->prepare($requete);

		$resultat = $verifier_liste_chambres->execute();

		if ($resultat) {
			$liste_chambre = $verifier_liste_chambres->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	return $liste_chambre;
}

/**
 * Récupère la liste des chambres pour la page d'accueil.
 *
 * @return array Un tableau contenant les détails des chambres récupérées.
 */
function recuperer_liste_chambres_acceuil2(): array
{
	$db = connect_db();
	$liste_chambre = [];

	if (is_object($db)) {
		$requete = 'SELECT * FROM chambre '; 

		$verifier_liste_chambres = $db->prepare($requete);

		$resultat = $verifier_liste_chambres->execute();

		if ($resultat) {
			$liste_chambre = $verifier_liste_chambres->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	return $liste_chambre;
}

/**
 * Récupère une liste de chambres en fonction de la pagination et du type de chambre donné.
 *
 * @param int $page Le numéro de la page actuelle.
 * @param string|null $type Le type de chambre (facultatif).
 * @return array Un tableau contenant les détails des chambres récupérées.
 */
function liste_chambres(int $page, string $type = null): array
{

	$liste_chambres = [];

	$nb_chambres_par_page = 9;

	$database = connect_db();

	if (!is_null($type)) {

		$request = "SELECT * FROM chambre WHERE lib_typ = :lib_typ and est_actif = 1 and est_supprimer = 0 ORDER BY num_chambre ASC LIMIT " . $nb_chambres_par_page . "  OFFSET " . $nb_chambres_par_page * ($page - 1);

		$request_prepare = $database->prepare($request);

		$request_execution = $request_prepare->execute([
			'lib_typ' => $type
		]);
	} else {

		$request = "SELECT * FROM chambre WHERE est_actif = 1 and est_supprimer = 0 ORDER BY num_chambre ASC LIMIT " . $nb_chambres_par_page . "  OFFSET " . $nb_chambres_par_page * ($page - 1);

		$request_prepare = $database->prepare($request);

		$request_execution = $request_prepare->execute();
	}


	if (!empty($request_execution)) {

		$data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($data) && is_array($data)) {

			$liste_chambres = $data;
		}
	}

	return $liste_chambres;
}


/**
 * Récupère une liste de chambres en fonction de la pagination et du type de chambre donné.
 *
 * @param int $page Le numéro de la page actuelle.
 * @param string|null $type Le type de chambre (facultatif).
 * @return array Un tableau contenant les détails des chambres récupérées.
 */
function liste_chambres_admin(int $page, string $type = null): array
{

	$liste_chambres = [];

	$nb_chambres_par_page = 8;

	$database = connect_db();

	if (!is_null($type)) {

		$request = "SELECT * FROM chambre WHERE lib_typ = :lib_typ and est_actif = 1 and est_supprimer = 0 ORDER BY num_chambre ASC LIMIT " . $nb_chambres_par_page . "  OFFSET " . $nb_chambres_par_page * ($page - 1);

		$request_prepare = $database->prepare($request);

		$request_execution = $request_prepare->execute([
			'lib_typ' => $type
		]);
	} else {

		$request = "SELECT * FROM chambre WHERE est_actif = 1 and est_supprimer = 0 ORDER BY num_chambre ASC LIMIT " . $nb_chambres_par_page . "  OFFSET " . $nb_chambres_par_page * ($page - 1);

		$request_prepare = $database->prepare($request);

		$request_execution = $request_prepare->execute();
	}


	if (!empty($request_execution)) {

		$data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($data) && is_array($data)) {

			$liste_chambres = $data;
		}
	}

	return $liste_chambres;
}



/**
 * Récupère la liste des types de chambres disponibles.
 *
 * @return array Un tableau contenant les noms des types de chambres.
 */
function liste_types(): array
{

	$types = [];

	$database = connect_db();

	$request = "SELECT * FROM chambre WHERE est_actif = 1 and est_supprimer = 0";

	$request_prepare = $database->prepare($request);

	$request_execution = $request_prepare->execute();


	if (!empty($request_execution)) {

		$data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($data) && is_array($data)) {

			foreach ($data as $type) {
				$types[] = $type['lib_typ'];
			}

			$types = array_unique($types);
		}
	}

	return $types;
}



/**
 * Récupère une liste de repas en fonction de la pagination et de la catégorie donnée.
 *
 * @param int $page Le numéro de la page actuelle.
 * @param string|null $categorie La catégorie de repas (facultatif).
 * @return array Un tableau contenant les détails des repas récupérés.
 */
function liste_repas(int $page, string $categorie = null): array
{
    $liste_repas = [];
    $nb_repas_par_page = 8;
    $database = connect_db();

    try {
        if (!is_null($categorie)) {
            $request = "SELECT * FROM repas WHERE categorie = :categorie AND est_actif = 1 AND est_supprimer = 0 ORDER BY cod_repas ASC LIMIT :limit OFFSET :offset";
            $request_prepare = $database->prepare($request);
            $request_prepare->bindValue(':categorie', $categorie, PDO::PARAM_STR);
        } else {
            $request = "SELECT * FROM repas WHERE est_actif = 1 AND est_supprimer = 0 ORDER BY cod_repas ASC LIMIT :limit OFFSET :offset";
            $request_prepare = $database->prepare($request);
        }

        $request_prepare->bindValue(':limit', $nb_repas_par_page, PDO::PARAM_INT);
        $request_prepare->bindValue(':offset', $nb_repas_par_page * ($page - 1), PDO::PARAM_INT);

        $request_execution = $request_prepare->execute();

        if ($request_execution) {
            $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($data) && is_array($data)) {
                $liste_repas = $data;
            }
        }

    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }

    return $liste_repas;
}


/**
 * Récupère la liste des catégories de repas disponibles.
 *
 * @return array Un tableau contenant les noms des catégories.
 */
function liste_categorie(): array
{

	$categories = [];

	$database = connect_db();

	$request = "SELECT * FROM repas WHERE est_actif = 1 and est_supprimer = 0";

	$request_prepare = $database->prepare($request);

	$request_execution = $request_prepare->execute();


	if (!empty($request_execution)) {

		$data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($data) && is_array($data)) {

			foreach ($data as $categorie) {
				$categories[] = $categorie['categorie'];
			}

			$categories = array_unique($categories);
		}
	}

	return $categories;
}


/** Cette fonction permet d'inserer un utilisateur de profile CLIENT
 * @param string $nom
 * @param string $prenom
 * @param string $email
 * @param string $nom_utilisateur
 * @param string $mot_passe
 * @param string $profil
 * @return bool
 */
function enregistrer_utilisateur(string $nom, string $prenom, string $email, string $nom_utilisateur, string $mot_passe, string $profil = "CLIENT"): bool
{
	$enregistrer_utilisateur = false;

	$db = connect_db();

	if (is_object($db)) {

		// Ecriture de la requête
		$requette = 'INSERT INTO utilisateur (nom, prenom, email, nom_utilisateur, profil, mot_passe) VALUES (:nom, :prenom, :email, :nom_utilisateur, :profil, :mot_passe)';

		// Préparation
		$inserer_utilisateur = $db->prepare($requette);

		// Exécution ! La recette est maintenant en base de données
		$resultat = $inserer_utilisateur->execute([
			'nom' => $nom,
			'prenom' => $prenom,
			'email' => $email,
			'nom_utilisateur' => $nom_utilisateur,
			'profil' => $profil,
			'mot_passe' => sha1($mot_passe)
		]);

		$enregistrer_utilisateur = $resultat;
	}

	return $enregistrer_utilisateur;
}

/**
 * Cette fonction permet de verifier si un utilisateur dans la base de donnée ne possède pas cette adresse mail.
 * @param string $email L'email a vérifié.
 *
 * @return bool $check
 */
function check_email_exist_in_db(string $email): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT count(*) as nbr_utilisateur FROM utilisateur WHERE email = :email and est_supprimer = :est_supprimer";

		$verifier_email = $db->prepare($requette);

		$resultat = $verifier_email->execute([
			'email' => $email,
			'est_supprimer' => 0
		]);

		if ($resultat) {

			$nbr_utilisateur = $verifier_email->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];

			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}

/**
 * Cette fonction permet de verifier si un utilisateur dans la base de donnée possède cette adresse mail avec un profil "client".
 * @param string $email L'email à vérifier.
 *
 * @return bool $check Renvoie true si l'email existe dans la base de données avec le profil "client", sinon false.
 */
function check_email_and_profile_in_db(string $email): bool
{
	$check = false;
	$db = connect_db();

	if (is_object($db)) {
		$query = "SELECT count(*) as nbr_utilisateur FROM utilisateur WHERE email = :email AND est_supprimer = :est_supprimer AND profil = 'client'";

		$verify_email = $db->prepare($query);

		$result = $verify_email->execute([
			'email' => $email,
			'est_supprimer' => 0
		]);

		if ($result) {
			$nbr_utilisateur = $verify_email->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];
			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}

/**
 * Cette fonction permet de verifier si un utilisateur dans la base de donnée possède cette adresse mail avec un profil "ADMININISTRATEUR".
 * @param string $email L'email à vérifier.
 *
 * @return bool $check Renvoie true si l'email existe dans la base de données avec le profil "client", sinon false.
 */
function check_email_and_profile_admin_in_db(string $email): bool
{
	$check = false;
	$db = connect_db();

	if (is_object($db)) {
		$query = "SELECT count(*) as nbr_utilisateur FROM utilisateur WHERE email = :email AND est_supprimer = :est_supprimer AND profil = 'ADMINISTRATEUR'";

		$verify_email = $db->prepare($query);

		$result = $verify_email->execute([
			'email' => $email,
			'est_supprimer' => 0
		]);

		if ($result) {
			$nbr_utilisateur = $verify_email->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];
			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}

/**
 * Cette fonction permet de verifier si un utilisateur dans la base de donnée ne possède pas ce nom d'utilisateur.
 * @param string $nom_utilisateur Le nom d'utilisateur a vérifié.
 *
 * @return bool $check
 */
function check_user_name_exist_in_db(string $nom_utilisateur): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT count(*) as nbr_utilisateur FROM utilisateur WHERE nom_utilisateur = :nom_utilisateur and est_supprimer = :est_supprimer";

		$verifier_nom_utilisateur = $db->prepare($requette);

		$resultat = $verifier_nom_utilisateur->execute([
			'nom_utilisateur' => $nom_utilisateur,
			'est_supprimer' => 0
		]);

		if ($resultat) {

			$nbr_utilisateur = $verifier_nom_utilisateur->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];

			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}

/**
 * Cette fonction permet de verifier si un utilisateur dans la base de donnée ne possède pas cette contact.
 *
 * @param string $telephone Le téléphone a vérifié.
 * @return bool $check
 */
function check_telephone_exist_in_db(string $telephone): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT count(*) as nbr_utilisateur FROM utilisateur WHERE telephone = :telephone and est_supprimer = :est_supprimer";

		$verifier_email = $db->prepare($requette);

		$resultat = $verifier_email->execute([
			'telephone' => $telephone,
			'est_supprimer' => 0
		]);

		if ($resultat) {

			$nbr_utilisateur = $verifier_email->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];

			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}

/**
 * Cette fonction permet de verifier le profil administrateur
 *
 * @param int $id
 * @return bool $verifier_profil
 */
function verifier_profil_administrateur(int $id): bool
{
	$db = connect_db();

	if (is_object($db)) {
		// Requête pour vérifier si l'utilisateur a le profil d'administrateur
		$requete = "SELECT profil FROM utilisateur WHERE id = :id";
		$requete_preparee = $db->prepare($requete);
		$requete_preparee->execute([
			':id' => $id
		]);

		if ($requete_preparee) {
			$resultat = $requete_preparee->fetch(PDO::FETCH_ASSOC);

			// Vérifiez si l'utilisateur a le profil d'administrateur.
			if ($resultat && $resultat['profil'] === 'administrateur') {
				return true; // L'utilisateur a le profil d'administrateur.
			}
		}
	}

	return false; // L'utilisateur n'a pas le profil d'administrateur.
}

/**
 * Cette fonction permet d'envoyer un mail a un destinataire.
 *
 * @param string $destination The destination.
 * @param string $subject The subject.
 * @param string $body The body.
 * @return bool The result.
 */
function send_email(string $destination, string $subject, string $body): bool
{
	// passing true in constructor enables exceptions in PHPMailer
	$mail = new PHPMailer(true);
	$mail->CharSet = "UTF-8";

	try {

		// Server settings
		// for detailed debug output
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->Port = 587;

		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true,
			)
		);

		$mail->Username = MAIL_ADDRESS;
		$mail->Password = MAIL_PASSWORD;

		// Sender and recipient settings
		$mail->setFrom(MAIL_ADDRESS, htmlspecialchars_decode('HOTEL_SOUS_LES_COCOTIERS'));
		$mail->addAddress($destination, 'UTILISATEUR');
		$mail->addReplyTo(MAIL_ADDRESS, htmlspecialchars_decode('HOTEL_SOUS_LES_COCOTIERS'));

		// Setting the email content
		$mail->IsHTML();
		$mail->Subject = htmlspecialchars_decode($subject);
		$mail->Body = $body;

		return $mail->send();
	} catch (Exception $e) {
		return false;
	}
}

/**
 * Cette fonction permet d'inserer un token grâce à l'id de l'utilisateur dans la table token
 *
 * @param int $user_id L'id de l'utilisateur
 * @param string $type Le type de token
 * @param string $token Le token générer
 * @return bool
 */
function insertion_token(int $user_id, string $type, string $token): bool
{

	$insertion_token = false;

	$db = connect_db();

	if (is_object($db)) {

		$request = "INSERT INTO token (user_id, type, token) VALUES (:user_id, :type, :token)";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(
			[
				'user_id' => $user_id,
				'type' => $type,
				'token' => $token
			]
		);

		if ($request_execution) {

			$insertion_token = true;
		}
	}

	return $insertion_token;
}

/**
 * Cette fonction permet de récupérer l'id de l'utilisateur grâce a son adresse mail.
 *
 * @param string $email L'email de l'utilisateur.
 * @return int $user_id L'id de l'utilisateur.
 */
function recuperer_id_utilisateur_par_son_mail(string $email): int
{

	$user_id = 0;

	$db = connect_db();

	if (is_object($db)) {

		$request = "SELECT id FROM utilisateur WHERE email=:email";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute([
			'email' => $email
		]);

		if ($request_execution) {

			$data = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if (!empty($data) && is_array($data)) {

				$user_id = $data["id"];
			}
		}
	}
	return $user_id;
}

/**
 * Cette fonction permet de verifier si l'id de l'utilisateur existe dans la base de donnée .
 * @param int $user_id
 * @param string $token
 * @param string $type
 * @param int $est_actif
 * @param int $est_supprimer
 * @return bool $check
 */
function check_token_exist(int $user_id, string $token, string $type, int $est_actif = 1, int $est_supprimer = 0): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT * FROM token WHERE user_id = :user_id and token= :token and type= :type and est_actif= :est_actif and $est_supprimer= :est_supprimer";

		$verifier_id_utilisateur = $db->prepare($requette);

		$resultat = $verifier_id_utilisateur->execute([
			'user_id' => $user_id,
			'token' => $token,
			'type' => $type,
			'est_actif' => $est_actif,
			'est_supprimer' => $est_supprimer
		]);

		if ($resultat) {

			$data = $verifier_id_utilisateur->fetchAll(PDO::FETCH_ASSOC);

			if (!empty($data) && is_array($data)) {

				$check = true;
			}
		}
	}
	return $check;
}

/**
 * Cette fonction permet de mettre à jour la table est_supprimer du token à 1
 *
 * @param mixed $id_utilisateur L'id de l'utilisateur.
 * @return bool
 */
function suppression_logique_token(int $id_utilisateur): bool
{
	$suppression_logique_token = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE token SET est_actif = :est_actif, est_supprimer = :est_supprimer, maj_le = :maj_le WHERE user_id= :id_utilisateur";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(
			[
				'id_utilisateur' => $id_utilisateur,
				'est_actif' => 0,
				'est_supprimer' => 1,
				'maj_le' => $date
			]
		);

		$suppression_logique_token = $request_execution;
	}

	return $suppression_logique_token;
}

/**
 * Cette fonction permet de mettre à jour la table est_actif de l'utilisateur à 1
 *
 * @param mixed $id_utilisateur L'id de l'utilisateur.
 * @return bool
 */
function activation_compte_utilisateur(int $id_utilisateur): bool
{

	$activation_compte_utilisateur = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE utilisateur SET est_actif = :est_actif, maj_le = :maj_le WHERE id= :id_utilisateur";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(
			[
				'id_utilisateur' => $id_utilisateur,
				'est_actif' => 1,
				'maj_le' => $date
			]
		);
		$activation_compte_utilisateur = $request_execution;
	}

	return $activation_compte_utilisateur;
}

/**
 * Cette fonction permet de verifier si un utilisateur (email ou nom utilisateur + mot de passe) existe dans la base de donnée.
 *
 * @param string $email_user_name L'email ou nom utilisateur
 * @param string $password Le mot de passe de l'utilisateur
 * @param string $profil Le profil de l'utilisateur.
 * @param int $est_actif Le compte de l'utilisateur est actif
 * @param int $est_supprimer Le compte de l'utilisateur est supprimer
 * @return array $user Les informations de l'utilisateur
 */
function check_if_user_exist(string $email_user_name, string $password, string $profil, int $est_actif = 1, int $est_supprimer = 0): array
{

	$user = [];

	$db = connect_db();

	$requette = "SELECT id, nom, prenom, sexe, email, telephone, nom_utilisateur, avatar, profil, mot_passe FROM utilisateur WHERE (email =:email_user_name OR nom_utilisateur =:email_user_name) and profil = :profil and mot_passe = :mot_passe and est_actif= :est_actif and est_supprimer= :est_supprimer";

	$verifier_nom_utilisateur = $db->prepare($requette);

	$resultat = $verifier_nom_utilisateur->execute([
		'email_user_name' => $email_user_name,
		'nom_utilisateur' => $email_user_name,
		'mot_passe' => sha1($password),
		'profil' => $profil,
		'est_actif' => $est_actif,
		'est_supprimer' => $est_supprimer
	]);

	if ($resultat) {
		$user = $verifier_nom_utilisateur->fetch(PDO::FETCH_ASSOC);
		if (is_bool($user)) {
			$user = [];
		}
	}

	return $user;
}

/**
 * Cette fonction permet de verifier si le mot de passe de l'utilisateur existe dans la base de donnée.
 *
 * @param int $id L'id de l'utilisateur.
 * @param string $password Le mot de passe
 * @return bool
 */
function check_password_exist(string $password, int $id): bool
{
	$users = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = $db->prepare('SELECT id from utilisateur WHERE mot_passe= :mot_passe AND id= :id');

		$requette->execute(array(
			'mot_passe' => sha1($password),
			'id' => $id,
		));

		$users = $requette->fetch();
		if ($users) {

			$users = true;
		}
	}

	return $users;
}

/**
 * Cette fonction permet de savoir si un utilisateur administrateur est déjà connecté ou pas
 *
 * @return bool
 */
function check_if_user_connected_admin(): bool
{
	return !empty($_SESSION['utilisateur_connecter_admin']);
}

/**
 * Cette fonction permet de savoir si un utilisateur client est déjà connecté ou pas
 *
 * @return bool
 */
function check_if_user_connected_client(): bool
{
	return !empty($_SESSION['utilisateur_connecter_client']);
}

/**
 * Cette fonction permet de savoir si un utilisateur receptionniste est déjà connecté ou pas
 *
 * @return bool
 */
function check_if_user_connected_recept(): bool
{
	return !empty($_SESSION['utilisateur_connecter_recept']);
}

/**
 * Cette fonction permet d'effectuer la mise à jour du mot de passe de l'utilisateur
 *
 * @param int $id L'id de l'utilisateur.
 * @param string $password Le mot de passe
 * @return bool
 */
function mise_a_jour_mot_passe(int $id, string $password): bool
{

	$maj3 = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE utilisateur SET mot_passe = :mot_passe, maj_le = :maj_le  WHERE id= :id";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'id' => $id,
			'mot_passe' => sha1($password),
			'maj_le' => $date
		));

		if ($request_execution) {

			$maj3 = true;
		}
	}

	return $maj3;
}

/**
 * Cette fonction permet d'effectuer la mise à jour de l'avatar de l'utilisateur
 *
 * @param int $id L'id de l'utilisateur
 * @param string $avatar La photo de profil
 * @return bool
 */
function mise_a_jour_avatar(int $id, string $avatar): bool
{

	$mise_a_jour_avatar = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE utilisateur SET avatar = :avatar, maj_le = :maj_le  WHERE id= :id";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(
			[
				'id' => $id,
				'avatar' => $avatar,
				'maj_le' => $date,
			]
		);

		if ($request_execution) {

			$mise_a_jour_avatar = true;
		}
	}

	return $mise_a_jour_avatar;
}

/**
 * Cette fonction permet d'effectuer la mise à jour des nouvelles infos UTILISATEUR
 *
 * @param int $id
 * @param string $nom
 * @param string $prenom
 * @param int $telephone
 * @param string $nom_utilisateur
 * @return bool
 */
function mettre_a_jour_informations_utilisateur(int $id, string $nom, string $prenom, int $telephone, string $nom_utilisateur): bool
{

	$modifier_profil = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, telephone = :telephone, nom_utilisateur = :nom_utilisateur, maj_le = :maj_le WHERE id= :id";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'id' => $id,
			'nom' => $nom,
			'prenom' => $prenom,
			'telephone' => $telephone,
			'nom_utilisateur' => $nom_utilisateur,
			'maj_le' => $date
		));

		if ($request_execution) {

			$modifier_profil = true;
		}
	}

	return $modifier_profil;
}


/**
 *  Cette fonction permet de recuperer les nouvelles infos UTILISATEUR
 *
 * @param int $id
 * @return array
 */

function recuperer_mettre_a_jour_informations_utilisateur(int $id): array
{

	$recup = [];

	$db = connect_db();

	if (is_object($db)) {

		$request_recupere = $db->prepare('SELECT  id, nom, prenom, sexe, email, telephone, nom_utilisateur, avatar, profil FROM utilisateur WHERE id= :id');

		$resultat = $request_recupere->execute(array(
			'id' => $id,
		));

		if ($resultat) {
			$recup = $request_recupere->fetch(PDO::FETCH_ASSOC);
		}
	}

	return $recup;
}


/**
 * Cette fonction permet d'activer_utilisateur
 *
 * @param int $id
 * @return bool
 */
function activer_utilisateur(int $id): bool
{
	$profile_active = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		$request = "UPDATE utilisateur SET est_actif = :est_actif, maj_le = :maj_le WHERE id = :id";
		$request_prepare = $db->prepare($request);
		$request_execution = $request_prepare->execute(array(
			'id' => $id,
			'est_actif' => 1,
			'maj_le' => $date
		));

		if ($request_execution) {
			$profile_active = true;
		}
	}

	return $profile_active;
}


/**
 * Cette fonction permet de désactiver un UTILISATEUR
 *
 * @param int $id
 * @return bool
 */
function desactiver_utilisateur(int $id): bool
{

	$profile_desactive = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE utilisateur SET  est_actif = :est_actif, maj_le = :maj_le WHERE id= :id";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'id' => $id,
			'est_actif' => 0,
			'maj_le' => $date
		));

		if ($request_execution) {

			$profile_desactive = true;
		}
	}

	return $profile_desactive;
}


/**
 *  Cette fonction permet de supprimer un UTILISATEUR
 *
 * @param int $id
 * @return bool
 */
function supprimer_utilisateur(int $id): bool
{

	$profile_supprimer = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE utilisateur SET est_actif = :est_actif, est_supprimer = :est_supprimer, maj_le = :maj_le WHERE id= :id";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'id' => $id,
			'est_actif' => 0,
			'est_supprimer' => 1,
			'maj_le' => $date
		));

		if ($request_execution) {

			$profile_supprimer = true;
		}
	}

	return $profile_supprimer;
}


/**
 * Cette fonction permet d'inserer un utilisateur de profile ADMINISTRATEUR enregistrer_utilisateur_admin
 *
 * @param string $nom
 * @param string $prenom
 * @param string $sexe
 * @param int $telephone
 * @param string $email
 * @param string $nom_utilisateur
 * @param string $mot_passe
 * @param string $profil
 * @return bool
 */
function enregistrer_utilisateur_admin(string $nom, string $prenom, string $sexe, int $telephone, string $email, string $nom_utilisateur, string $mot_passe, string $profil): bool
{
	$enregistrer_utilisateur = false;

	$db = connect_db();

	if (is_object($db)) {

		// Ecriture de la requête
		$requette = 'INSERT INTO utilisateur (nom, prenom, sexe, telephone, email, nom_utilisateur, profil, mot_passe) VALUES (:nom, :prenom, :sexe, :telephone, :email, :nom_utilisateur, :profil, :mot_passe)';

		// Préparation
		$inserer_utilisateur = $db->prepare($requette);

		// Exécution ! La recette est maintenant en base de données
		$resultat = $inserer_utilisateur->execute([
			'nom' => $nom,
			'prenom' => $prenom,
			'sexe' => $sexe,
			'telephone' => $telephone,
			'email' => $email,
			'nom_utilisateur' => $nom_utilisateur,
			'profil' => $profil,
			'mot_passe' => sha1($mot_passe)
		]);

		$enregistrer_utilisateur = $resultat;
	}

	return $enregistrer_utilisateur;
}




/**
 * Récupère une liste de chambres en fonction de la pagination et du type de chambre donné.
 *
 * @param int $page Le numéro de la page actuelle.
 * @param string|null $type Le type de chambre (facultatif).
 * @return array Un tableau contenant les détails des chambres récupérées.
 */
function liste_utilisateurs(int $page, string $profil = null): array
{

	$liste_utilisateurs = [];

	$nb_utilisateurs_par_page = 8;

	$database = connect_db();

	if (!is_null($profil)) {

		$request = "SELECT * FROM utilisateur WHERE profil = :profil and  est_supprimer = 0 ORDER BY id ASC LIMIT " . $nb_utilisateurs_par_page . "  OFFSET " . $nb_utilisateurs_par_page * ($page - 1);

		$request_prepare = $database->prepare($request);

		$request_execution = $request_prepare->execute([
			'profil' => $profil
		]);
	} else {

		$request = "SELECT * FROM utilisateur WHERE est_supprimer = 0 ORDER BY id ASC LIMIT " . $nb_utilisateurs_par_page . "  OFFSET " . $nb_utilisateurs_par_page * ($page - 1);

		$request_prepare = $database->prepare($request);

		$request_execution = $request_prepare->execute();
	}


	if (!empty($request_execution)) {

		$data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($data) && is_array($data)) {

			$liste_utilisateurs = $data;
		}
	}

	return $liste_utilisateurs;
}


/**
 * Récupère la liste des types de chambres disponibles.
 *
 * @return array Un tableau contenant les noms des types de chambres.
 */
// function liste_profiles(): array
// {

// 	$profiles = [];

// 	$database = connect_db();

// 	$request = "SELECT * FROM utilisateur WHERE est_actif = 1 and est_supprimer = 0";

// 	$request_prepare = $database->prepare($request);

// 	$request_execution = $request_prepare->execute();


// 	if (!empty($request_execution)) {

// 		$data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

// 		if (!empty($data) && is_array($data)) {

// 			foreach ($data as $profiles) {
// 				$profiles[] = $profiles['profil'];
// 			}

// 			$profiles = array_unique($profiles);
// 		}
// 	}

// 	return $profiles;
// }

function liste_profiles(): array
{
    $profiles = [];

    $database = connect_db();

    $request = "SELECT DISTINCT profil FROM utilisateur WHERE est_actif = 1 AND est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute();

    if (!empty($request_execution)) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {
            foreach ($data as $row) {
                $profiles[] = $row['profil'];
            }
        }
    }

    return $profiles;
}



function liste_administrateurs_actifs(): array
{
    // Tableau pour stocker les administrateurs actifs
    $administrateurs = [];

    // Connexion à la base de données
    $database = connect_db();

    // Requête SQL pour récupérer les administrateurs actifs dont est_actif = 1 et est_supprimer = 0
    $request = "SELECT id FROM utilisateur WHERE profil = 'ADMINISTRATEUR' AND est_actif = 1 AND est_supprimer = 0";

    // Préparer la requête
    $request_prepare = $database->prepare($request);

    // Exécuter la requête
    $request_execution = $request_prepare->execute();

    // Vérifier si la requête a été exécutée avec succès
    if (!empty($request_execution)) {

        // Récupérer les résultats
        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        // Vérifier si des données sont récupérées et si c'est un tableau
        if (!empty($data) && is_array($data)) {
            // Parcourir chaque ligne et ajouter l'ID à la liste des administrateurs
            foreach ($data as $row) {
                $administrateurs[] = $row['id'];
            }
        }
    }

    // Retourner la liste des administrateurs actifs
    return $administrateurs;
}



/**
 * Cette fonction permet de récupérer la liste des utilisateurs de la base de donnée.
 *
 * @return array $liste_utilisateurs La liste des utilisateurs.
 */
function recuperer_liste_utilisateurs(): array
{
	$liste_utilisateurs = [];
	$db = connect_db();

	if (is_object($db)) {
		$requette = 'SELECT * FROM utilisateur';
		$verifier_liste_utilisateurs = $db->prepare($requette);
		$resultat = $verifier_liste_utilisateurs->execute();

		if ($resultat) {
			$liste_utilisateurs = $verifier_liste_utilisateurs->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_utilisateurs;
}



/**
 * Cette fonction permet de supprimer un utilisateur de façon définitive de la base de données à partir de son id.
 *
 * @param int $id L'id de l'utilisateur'.
 * @return bool Indique si la suppression a réussi ou non.
 */
function suppression_compte_utilisateur(int $id): bool
{
	$utilisateur_est_supprimer = false;

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'DELETE FROM utilisateur WHERE id = :id';

		$supprimer_chambre = $db->prepare($requete);

		$resultat = $supprimer_chambre->execute([
			'id' => $id,
		]);

		if ($resultat) {
			$utilisateur_est_supprimer = true;
		}
	}

	return $utilisateur_est_supprimer;
}


/**
 * Cette fonction permet d'enregistrer un repas
 *
 * @param string $nom_repas
 * @param string $descriptions
 * @param int $pu_repas
 * @param string $categorie
 * @param string $image_path
 * @param int $est_actif
 * @return bool
 */
function enregistrer_repas(string $nom_repas, string $descriptions, int $pu_repas, string $categorie, string $image_path, int $est_actif = 1): bool
{
	$enregistrer_repas = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = 'INSERT INTO repas (nom_repas, descriptions, pu_repas, categorie, photos, est_actif) VALUES (:nom_repas, :descriptions, :pu_repas, :categorie, :photos, :est_actif)';

		$inserer_repas = $db->prepare($requette);

		$resultat = $inserer_repas->execute([
			'nom_repas' => $nom_repas,
			'descriptions' => $descriptions,
			'pu_repas' => $pu_repas,
			'categorie' => $categorie,
			'photos' => $image_path,
			'est_actif' => $est_actif
		]);

		$enregistrer_repas = $resultat;
	}

	return $enregistrer_repas;
}


/**
 * Cette fonction permet de verifier si l'un repas dans la base de donnée ne possède pas ce nom.
 * @param string $nom_repas Le nom du repas a vérifié.
 *
 * @return bool $check
 */
function check_if_repas_exist_in_db(string $nom_repas): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT count(*) as nbr_repas FROM repas WHERE nom_repas = :nom_repas and est_supprimer = :est_supprimer";

		$verifier_nom_repas = $db->prepare($requette);

		$resultat = $verifier_nom_repas->execute([
			'nom_repas' => $nom_repas,
			'est_supprimer' => 0
		]);

		if ($resultat) {

			$nbr_utilisateur = $verifier_nom_repas->fetch(PDO::FETCH_ASSOC)["nbr_repas"];

			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}


/**
 * Cette fonction permet de récupérer la liste des repas de la base de donnée.
 *
 * @return array $liste_repas La liste des repas.
 */
function recuperer_liste_repas(): array
{
	$liste_repas = [];
	$db = connect_db();

	if (is_object($db)) {
		$requette = 'SELECT * FROM repas';
		$verifier_liste_repas = $db->prepare($requette);
		$resultat = $verifier_liste_repas->execute();

		if ($resultat) {
			$liste_repas = $verifier_liste_repas->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_repas;
}


/**
 * Cette fonction permet de récupérer les informations d'un repas à partir de son code repas.
 *
 * @param int $cod_repas Le code du repas.
 * @return array
 */
function recuperer_repas_par_son_code_repas(int $cod_repas): array
{
	$repas = [];

	$db = connect_db();

	$requette = 'SELECT * FROM repas WHERE cod_repas = :cod_repas ';

	$verifier_repas = $db->prepare($requette);

	$resultat = $verifier_repas->execute([
		"cod_repas" => $cod_repas
	]);

	if ($resultat) {

		$repas = $verifier_repas->fetch(PDO::FETCH_ASSOC);
	}

	return $repas;
}


/**
 * Cette fonction permet d'effectuer la mise à jour de la photo de repas
 *
 * @param int $cod_repas Le numéro  du repas
 * @param string $photo La photo du repas
 * @return bool
 */
function mise_a_jour_photo_repas(int $cod_repas, string $photo): bool
{

	$mise_a_jour_photo_repas = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE repas SET photos = :photos, maj_le = :maj_le  WHERE cod_repas= :cod_repas";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(
			[
				'cod_repas' => $cod_repas,
				'photos' => $photo,
				'maj_le' => $date,
			]
		);

		if ($request_execution) {

			$mise_a_jour_photo_repas = true;
		}
	}

	return $mise_a_jour_photo_repas;
}


/**
 * Cette fonction permet de modifier un repas existant dans la base de données via son code repas.
 *
 * @param int $cod_repas
 * @param string $nom_repas
 * @param string $descriptions
 * @param int $pu_repas
 * @param string $categorie
 * @return bool
 */
function modifier_repas(int $cod_repas, string $nom_repas, string $descriptions, int $pu_repas, string $categorie): bool
{
	$modifier_repas = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'UPDATE repas SET nom_repas = :nom_repas, descriptions= :descriptions, pu_repas = :pu_repas, categorie = :categorie, maj_le = :maj_le  WHERE cod_repas = :cod_repas';

		$modifier_repas = $db->prepare($requete);

		$resultat = $modifier_repas->execute([
			'cod_repas' => $cod_repas,
			'nom_repas' => $nom_repas,
			'descriptions' => $descriptions,
			'categorie' => $categorie,
			'pu_repas' => $pu_repas,
			'maj_le' => $date
		]);

		if ($resultat) {
			$modifier_repas = true;
		}
	}

	return $modifier_repas;
}

/**
 * Cette fonction permet de supprimer un repas de la base de données à partir de son code repas.
 *
 * @param int $cod_repas Le code du repas.
 * @return bool Indique si la suppression a réussi ou non.
 */
function supprimer_repas(int $cod_repas): bool
{
	$repas_est_supprime = false;

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'DELETE FROM repas WHERE cod_repas = :cod_repas';

		$supprimer_repas = $db->prepare($requete);

		$resultat = $supprimer_repas->execute([
			'cod_repas' => $cod_repas,
		]);

		if ($resultat) {
			$repas_est_supprime = true;
		}
	}

	return $repas_est_supprime;
}


/**
 * Cette fonction permet d'enregistrer une chambre
 *
 * @param int $cod_typ
 * @param string $lib_typ
 * @param string $details_chambre
 * @param int $details_personne_chambre
 * @param string $details_superficie_chambre
 * @param float $pu
 * @param string $image_path
 * @param int $est_actif
 * @return bool
 */
function enregistrer_chambre(int $cod_typ, string $lib_typ, string $details_chambre, int $details_personne_chambre, string $details_superficie_chambre, float $pu, string $image_path, int $est_actif = 1): bool
{
	$enregistrer_chambre = false;
	$db = connect_db();

	if (is_object($db)) {
		$requette = 'INSERT INTO chambre (cod_typ, lib_typ, details, personnes, superficies, pu, photos, est_actif) VALUES (:cod_typ, :lib_typ, :details, :personnes, :superficies, :pu, :photos, :est_actif)';
		$inserer_chambre = $db->prepare($requette);

		$resultat = $inserer_chambre->execute([
			'cod_typ' => $cod_typ,
			'lib_typ' => $lib_typ,
			'details' => $details_chambre,
			'personnes' => $details_personne_chambre,
			'superficies' => $details_superficie_chambre,
			'pu' => $pu,
			'photos' => $image_path,
			'est_actif' => $est_actif
		]);

		$enregistrer_chambre = $resultat;
	}

	return $enregistrer_chambre;
}


/**
 * Cette fonction permet de verifier si l'une chambres dans la base de donnée ne possède pas ce numeros.
 * @param int $num_chambre Le numéro de chambre a vérifié.
 *
 * @return bool $check
 */
function check_if_chambre_exist_in_db(int $num_chambre): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT count(*) as nbr_chambre FROM chambre WHERE num_chambre = :num_chambre and est_supprimer = :est_supprimer";

		$verifier_num_chambre = $db->prepare($requette);

		$resultat = $verifier_num_chambre->execute([
			'num_chambre' => $num_chambre,
			'est_supprimer' => 0
		]);

		if ($resultat) {

			$nbr_utilisateur = $verifier_num_chambre->fetch(PDO::FETCH_ASSOC)["nbr_chambre"];

			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}


/**
 * Cette fonction permet de récupérer la liste des chambres de la base de donnée.
 *
 * @return array $liste_chambre La liste des chambres.
 */
function recuperer_liste_chambres(): array
{
	$liste_chambre = [];
	$db = connect_db();

	if (is_object($db)) {

		$requette = 'SELECT * FROM chambre';

		$verifier_liste_chambres = $db->prepare($requette);

		$resultat = $verifier_liste_chambres->execute();

		if ($resultat) {

			$liste_chambre = $verifier_liste_chambres->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_chambre;
}


/**
 * Cette fonction permet de récupérer les informations d'une chambre à partir de son num_chambre.
 *
 * @param int $num_chambre Le numéro de chambre
 * @return array
 */
function recuperer_chambre_par_son_num_chambre(int $num_chambre): array
{
	$chambre = [];

	$db = connect_db();

	$requette = 'SELECT * FROM chambre WHERE num_chambre = :num_chambre ';

	$verifier_chambre = $db->prepare($requette);

	$resultat = $verifier_chambre->execute([
		"num_chambre" => $num_chambre
	]);

	if ($resultat) {

		$chambre = $verifier_chambre->fetch(PDO::FETCH_ASSOC);
	}

	return $chambre;
}


/**
 * Cette fonction permet de vérifier si une chambre dans la base de données est active et non supprimée.
 * @param int $num_chambre Le numéro de la chambre à vérifier.
 * @return bool $check
 */
function verifier_chambre_actif_non_supprime(int $num_chambre): bool
{
	$check = false;

	$db = connect_db();

	if (is_object($db)) {
		$requete = "SELECT count(*) as nbr_chambre FROM chambre WHERE num_chambre = :num_chambre AND est_actif = :est_actif AND est_supprimer = :est_supprimer";
		$verifier_chambre = $db->prepare($requete);

		$resultat = $verifier_chambre->execute([
			'num_chambre' => $num_chambre,
			'est_actif' => 1,
			'est_supprimer' => 0
		]);

		if ($resultat) {
			$nbr_chambre = $verifier_chambre->fetch(PDO::FETCH_ASSOC)["nbr_chambre"];
			$check = $nbr_chambre > 0;
		}
	}

	return $check;
}


/**
 * Cette fonction permet de modifier une chambre existant dans la base de données via son numéro de chambre.
 *
 * @param int $num_chambre Le numéro de chambre
 * @param int $cod_typ Le code type de chambre
 * @param string $lib_typ Le libellé du type  de chambre
 * @param string $details Le details du type  de chambre
 * @param string $personnes Le nombre de personne pour chambre
 * @param string $superficies La superficies du type  de chambre
 * @param int $pu Le prix unitaire  de la chambre
 * @return bool Indique si la modification a réussi ou non.
 */

function modifier_chambre(int $num_chambre, int $cod_typ, string $lib_typ, string $details, string $personnes, string $superficies, int $pu): bool
{
	$modifier_chambre = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'UPDATE chambre SET cod_typ = :cod_typ, lib_typ = :lib_typ, details = :details, personnes = :personnes, superficies= :superficies, pu = :pu, maj_le = :maj_le  WHERE num_chambre = :num_chambre';

		$modifier_chambre = $db->prepare($requete);

		$resultat = $modifier_chambre->execute([
			'num_chambre' => $num_chambre,
			'cod_typ' => $cod_typ,
			'lib_typ' => $lib_typ,
			'details' => $details,
			'personnes' => $personnes,
			'superficies' => $superficies,
			'pu' => $pu,
			'maj_le' => $date
		]);

		if ($resultat) {

			$modifier_chambre = true;
		}
	}

	return $modifier_chambre;
}


/**
 * Cette fonction permet d'effectuer la mise à jour de la photo de chambre
 *
 * @param int $num_chambre Le numéro  de chambre
 * @param string $photo La photo de chambre
 * @return bool
 */
function mise_a_jour_photo_chambre(int $num_chambre, string $photo): bool
{

	$mise_a_jour_photo_chambre = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE chambre SET photos = :photos, maj_le = :maj_le  WHERE num_chambre= :num_chambre";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(
			[
				'num_chambre' => $num_chambre,
				'photos' => $photo,
				'maj_le' => $date,
			]
		);

		if ($request_execution) {

			$mise_a_jour_photo_chambre = true;
		}
	}

	return $mise_a_jour_photo_chambre;
}


/**
 * Cette fonction permet de supprimer defintivement une chambre de la base de données à partir de son numero de chambre.
 *
 * @param int $num_chambre Le numero de chambre.
 * @return bool Indique si la suppression a réussi ou non.
 */
function supprimer_chambre(int $num_chambre): bool
{
	$chambre_est_supprimer = false;

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'DELETE FROM chambre WHERE num_chambre = :num_chambre';

		$suppression_reussie = $db->prepare($requete);

		$resultat = $suppression_reussie->execute([
			'num_chambre' => $num_chambre,
		]);

		if ($resultat) {
			$chambre_est_supprimer = true;
		}
	}

	return $chambre_est_supprimer;
}


/**
 * Cette fonction permet d'obtenir un numéro de chambre selon le type.
 * @param string $type Le type de chambre.
 *
 * @return int|null $num
 */
function obtenir_numero_chambre_disponible(string $type): ?int
{
	$num = null;

	$db = connect_db();

	if (is_object($db)) {
		$requette = "SELECT num_chambre FROM chambre WHERE est_actif = :est_actif and lib_typ = :lib_typ";

		$verifier_liste_chambres = $db->prepare($requette);

		$resultat = $verifier_liste_chambres->execute([
			'est_actif' => 1,
			'lib_typ' => $type
		]);

		if ($resultat) {
			$chambre = $verifier_liste_chambres->fetch(PDO::FETCH_ASSOC);
			if ($chambre) {
				$num = $chambre['num_chambre'];
			}
		}
	}

	return $num;
}


/**
 * Cette fonction permet d'enregistrer un client lors d'une reservation
 *
 * @param string $nom_clt
 * @param string $contact
 * @param string $email
 * @return bool
 */
function enregistrer_client(string $nom_clt, string $contact, string $email): bool
{
	$enregistrer_client = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = 'INSERT INTO clt (nom_clt, contact, email) VALUES (:nom_clt, :contact, :email)';

		$inserer_client = $db->prepare($requette);

		$resultat = $inserer_client->execute([
			'nom_clt' => $nom_clt,
			'contact' => $contact,
			'email' => $email
		]);

		$enregistrer_client = $resultat;
	}

	return $enregistrer_client;
}


/**
 * Cette fonction permet de verifier si un client dans la base de donnée ne possède pas cette adresse mail.
 * @param string $email L'email à vérifier.
 *
 * @return bool $check
 */
function verifier_email_client_exist_in_db(string $email): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT count(*) as nbr_utilisateur FROM clt WHERE email = :email and est_supprimer = :est_supprimer";

		$verifier_email = $db->prepare($requette);

		$resultat = $verifier_email->execute([
			'email' => $email,
			'est_supprimer' => 0
		]);

		if ($resultat) {

			$nbr_utilisateur = $verifier_email->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];

			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}


/**
 * Cette fonction permet de récupérer l'id du client grâce a son mail.
 *
 * @param string $email
 * @return int
 */
function recuperer_id_client_par_son_mail(string $email): int
{

	$client_id = 0;

	$db = connect_db();

	if (is_object($db)) {

		$request = "SELECT id FROM clt WHERE email=:email";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute([
			'email' => $email
		]);

		if ($request_execution) {

			$data = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if (!empty($data) && is_array($data)) {

				$client_id = $data["id"];
			}
		}
	}
	return $client_id;
}


/**
 * Cette fonction permet de récupérer les informations d'un client à partir de son id.
 *
 * @param int $id Le numéro de client
 * @return array
 */
function recuperer_user_par_son_id(int $id): array
{
	$client = [];

	$db = connect_db();

	$requette = 'SELECT * FROM utilisateur WHERE id = :id ';

	$verifier_client = $db->prepare($requette);

	$resultat = $verifier_client->execute([
		"id" => $id
	]);

	if ($resultat) {

		$client = $verifier_client->fetch(PDO::FETCH_ASSOC);
	}

	return $client;
}


/**
 * Cette fonction permet d'effectuer la mise à jour de la photo de chambre
 *
 * @param int $id L'id  de l'user
 * @param string $avatar La photo de l'user
 * @return bool
 */
function mise_a_jour_photo_user(int $id, string $avatar): bool
{

	$mise_a_jour_photo_user = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE utilisateur SET avatar = :avatar, maj_le = :maj_le  WHERE id= :id";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(
			[
				'id' => $id,
				'avatar' => $avatar,
				'maj_le' => $date,
			]
		);

		if ($request_execution) {

			$mise_a_jour_photo_user = true;
		}
	}

	return $mise_a_jour_photo_user;
}


/**
 * Cette fonction permet de modifier user existant dans la base de données via son id
 *
 * @param int $id
 * @param string $nom
 * @param string $prenom
 * @param string $sexe
 * @param int $telephone
 * @param string $email
 * @param string $nom_utilisateur
 * @param string $profil
 * @return bool
 */
function modifier_user(int $id, string $nom, string $prenom, string $sexe, int $telephone, string $email, string $nom_utilisateur, string $profil): bool
{
	$modifier_user = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'UPDATE utilisateur SET nom = :nom, prenom = :prenom, sexe = :sexe, telephone = :telephone, email= :email, nom_utilisateur= :nom_utilisateur, profil = :profil, maj_le = :maj_le  WHERE id = :id';

		$modifier_user = $db->prepare($requete);

		$resultat = $modifier_user->execute([
			'id' => $id,
			'nom' => $nom,
			'prenom' => $prenom,
			'sexe' => $sexe,
			'telephone' => $telephone,
			'email' => $email,
			'nom_utilisateur' => $nom_utilisateur,
			'profil' => $profil,
			'maj_le' => $date
		]);

		if ($resultat) {

			$modifier_user = true;
		}
	}

	return $modifier_user;
}


/**
 * Cette fonction permet de récupérer le type de chambre lors d'une réservation.
 *
 * @param int $num_chambre Le numéro de la chambre.
 * @return string|bool Le type de chambre ou false si non trouvé.
 */
function recuperer_type_chambre(int $num_chambre): bool|string
{
	$db = connect_db();

	if (is_object($db)) {

		$requete_chambre = 'SELECT lib_typ FROM chambre WHERE num_chambre = :num_chambre';

		$recuperer_chambre = $db->prepare($requete_chambre);

		if ($recuperer_chambre->execute(['num_chambre' => $num_chambre])) {

			$resultat_chambre = $recuperer_chambre->fetch(PDO::FETCH_ASSOC);

			if ($resultat_chambre && isset($resultat_chambre['lib_typ'])) {

				return $resultat_chambre;  // Retourner directement le tableau associatif
			}
		}
	}

	return false;
}


/**
 * Cette fonction permet de recuperer le prix de chambre par le type
 *
 * @param string $type_chambre
 * @return bool|array
 */
function recuperer_prix_chambre(string $type_chambre): bool|array
{
	$db = connect_db();

	if (is_object($db)) {

		$requete_prix = 'SELECT montant FROM prix_chambres WHERE type_chambre = :type_chambre';

		$recuperer_prix = $db->prepare($requete_prix);

		if ($recuperer_prix->execute(['type_chambre' => $type_chambre])) {

			$resultat_prix = $recuperer_prix->fetch(PDO::FETCH_ASSOC);

			if ($resultat_prix && isset($resultat_prix['montant'])) {

				return $resultat_prix;  // Retourner directement le tableau associatif
			}
		}
	}

	return false;
}

/**
 * Cette fonction permet d'enregistrer une reservation
 *
 * @param $numRes
 * @param int $numClient
 * @param $montantTotal
 * @return bool
 */
function enregistrer_reservation($numRes, int $numClient, $montantTotal): bool
{
	$enregistrer_reservation = false;

	$db = connect_db();

	if (is_object($db)) {

		// Requête SQL pour insérer les informations de réservation dans la table "reservation"
		$requete = 'INSERT INTO reservations (num_res, num_clt, prix_total) VALUES (:num_res, :num_clt, :prix_total)';

		// Préparation de la requête SQL pour éviter les injections SQL
		$inserer_reservation = $db->prepare($requete);

		// Exécution de la requête préparée pour insérer les informations de réservation
		$resultat = $inserer_reservation->execute([
			'num_res' => $numRes,
			'num_clt' => $numClient,
			'prix_total' => $montantTotal
		]);
		// Mettre à jour le booléen en fonction du résultat de l'insertion
		$enregistrer_reservation = $resultat;
	}

	return $enregistrer_reservation;
}

/**
 * Cette fonction permet de recuperer les informations du client principale par le num_res
 *
 * @param string $num_res
 * @return null
 */
function get_reservation_user_info(string $num_res)
{
	$db = connect_db();

	if (is_object($db)) {
		$requete = 'SELECT utilisateur.* FROM utilisateur INNER JOIN reservations ON utilisateur.id = reservations.num_clt WHERE reservations.num_res = :num_res';
		$verifier_reservation = $db->prepare($requete);
		$verifier_reservation->bindParam(':num_res', $num_res, PDO::PARAM_INT);
		$verifier_reservation->execute();

		return $verifier_reservation->fetch(PDO::FETCH_ASSOC);
	}

	return null;
}


/**
 * Cette fonction permet de vérifier si le client de reservation exist dans la base de donnee
 *
 * @param int $num_clt
 * @param string $num_res
 * @return bool
 */
function verifier_client_reservation_exist_in_db(int $num_clt, string $num_res): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT count(*) as row_found FROM reservations WHERE num_clt = :num_clt and num_res = :num_res and est_supprimer = 0 and est_actif = 1";

		$verifier = $db->prepare($requette);

		$resultat = $verifier->execute([
			'num_clt' => $num_clt,
			'num_res' => $num_res,
		]);

		if ($resultat) {

			$row_found = $verifier->fetch(PDO::FETCH_ASSOC)["row_found"];

			$check = $row_found > 0;
		}
	}

	return $check;
}


/**
 *  Cette fonction permet de mettre a jour la reservation
 *
 * @param string $num_res
 * @param int $prix_total
 * @return bool
 */
function mettre_a_jour_reservation(string $num_res, int $prix_total): bool
{

	$maj = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE reservations SET prix_total = :prix_total, maj_le = :maj_le WHERE num_res= :num_res";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'num_res' => $num_res,
			'prix_total' => $prix_total,
			'maj_le' => $date
		));

		if ($request_execution) {

			$maj = true;
		}
	}

	return $maj;
}

/**
 *  Cette fonction permet d'enregistrer la reservation des chambres
 *
 * @param string $numRes
 * @param int $numChambreDisponible
 * @param string $debOcc
 * @param string $finOcc
 * @param int $montant
 * @return bool
 */
function enregistrer_reservation_chambres(string $numRes, int $numChambreDisponible, string $debOcc, string $finOcc, int $montant): bool
{
	$enregistrer_reservation_chambres = false;

	$db = connect_db();

	if (is_object($db)) {
		// Requête SQL pour insérer les informations de réservation dans la table "reservation"
		$requete = 'INSERT INTO reservation_chambres (num_res, num_chambre, deb_occ, fin_occ, montant) VALUES (:num_res, :num_chambre, :deb_occ, :fin_occ, :montant)';

		// Préparation de la requête SQL pour éviter les injections SQL
		$inserer_reservation = $db->prepare($requete);

		// Exécution de la requête préparée pour insérer les informations de réservation
		$resultat = $inserer_reservation->execute([
			'num_res' => $numRes,
			'num_chambre' => $numChambreDisponible,
			'deb_occ' => $debOcc,
			'fin_occ' => $finOcc,
			'montant' => $montant
		]);
		// Mettre à jour le booléen en fonction du résultat de l'insertion
		$enregistrer_reservation_chambres = $resultat;
	}

	return $enregistrer_reservation_chambres;
}


/**
 * supprimer_reservation_chambres
 *
 * @param mixed $num_res
 * @return bool
 */
function supprimer_reservation_chambres(mixed $num_res): bool
{
	$suppression_reussie = false;

	$db = connect_db();

	if (is_object($db)) {

		$requete = "DELETE FROM reservation_chambres WHERE num_res = :num_res";

		$suppression_reussie = $db->prepare($requete);

		$resultat = $suppression_reussie->execute([

			'num_res' => $num_res
		]);

		if ($resultat) {
			$suppression_reussie = true;
		}
	}

	return $suppression_reussie;
}

/**
 *  Cette fonction permet de mettre à jour le statut de chambre
 *
 * @param int $numChambreDisponible
 * @param $est_actif
 * @return bool
 */
function mettre_a_jour_statut_chambre_reserver(int $numChambreDisponible, $est_actif): bool
{

	$statut = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE chambre SET est_actif = :est_actif, maj_le = :maj_le WHERE num_chambre= :num_chambre";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'num_chambre' => $numChambreDisponible,
			'est_actif' => $est_actif,
			'maj_le' => $date
		));

		if ($request_execution) {

			$statut = true;
		}
	}

	return $statut;
}

/**
 * Cette fonction permet de récupérer le numero de res grâce num chambre .
 *
 * @param $numChambre
 * @return int|null
 */
function recuperer_num_res_par_num_chambre($numChambre): ?int
{
	$numReservation = null;

	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT num_res FROM reservations WHERE num_chambre = :num_chambre ORDER BY num_res DESC LIMIT 1';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute(['num_chambre' => $numChambre])) {

			$resultat = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if ($resultat && isset($resultat['num_res'])) {

				$numReservation = $resultat['num_res'];
			}
		}
	}

	return $numReservation;
}


/**
 * Cette fonction permet d'activer reservation
 *
 * @param string $num_res
 * @return bool
 */
function activer_reservation(string $num_res): bool
{
	$reservation_active = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		$request = "UPDATE reservations SET statut = :statut, maj_le = :maj_le WHERE num_res = :num_res";
		$request_prepare = $db->prepare($request);
		$request_execution = $request_prepare->execute(array(
			'num_res' => $num_res,
			'statut' => "Valider",
			'maj_le' => $date
		));

		if ($request_execution) {
			$reservation_active = true;
		}
	}

	return $reservation_active;
}


/**
 * Cette fonction permet d'activer reservation
 *
 * @param string $num_res
 * @return bool
 */
function rejeter_reservation(string $num_res): bool
{
	$reservation_rejeter = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		$request = "UPDATE reservations SET statut = :statut, maj_le = :maj_le WHERE num_res = :num_res";
		$request_prepare = $db->prepare($request);
		$request_execution = $request_prepare->execute(array(
			'num_res' => $num_res,
			'statut' => "Rejeter",
			'maj_le' => $date
		));

		if ($request_execution) {
			$reservation_rejeter = true;
		}
	}

	return $reservation_rejeter;
}


/**
 * recuperer_id_utilisateur_par_num_res
 *
 * @param mixed $num_res
 * @return int|null
 */
function recuperer_id_utilisateur_par_num_res(mixed $num_res): ?int
{
	$idUtilisateur = null;

	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT num_clt FROM reservations WHERE num_res = :num_res ORDER BY num_clt DESC LIMIT 1';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute(['num_res' => $num_res])) {

			$resultat = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if ($resultat && isset($resultat['num_clt'])) {

				$idUtilisateur = $resultat['num_clt'];
			}
		}
	}

	return $idUtilisateur;
}


/**
 * Cette fonction permet d'enregistrer un client lors d'une reservation
 *
 * @param string $nom_acc
 * @param $contact_acc
 * @return bool
 */
function enregistrer_accompagnateur(string $nom_acc, $contact_acc): bool
{
	$enregistrer_accompagnateur = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = 'INSERT INTO accompagnateur (nom_acc, contact) VALUES (:nom_acc, :contact)';

		$inserer_client = $db->prepare($requette);

		$resultat = $inserer_client->execute([
			'nom_acc' => $nom_acc,
			'contact' => $contact_acc
		]);

		$enregistrer_accompagnateur = $resultat;
	}

	return $enregistrer_accompagnateur;
}


/**
 * Cette fonction permet de mettre a jour accompagnateur
 *
 * @param int $contact_acc
 * @param string $nom_acc
 * @return bool
 */
function mettre_a_jour_accompagnateur(int $contact_acc, string $nom_acc): bool
{

	$maj = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE accompagnateur SET nom_acc = :nom_acc, maj_le = :maj_le WHERE contact= :contact";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'contact' => $contact_acc,
			'nom_acc' => $nom_acc,
			'maj_le' => $date
		));

		if ($request_execution) {

			$maj = true;
		}
	}

	return $maj;
}


/**
 * Cette fonction permet de verifier si un accompagnateur dans la base de donnée ne possède pas ce contact.
 *
 * @param string $nom_acc
 * @param string $contact_acc
 * @return bool $check
 */
function verifier_nom_contact_accompagnateur_exist_in_db(string $nom_acc, string $contact_acc): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT count(*) as nbr_utilisateur FROM accompagnateur WHERE nom_acc = :nom_acc and contact = :contact and est_supprimer = :est_supprimer";

		$verifier_contact = $db->prepare($requette);

		$resultat = $verifier_contact->execute([
			'nom_acc' => $nom_acc,
			'contact' => $contact_acc,
			'est_supprimer' => 0
		]);

		if ($resultat) {

			$nbr_utilisateur = $verifier_contact->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];

			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}


/**
 * Cette fonction permet de verifier si un accompagnateur dans la base de donnée ne possède pas ce contact.
 * @param string $contact_acc
 *
 * @return bool $check
 */
function verifier_contact_accompagnateur_exist_in_db(string $contact_acc): bool
{

	$check = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = "SELECT count(*) as nbr_utilisateur FROM accompagnateur WHERE contact = :contact and est_supprimer = :est_supprimer";

		$verifier_contact = $db->prepare($requette);

		$resultat = $verifier_contact->execute([
			'contact' => $contact_acc,
			'est_supprimer' => 0
		]);

		if ($resultat) {

			$nbr_utilisateur = $verifier_contact->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];

			$check = $nbr_utilisateur > 0;
		}
	}

	return $check;
}

/**
 * Cette fonction permet de récupérer le num_acc grâce a son contact.
 *
 * @param string $contact_acc
 * @return int $accompagnateur_id
 */
function recuperer_num_acc_par_son_contact(string $contact_acc): int
{

	$accompagnateur_id = 0;

	$db = connect_db();

	if (is_object($db)) {

		$request = "SELECT num_acc FROM accompagnateur WHERE contact=:contact";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute([
			'contact' => $contact_acc
		]);

		if ($request_execution) {

			$data = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if (isset($data["num_acc"])) {

				$accompagnateur_id = $data["num_acc"];
			}
		}
	}
	return $accompagnateur_id;
}


/**
 * Cette fonction permet d'enregistrer accompagnateur des reservations
 *
 * @param string $numReservation
 * @param int $num_chambre
 * @param int $numAccompagnateur
 * @return bool
 */
function enregistrer_accompagnateur_des_reservations(string $numReservation, int $num_chambre, int $numAccompagnateur): bool
{
	$enregistrer_accompagnateur = false;

	$db = connect_db();

	if (is_object($db)) {

		$requette = 'INSERT INTO listes_accompagnateurs_reservation (num_res, num_chambre, num_acc ) VALUES (:num_res, :num_chambre, :num_acc)';

		$inserer_accompagnateur = $db->prepare($requette);

		$resultat = $inserer_accompagnateur->execute([
			'num_chambre' => $num_chambre,
			'num_res' => $numReservation,
			'num_acc' => $numAccompagnateur
		]);

		$enregistrer_accompagnateur = $resultat;
	}

	return $enregistrer_accompagnateur;
}

/**
 * Cette fonction permet de mettre à jour l'état des réservations, des accompagnateurs et des chambres en fonction de la date de fin_occ
 *
 * @return void
 */
/* function mettre_a_jour_etat_reservations_accompagnateurs()
{
	$db = connect_db();

	if (is_object($db)) {
		// Récupérer la date et l'heure actuelles
		$now = date('Y-m-d');

		// Mettre à jour l'état des réservations dont la date de fin_occ est passée
		$requeteReservation = 'UPDATE reservations SET est_actif = 0, est_supprimer = 1 WHERE fin_occ < :now';
		$stmtReservation = $db->prepare($requeteReservation);
		$stmtReservation->bindParam(':now', $now);
		$stmtReservation->execute();

		// Mettre à jour l'état des accompagnateurs pour les réservations dont la date de fin_occ est passée
		$requeteAccompagnateur = 'UPDATE listes_accompagnateurs_reservation SET est_actif = 0 WHERE num_res IN (SELECT num_res FROM reservations WHERE fin_occ < :now)';
		$stmtAccompagnateur = $db->prepare($requeteAccompagnateur);
		$stmtAccompagnateur->bindParam(':now', $now);
		$stmtAccompagnateur->execute();

		// Mettre à jour l'état des chambres pour les réservations dont la date de fin_occ est passée
		$requeteChambre = 'UPDATE chambre SET est_actif = 1, est_supprimer = 0 WHERE num_chambre IN (SELECT num_chambre FROM reservations WHERE fin_occ < :now)';
		$stmtChambre = $db->prepare($requeteChambre);
		$stmtChambre->bindParam(':now', $now);
		$stmtChambre->execute();
	}
}
 */


/**
 * Cette fonction permet de récupérer le noms et contacts des accompagnateurs
 *
 * @param string $num_res
 * @return array
 */
function recuperer_noms_et_contacts_accompagnateurs(string $num_res): array
{
	$db = connect_db();
	$accompagnateurs_info = [];
	if (is_object($db)) {
		$requette = 'SELECT num_acc FROM listes_accompagnateurs_reservation WHERE num_res = :num_res and est_supprimer = 0';
		$verifier_liste_accompagnateurs = $db->prepare($requette);
		$resultat = $verifier_liste_accompagnateurs->execute(['num_res' => $num_res]);
		if ($resultat) {
			$numeros_accompagnateurs = $verifier_liste_accompagnateurs->fetchAll(PDO::FETCH_COLUMN);
			foreach ($numeros_accompagnateurs as $num_acc) {
				$info_acc = recuperer_info_accompagnateur($num_acc);
				// Assurez-vous que recuperer_info_accompagnateur est correctement définie et renvoie les informations appropriées
				if ($info_acc) {
					$accompagnateurs_info[] = $info_acc;
				}
			}
		}
	}
	return $accompagnateurs_info;
}

/**
 * recuperer_accompagnateurs_par_chambre_sur_une_reservation
 *
 * @param string $num_res
 * @param int $num_chambre
 * @return array
 */
function recuperer_accompagnateurs_par_chambre_sur_une_reservation(string $num_res, int $num_chambre): array
{
	$db = connect_db();
	$accompagnateurs = [];
	if (is_object($db)) {
		$requette = 'SELECT * FROM listes_accompagnateurs_reservation WHERE num_res = :num_res and num_chambre = :num_chambre and est_actif = 1 and est_supprimer = 0';
		$verifier_accompagnateurs = $db->prepare($requette);
		$resultat = $verifier_accompagnateurs->execute([
			'num_res' => $num_res,
			'num_chambre' => $num_chambre
		]);
		if ($resultat) {
			$numeros_accompagnateurs = $verifier_accompagnateurs->fetchAll(PDO::FETCH_ASSOC);
			foreach ($numeros_accompagnateurs as $num_acc) {
				$info_acc = recuperer_info_accompagnateur($num_acc['num_acc']);
				// Assurez-vous que recuperer_info_accompagnateur est correctement définie et renvoie les informations appropriées
				if ($info_acc) {
					$accompagnateurs[] = $info_acc;
				}
			}
		}
	}
	return $accompagnateurs;
}

/**
 * Cette fonction permet de récupérer les informations des accompagnateurs par le numero des accompagnateurs de la base de donnée.
 *
 * @param int $num_acc
 * @return array
 */
function recuperer_info_accompagnateur(int $num_acc): array
{
	$nom_accompagnateur = [];

	$db = connect_db();

	if (is_object($db)) {
		$requette = 'SELECT * FROM accompagnateur WHERE num_acc = :num_acc and est_supprimer = 0';

		$verifier_liste_accompagnateurs = $db->prepare($requette);

		if ($verifier_liste_accompagnateurs->execute([

			'num_acc' => $num_acc

		])) {
			$nom_accompagnateur = $verifier_liste_accompagnateurs->fetch(PDO::FETCH_ASSOC);
		}
	}
	return $nom_accompagnateur;
}

/**
 * Cette fonction permet de récupérer la liste des réservations de la base de donnée en fonction du client connecter.
 *
 * @return array $liste_reservation La liste des reservations.
 */
function recuperer_liste_reservations($num_clt = null): array
{
	$liste_reservation = [];
	$db = connect_db();

	if (is_object($db)) {

		if (is_null($num_clt)) {
			$requette = 'SELECT * FROM reservations WHERE est_actif=1 and est_supprimer=0';

			$verifier_liste_reservations = $db->prepare($requette);

			$resultat = $verifier_liste_reservations->execute();
		} elseif (!is_null($num_clt)) {
			$requette = 'SELECT * FROM reservations WHERE num_clt=:num_clt and est_actif=1 and est_supprimer=0';

			$verifier_liste_reservations = $db->prepare($requette);

			$resultat = $verifier_liste_reservations->execute([
				'num_clt' => $num_clt
			]);
		}

		if ($resultat) {

			$liste_reservation = $verifier_liste_reservations->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_reservation;
}

/**
 * Cette fonction permet de récupérer la liste des réservations de la base de donnée en fonction du client connecter.
 *
 * @return array $liste_reservation La liste des commandes.
 */
function recuperer_liste_commandes($num_clt = null): array
{
	$liste_commande = [];
	$db = connect_db();

	if (is_object($db)) {

		if (is_null($num_clt)) {
			$requette = 'SELECT * FROM commande WHERE est_actif=1 and est_supprimer=0';

			$verifier_liste_commande = $db->prepare($requette);

			$resultat = $verifier_liste_commande->execute();
		} elseif (!is_null($num_clt)) {
			$requette = 'SELECT * FROM commande WHERE num_clt=:num_clt and est_actif=1 and est_supprimer=0';

			$verifier_liste_commande = $db->prepare($requette);

			$resultat = $verifier_liste_commande->execute([
				'num_clt' => $num_clt
			]);
		}

		if ($resultat) {

			$liste_commande = $verifier_liste_commande->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_commande;
}

/**
 * recuperer_liste_chambres_reservations
 *
 * @param mixed $num_res
 * @return array
 */
function recuperer_liste_chambres_reservations(mixed $num_res): array
{
	$liste_chambres_reservations = [];
	$db = connect_db();

	if (is_object($db)) {

		$requette = 'SELECT * FROM reservation_chambres WHERE num_res=:num_res and est_actif=1 and est_supprimer=0';

		$verifier_liste_chambres_reservations = $db->prepare($requette);

		$resultat = $verifier_liste_chambres_reservations->execute([
			'num_res' => $num_res
		]);

		if ($resultat) {

			$liste_chambres_reservations = $verifier_liste_chambres_reservations->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_chambres_reservations;
}

/**
 * Cette fonction permet de récupérer la liste des accompagnateurs par le numero de reservation de la base de donnée.
 *
 * @return array $liste_accompagnateurs la liste_accompagnateurs
 */
function recuperer_liste_accompagnateurs($num_res): array
{
	$liste_accompagnateurs = [];
	$db = connect_db();

	if (is_object($db)) {

		$requette = 'SELECT * FROM listes_accompagnateurs_reservation WHERE num_res = :num_res and est_supprimer = 0';

		$verifier_liste_accompagnateurs = $db->prepare($requette);

		$resultat = $verifier_liste_accompagnateurs->execute([
			'num_res' => $num_res
		]);

		if ($resultat) {

			$liste_accompagnateurs = $verifier_liste_accompagnateurs->fetchAll(PDO::FETCH_ASSOC);

			// (var_dump($liste_accompagnateurs));
		}
	}
	return $liste_accompagnateurs;
}

/**
 * Cette fonction permet de récupérer le type de chambre pour une réservation.
 *
 * @param int $num_chambre Le numéro de la chambre.
 * @return string|bool Le type de chambre ou false si non trouvé.
 */
function recuperer_type_chambre_pour_affichage(int $num_chambre): bool|string
{
	$db = connect_db();

	if (is_object($db)) {
		// Requête pour récupérer le type de chambre associé au numéro de chambre
		$requete_chambre = 'SELECT lib_typ FROM chambre WHERE num_chambre = :num_chambre';

		$recuperer_chambre = $db->prepare($requete_chambre);

		if ($recuperer_chambre->execute(['num_chambre' => $num_chambre])) {

			$resultat_chambre = $recuperer_chambre->fetch(PDO::FETCH_ASSOC);

			if ($resultat_chambre && isset($resultat_chambre['lib_typ'])) {

				return $resultat_chambre['lib_typ'];
			}
		}
	}

	return false;
}

/**
 * Cette fonction permet de récupérer le photo de chambre pour une réservation.
 *
 * @param int $num_chambre Le numéro de la chambre.
 * @return string|bool Le type de chambre ou false si non trouvé.
 */
function recuperer_photo_chambre_pour_affichage(int $num_chambre): bool|string
{
	$db = connect_db();

	if (is_object($db)) {
		// Requête pour récupérer le type de chambre associé au numéro de chambre
		$requete_chambre = 'SELECT photos FROM chambre WHERE num_chambre = :num_chambre';

		$recuperer_chambre = $db->prepare($requete_chambre);

		if ($recuperer_chambre->execute(['num_chambre' => $num_chambre])) {

			$resultat_chambre = $recuperer_chambre->fetch(PDO::FETCH_ASSOC);

			if ($resultat_chambre && isset($resultat_chambre['photos'])) {

				return $resultat_chambre['photos'];
			}
		}
	}

	return false;
}


/**
 * Cette fonction permet de modifier la date de debut et fin occupations ainsi que le prix total pour le type de chambre solo.
 *
 * @param $num_chambre
 * @param int $num_res Le numéro de reservation $, int $finOcc, int $montantTotal
 * @param string $debOcc La date de début occupation de chambre
 * @param string $finOcc La date de fin occupation de chambre
 * @param $montantTotal
 * @return bool Indique si la modification a réussi ou non.
 * @throws \Exception
 */
function modifier_reservation_chambre($num_chambre, int $num_res, string $debOcc, string $finOcc, $montantTotal): bool
{
	$reservation_chambre_solo = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		// Calculer le montant total en fonction des dates saisies et du type de chambre
		$type_chambre = recuperer_type_chambre_pour_affichage($num_chambre);

		if ($type_chambre) {

			$prixParNuit = match ($type_chambre['lib_typ']) {
				'Solo' => 15000,
				'Doubles' => 25000,
				'Triples' => 35000,
				'Suite' => 50000,
				default => 0,
			};

			$dateDebut = new DateTime($debOcc);
			$dateFin = new DateTime($finOcc);

			// Calculer la différence en jours, y compris le jour de fin
			$diff = $dateDebut->diff($dateFin);
			$jours = $diff->days + 1;
			$montantTotal = $jours * $prixParNuit;

			$requete = 'UPDATE reservations SET deb_occ = :deb_occ, fin_occ = :fin_occ, prix_total = :prix_total, maj_le = :maj_le  WHERE num_res = :num_res';

			$reservation_chambre_solo = $db->prepare($requete);

			$resultat = $reservation_chambre_solo->execute([
				'num_res' => $num_res,
				'deb_occ' => $debOcc,
				'fin_occ' => $finOcc,
				'prix_total' => $montantTotal,
				'maj_le' => $date
			]);

			if ($resultat) {

				$reservation_chambre_solo = true;
			}
		}
	}
	return $reservation_chambre_solo;
}

/**
 * Cette fonction permet de mettre à jour les informations des accompagnateurs d'une réservation dans la table listes_accompagnateurs_reservation
 *
 * @param mixed $num_res
 * @param mixed $numAccompagnateur
 * @return bool
 */
function mis_a_jour_accompagnateur_des_reservations(mixed $num_res, mixed $numAccompagnateur): bool
{
	$enregistrer_accompagnateur = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		$requete = "INSERT INTO listes_accompagnateurs_reservation (num_res, num_acc, est_actif, est_supprimer, maj_le) VALUES (:num_res, :num_acc, 1, 0, :maj_le)";

		$inserer_accompagnateur = $db->prepare($requete);

		$resultat = $inserer_accompagnateur->execute([
			'num_res' => $num_res,
			'num_acc' => $numAccompagnateur,
			'maj_le' => $date
		]);

		$enregistrer_accompagnateur = $resultat;
	}

	return $enregistrer_accompagnateur;
}

/**
 * Cette fonction permet de supprimer les entrées d'accompagnateurs associées à une réservation dans la table listes_accompagnateurs_reservation.
 *
 * @param int $num_res Le numéro de réservation.
 * @return bool Indique si la suppression a réussi ou non.
 */
function supprimer_accompagnateurs_reservation(string $num_res): bool
{
	$suppression_reussie = false;

	$db = connect_db();

	if (is_object($db)) {

		$requete = "DELETE FROM listes_accompagnateurs_reservation WHERE num_res = :num_res";

		$suppression_reussie = $db->prepare($requete);

		$resultat = $suppression_reussie->execute([

			'num_res' => $num_res
		]);

		if ($resultat) {
			$suppression_reussie = true;
		}
	}

	return $suppression_reussie;
}

/**
 * Cette fonction permet de récupérer la liste des repas de la base de donnée.
 *
 * @return array $liste_repas La liste des repas.
 */
function recuperer_nom_prix_repas(): array
{
	$liste_repas = [];
	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT cod_repas, nom_repas, pu_repas FROM repas WHERE est_actif = 1';

		$verifier_liste_repas = $db->prepare($requete);

		$resultat = $verifier_liste_repas->execute();

		if ($resultat) {
			$liste_repas = $verifier_liste_repas->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	return $liste_repas;
}

/**
 * Cette fonction vérifie si la réservation appartient au client connecté
 *
 * @param string $numRes
 * @param int $clientConnecteID
 * @return bool
 */
function verifier_appartenance_reservation(string $numRes, int $clientConnecteID): bool
{
	$db = connect_db();

	if (is_object($db)) {
		// Préparez la requête SQL pour vérifier l'appartenance
		$requete = "SELECT COUNT(*) AS count FROM reservations WHERE num_res = :num_res AND num_clt = :num_clt AND est_supprimer = :est_supprimer";

		// Préparez la requête
		$request_prepare = $db->prepare($requete);

		// Exécutez la requête en passant les paramètres
		$resultat = $request_prepare->execute([
			'num_res' => $numRes,
			'num_clt' => $clientConnecteID,
			'est_supprimer' => 0
		]);

		// Vérifiez le résultat de la requête
		if ($resultat) {
			// Récupérez le nombre de lignes correspondantes
			$nombreLignes = $request_prepare->fetch(PDO::FETCH_ASSOC);

			// Si le nombre de lignes est supérieur à zéro, cela signifie que la réservation appartient au client
			if ($nombreLignes['count'] > 0) {
				return true;
			}
		}
	}

	// La réservation n'appartient pas au client
	return false;
}

/**
 * Cette fonction permet de vérifier si un numéro de réservation existe dans la base de données,
 *
 * @param string $numReservation
 * @return bool
 */
function verifier_existence_num_res(string $numReservation): bool
{
	$existe = false;

	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT COUNT(*) as count FROM reservations WHERE num_res = :num_res and statut = :statut and est_supprimer = :est_supprimer';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute([
			'num_res' => $numReservation,
			'statut' => "En cours de validation",
			'est_supprimer' => 0
		])) {

			$resultat = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if ($resultat && isset($resultat['count']) && $resultat['count'] > 0) {

				$existe = true;
			}
		}
	}

	return $existe;
}

/**
 * Cette fonction permet de vérifier si un numéro de réservation existe dans la base de données,
 *
 * @param string $numReservation
 * @return bool
 */
function verifier_existence_num_res_avec_statut(string $numReservation): bool
{
	$existe = false;

	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT COUNT(*) as count FROM reservations WHERE num_res = :num_res and statut = :statut and est_supprimer = :est_supprimer';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute([
			'num_res' => $numReservation,
			'statut' => "Valider",
			'est_supprimer' => 0
		])) {

			$resultat = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if ($resultat && isset($resultat['count']) && $resultat['count'] > 0) {

				$existe = true;
			}
		}
	}

	return $existe;
}

/**
 * Cette fonction permet de vérifier si un numéro de réservation existe dans la base de données,
 *
 * @param int $numChambre
 * @return bool
 */
function verifier_existence_num_chambre(int $numChambre): bool
{
	$existe = false;

	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT COUNT(*) as count FROM chambre WHERE num_chambre = :num_chambre and est_supprimer = :est_supprimer';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute([
			'num_chambre' => $numChambre,
			'est_supprimer' => 0
		])) {

			$resultat = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if ($resultat && isset($resultat['count']) && $resultat['count'] > 0) {

				$existe = true;
			}
		}
	}

	return $existe;
}

/**
 * Cette fonction permet de récupérer tous les informations qui concerne une réservation grâce num_chambre
 *
 * @param int $numChambre
 * @return void
 */
function recuperer_donnee_reservation_par_num_chambre(int $numChambre)
{
	$donneesReservation = null;

	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT * FROM reservation_chambres WHERE num_chambre = :num_chambre';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute([

			'num_chambre' => $numChambre

		])) {

			$donneesReservation = $request_prepare->fetch(PDO::FETCH_ASSOC);
		}
	}

	return $donneesReservation;
}


/**
 * Cette fonction permet de récupérer tous les informations qui concerne une réservation grâce son id
 *
 * @param mixed $id
 * @return void
 */
function recuperer_donnee_reservation_par_son_id(mixed $id)
{
	$donneesReservation = null;

	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT * FROM reservations WHERE id = :id';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute([

			'id' => $id

		])) {

			$donneesReservation = $request_prepare->fetch(PDO::FETCH_ASSOC);
		}
	}

	return $donneesReservation;
}

/**
 * Cette fonction permet de récupérer tous les informations qui concerne une réservation grâce num res
 *
 * @param string $numReservation
 * @return void
 */
function recuperer_donnees_reservation_par_num_res(string $numReservation)
{
	$donneesReservation = null;

	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT * FROM reservations WHERE num_res = :num_res';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute([

			'num_res' => $numReservation

		])) {

			$donneesReservation = $request_prepare->fetch(PDO::FETCH_ASSOC);
		}
	}

	return $donneesReservation;
}

/**
 * Cette fonction permet de verifier si la chambre est supprimer
 *
 * @param int $numChambre
 * @return bool
 */
function verifier_chambre_supprimer(int $numChambre): bool
{
	$estSupprimee = false;

	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT num_chambre FROM chambre WHERE num_chambre = :num_chambre AND est_actif = 0 AND est_supprimer = 0';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute([

			'num_chambre' => $numChambre

		])) {

			$resultat = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if ($resultat) {

				$estSupprimee = true;
			}
		}
	}

	return $estSupprimee;
}

/**
 * Cette fonction permet d'ajouter une commande avec un prix total
 *
 * @param int $num_res
 * @param int $numChambre
 * @param float $prix_total
 * @return bool
 */
function enregistrer_une_commande_avec_prix_total(int $num_res, int $numChambre, float $prix_total): bool
{
	$enregistrer_commande = false;

	$db = connect_db();

	if (is_object($db)) {

		$requete = "INSERT INTO commande (num_res, num_chambre, prix_total) VALUES (:num_res, :num_chambre, :prix_total)";

		$inserer_commande = $db->prepare($requete);

		$resultat = $inserer_commande->execute([
			'num_res' => $num_res,
			'num_chambre' => $numChambre,
			'prix_total' => $prix_total
		]);

		$enregistrer_commande = $resultat;
	}

	return $enregistrer_commande;
}

/**
 * Cette fonction permet de recuperer le num_cmd par le num_res
 *
 * @param int $num_res
 * @return int|null
 */
function recuperer_num_cmd_par_num_res(int $num_res): ?int
{
	$numCommande = null;
	$db = connect_db();

	if (is_object($db)) {
		$requete = 'SELECT num_cmd FROM commande WHERE num_res = :num_res ORDER BY creer_le DESC LIMIT 1';

		$request_prepare = $db->prepare($requete);

		if ($request_prepare->execute(['num_res' => $num_res])) {

			$resultat = $request_prepare->fetch(PDO::FETCH_ASSOC);

			if ($resultat && isset($resultat['num_cmd'])) {

				$numCommande = $resultat['num_cmd'];
			}
		}
	}

	return $numCommande;
}

/**
 * Cette fonction permet d'enregistrer une commande de repas
 *
 * @param int $numCommande
 * @param int $numChambre
 * @param int $codeRepas
 * @return bool
 */
function enregistrer_commande_repas(int $codeRepas, int $numCommande, int $numChambre): bool
{
	$enregistrerQuantite = false;
	$db = connect_db();

	if (is_object($db)) {
		$requete = 'INSERT INTO commande_repas (cod_repas, num_cmd, num_chambre) VALUES (:cod_repas, :num_cmd, :num_chambre)';
		$insererQuantite = $db->prepare($requete);

		if ($insererQuantite) {
			$resultat = $insererQuantite->execute([
				'cod_repas' => $codeRepas,
				'num_cmd' => $numCommande,
				'num_chambre' => $numChambre
			]);

			if ($resultat) {
				$enregistrerQuantite = true;
			} else {
				// En cas d'erreur lors de l'exécution de la requête, affichez les informations sur l'erreur
				$errorInfo = $insererQuantite->errorInfo();
				die("Erreur lors de l'insertion dans la table 'commande_repas': " . $errorInfo[2]);
			}
		} else {
			// En cas d'erreur lors de la préparation de la requête
			die("Erreur lors de la préparation de la requête 'INSERT'");
		}
	}

	return $enregistrerQuantite;
}

/**
 * Cette fonction récupère la liste des commandes pour un client connecté.
 *
 * @param int $clientConnecteID L'ID du client connecté.
 * @return array|bool Un tableau contenant les commandes ou false en cas d'erreur.
 */
function recuperer_liste_commandes_client(int $clientConnecteID): bool|array
{
	$db = connect_db();

	if (is_object($db)) {
		// Requête SQL pour récupérer les commandes du client connecté
		$requete = " SELECT c.num_cmd, c.num_res, c.num_chambre, c.prix_total, c.creer_le FROM commande c JOIN reservations r ON c.num_res = r.id WHERE r.num_clt = :num_clt AND c.est_actif = 1";

		// Préparez la requête
		$request_prepare = $db->prepare($requete);

		// Exécutez la requête en passant les paramètres
		$resultat = $request_prepare->execute([
			'num_clt' => $clientConnecteID
		]);

		// Vérifiez le résultat de la requête
		if ($resultat) {
			// Récupérez les commandes sous forme de tableau associatif
			return $request_prepare->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	// En cas d'erreur ou d'absence de commandes, retournez false
	return false;
}

/**
 * Cette fonction récupère la liste de toutes les commandes.
 *
 * @return array|bool Un tableau contenant les commandes ou false en cas d'erreur.
 */
function recuperer_liste_toutes_commandes(): bool|array
{
	$db = connect_db();

	if (is_object($db)) {
		// Requête SQL pour récupérer toutes les commandes
		$requete = "SELECT * FROM commande c WHERE c.est_actif = 1";

		// Préparez la requête
		$request_prepare = $db->prepare($requete);

		// Exécutez la requête
		$resultat = $request_prepare->execute();

		// Vérifiez le résultat de la requête
		if ($resultat) {
			// Récupérez les commandes sous forme de tableau associatif
			return $request_prepare->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	// En cas d'erreur ou d'absence de commandes, retournez false
	return false;
}

/**
 * Cette fonction permet de récupérer la liste des repas par le numero de commande de la base de donnée.
 *
 * @return array $liste_repas la liste_repas
 */
function recuperer_liste_repas_par_commande($num_cmd): array
{
	$liste_repas = [];
	$db = connect_db();

	if (is_object($db)) {

		$requette = 'SELECT * FROM commande_repas WHERE num_cmd = :num_cmd and est_actif = 1 and est_supprimer = 0';

		$verifier_liste_repas = $db->prepare($requette);

		$resultat = $verifier_liste_repas->execute([
			'num_cmd' => $num_cmd
		]);

		if ($resultat) {
			$liste_repas = $verifier_liste_repas->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_repas;
}

/**
 * Cette fonction permet de récupérer les informations des repas par leur code de repas de la base de données.
 *
 * @param int $cod_repas
 * @return array|null
 */
function recuperer_info_repas(int $cod_repas): ?array
{
	$nom_repas = null; // Initialisez à null au lieu d'un tableau vide

	$db = connect_db();

	if (is_object($db)) {

		$requette = 'SELECT * FROM repas WHERE cod_repas = :cod_repas and est_supprimer = 0';

		$verifier_liste_repas = $db->prepare($requette);

		if ($verifier_liste_repas->execute([

			'cod_repas' => $cod_repas

		])) {

			$nom_repas = $verifier_liste_repas->fetch(PDO::FETCH_ASSOC);

			// Vérifiez si la requête a renvoyé des résultats, sinon retournez null
			if (!$nom_repas) {

				$nom_repas = null;
			}
		}
	}
	return $nom_repas;
}

/**
 * Supprime les entrées des repas associées à une commande dans la table commande_repas.
 *
 * @param int $num_cmd Le numéro de commande.
 * @return bool Indique si la suppression a réussi ou non.
 */
function supprimer_repas_commande(int $num_cmd): bool
{
	$suppression_reussie = false;

	$db = connect_db();

	if (is_object($db)) {

		$requete = "DELETE FROM commande_repas WHERE num_cmd = :num_cmd";

		$suppression_reussie = $db->prepare($requete);

		$resultat = $suppression_reussie->execute([

			'num_cmd' => $num_cmd
		]);

		if ($resultat) {
			$suppression_reussie = true;
		}
	}

	return $suppression_reussie;
}

/**
 *  Cette fonction permet de mettre à jour le statut de chambre
 *
 * @param $num_cmd
 * @param $prix_total
 * @return bool
 */
function modifier_commande($num_cmd, $prix_total): bool
{
	$statut = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		$request = "UPDATE commande SET prix_total = :prix_total, maj_le = :maj_le WHERE num_cmd = :num_cmd";
		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'num_cmd' => $num_cmd,
			'prix_total' => $prix_total,
			'maj_le' => $date
		));

		if ($request_execution) {
			$statut = true;
		}
	}

	return $statut;
}

/**
 * Cette fonction permet de supprimer une commande
 *
 * @param int $num_cmd
 * @return bool
 */
function supprimer_commande(int $num_cmd): bool
{

	$supprimer_commande = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE commande SET  est_actif = :est_actif, est_supprimer = :est_supprimer, maj_le = :maj_le WHERE num_cmd= :num_cmd";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'num_cmd' => $num_cmd,
			'est_actif' => 0,
			'est_supprimer' => 1,
			'maj_le' => $date
		));

		if ($request_execution) {

			$supprimer_commande = true;
		}
	}

	return $supprimer_commande;
}

/**
 * Cette fonction permet de supprimer une commande administrateur
 *
 * @param int $num_cmd
 * @return bool
 */
function supprimer_commande_administrateur(int $num_cmd): bool
{

	$supprimer_commande_administrateur = false;

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'DELETE FROM commande WHERE num_cmd = :num_cmd';

		$suppression_reussie = $db->prepare($requete);

		$resultat = $suppression_reussie->execute([
			'num_cmd' => $num_cmd,
		]);

		if ($resultat) {
			$supprimer_commande_administrateur = true;
		}
	}

	return $supprimer_commande_administrateur;
}

/**
 * Cette fonction permet d'enregistrer les messages client
 *
 * @param mixed $numClient
 * @param mixed $type_sujet
 * @param mixed $messages
 * @return bool
 */
function enregistrer_messages(mixed $numClient, mixed $type_sujet, mixed $messages): bool
{
	$enregistrerMessages = false;
	$db = connect_db();

	if (is_object($db)) {

		$requete = 'INSERT INTO contact (num_clt, type_sujet, messages) VALUES (:num_clt, :type_sujet, :messages)';

		$inserermessage = $db->prepare($requete);

		if ($inserermessage) {
			$resultat = $inserermessage->execute([
				'num_clt' => $numClient,
				'type_sujet' => $type_sujet,
				'messages' => $messages
			]);

			if ($resultat) {
				$enregistrerMessages = true;
			} else {
				// En cas d'erreur lors de l'exécution de la requête, affichez les informations sur l'erreur
				$errorInfo = $inserermessage->errorInfo();
				die("Erreur lors de l'insertion dans la table 'contact': " . $errorInfo[2]);
			}
		} else {
			// En cas d'erreur lors de la préparation de la requête
			die("Erreur lors de la préparation de la requête 'INSERT'");
		}
	}

	return $enregistrerMessages;
}

/**
 * Cette fonction permet de récupérer la liste des messages de la base de donnée en fonction du client connecter.
 *
 * @return array $liste_messages La liste des messages.
 */
function recuperer_liste_messages($num_clt = null): array
{
	$liste_messages = [];
	$db = connect_db();

	if (is_object($db)) {

		if (is_null($num_clt)) {

			$requette = 'SELECT * FROM contact WHERE est_supprimer=0';

			$verifier_liste_messages = $db->prepare($requette);

			$resultat = $verifier_liste_messages->execute();
		} elseif (!is_null($num_clt)) {

			$requette = 'SELECT * FROM contact WHERE num_clt = :num_clt and est_supprimer = 0';

			$verifier_liste_messages = $db->prepare($requette);

			$resultat = $verifier_liste_messages->execute([
				'num_clt' => $num_clt
			]);
		}

		if ($resultat) {

			$liste_messages = $verifier_liste_messages->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_messages;
}

/**
 * Cette fonction permet de mettre a jour messages
 *
 * @param mixed $id
 * @param mixed $type_sujet
 * @param mixed $messages
 * @return bool
 */
function modifier_messages(mixed $id, mixed $type_sujet, mixed $messages): bool
{
	$statut = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE contact SET type_sujet = :type_sujet, messages = :messages, maj_le = :maj_le WHERE id = :id";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'id' => $id,
			'type_sujet' => $type_sujet,
			'messages' => $messages,
			'maj_le' => $date
		));

		if ($request_execution) {
			$statut = true;
		}
	}

	return $statut;
}

/**
 * Cette fonction permet de supprimer un message
 *
 * @param mixed $id
 * @return bool
 */
function supprimer_messages(int $id): bool
{

	$supprimer_messages = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {

		$request = "UPDATE contact SET  est_actif = :est_actif, est_supprimer = :est_supprimer, maj_le = :maj_le WHERE id= :id";

		$request_prepare = $db->prepare($request);

		$request_execution = $request_prepare->execute(array(
			'id' => $id,
			'est_actif' => 0,
			'est_supprimer' => 1,
			'maj_le' => $date
		));

		if ($request_execution) {

			$supprimer_messages = true;
		}
	}

	return $supprimer_messages;
}

/**
 * Cette fonction permet de récupérer la liste des clients de la base de donnée.
 *
 * @return array $liste_client La liste des clients.
 */
function recuperer_liste_clients_actifs(): array
{
	$liste_clients = [];

	$db = connect_db();

	if (is_object($db)) {
		$requette = 'SELECT * FROM utilisateur WHERE profil = :profil AND est_actif = :est_actif';

		$verifier_liste_clients = $db->prepare($requette);

		$resultat = $verifier_liste_clients->execute([
			'profil' => 'client',
			'est_actif' => 1
		]);

		if ($resultat) {
			$liste_clients = $verifier_liste_clients->fetchAll(PDO::FETCH_ASSOC);
		}
		//else{
		//	 Gestion d'erreur
		//	 Dans cet exemple, nous n'ajoutons rien à $liste_clients en cas d'erreur.
		//	 $liste_clients reste un tableau vide.
		//}
	}

	return $liste_clients;
}

/**
 * Cette fonction permet de récupérer la liste des reservations de la base de donnée.
 *
 * @return array $liste_des_reservations La liste des clients.
 */
function recuperer_liste_des_reservations(): array
{
	$liste_des_reservations = [];
	$db = connect_db();

	if (is_object($db)) {

		$requette = 'SELECT * FROM reservations';

		$verifier_liste_reservations = $db->prepare($requette);

		$resultat = $verifier_liste_reservations->execute();

		if ($resultat) {

			$liste_des_reservations = $verifier_liste_reservations->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_des_reservations;
}

/**
 * Cette fonction permet de supprimer une reservation administrateur
 *
 * @param string $num_res
 * @return bool
 */
function supprimer_reservations_administrateur(string $num_res): bool
{

	$supprimer_reservations_administrateur = false;

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'DELETE FROM reservations WHERE num_res = :num_res';

		$suppression_reussie = $db->prepare($requete);

		$resultat = $suppression_reussie->execute([
			'num_res' => $num_res,
		]);

		if ($resultat) {
			$supprimer_reservations_administrateur = true;
		}
	}

	return $supprimer_reservations_administrateur;
}

/**
 * Cette fonction permet de supprimer chambre reservation administrateur
 *
 * @param $num_res
 * @return bool
 */
function supprimer_chambre_reservations($num_res): bool
{

	$supprimer_chambre_reservations = false;

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'DELETE FROM reservation_chambres WHERE num_res = :num_res';

		$suppression_reussie = $db->prepare($requete);

		$resultat = $suppression_reussie->execute([
			'num_res' => $num_res,
		]);

		if ($resultat) {
			$supprimer_chambre_reservations = true;
		}
	}

	return $supprimer_chambre_reservations;
}

/**
 * Cette fonction permet de supprimer accompagnateur administrateur
 *
 * @param $num_res
 * @return bool
 */
function supprimer_accompagnateur_administrateur($num_res): bool
{

	$supprimer_accompagnateur_administrateur = false;

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'DELETE FROM listes_accompagnateurs_reservation WHERE num_res = :num_res';

		$suppression_reussie = $db->prepare($requete);

		$resultat = $suppression_reussie->execute([
			'num_res' => $num_res,
		]);

		if ($resultat) {
			$supprimer_accompagnateur_administrateur = true;
		}
	}

	return $supprimer_accompagnateur_administrateur;
}

/**
 * Cette fonction permet de récupérer la liste des accompagnateurs par le numero de reservation de la base de donnée.
 *
 * @return array $liste_accompagnateurs la liste_accompagnateurs
 */
function recuperer_liste_clients($num_res): array
{
	$liste_accompagnateurs = [];
	$db = connect_db();

	if (is_object($db)) {

		$requette = 'SELECT * FROM utilisateur WHERE num_res = :num_res and est_supprimer = 0';

		$verifier_liste_accompagnateurs = $db->prepare($requette);

		$resultat = $verifier_liste_accompagnateurs->execute([
			'num_res' => $num_res
		]);

		if ($resultat) {
			$liste_accompagnateurs = $verifier_liste_accompagnateurs->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	return $liste_accompagnateurs;
}

/**
 * Cette fonction permet de récupérer la liste des repas de la base de donnée.
 *
 * @return array $liste_repas La liste des chambre.
 */
function recuperer_infos_chambre(): array
{
	$liste_chambre = [];
	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT * FROM chambre WHERE est_actif = 1';

		$verifier_liste_chambre = $db->prepare($requete);

		$resultat = $verifier_liste_chambre->execute();

		if ($resultat) {

			$liste_chambre = $verifier_liste_chambre->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	return $liste_chambre;
}

/**
 * @return bool|array
 */
function recuperer_chambres(): bool|array
{
	$liste_chambre = [];
	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT * FROM chambre';

		$verifier_liste_chambre = $db->prepare($requete);

		$resultat = $verifier_liste_chambre->execute();

		if ($resultat) {

			$liste_chambre = $verifier_liste_chambre->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	return $liste_chambre;
}




/**
 * Cette fonction permet d'enregistrer un type de chambre
 *
 * @param string $type_chambre
 * @param string $details_chambre
 * @param int $details_personne_chambre
 * @param string $details_superficie_chambre
 * @param float $pu
 * @param int $est_actif
 * @return bool
 */
function enregistrer_type_chambre(string $type_chambre, string $details_chambre, int $details_personne_chambre, string $details_superficie_chambre, float $pu, int $est_actif = 1): bool
{
	$enregistrer_type = false;
	$db = connect_db();

	if (is_object($db)) {
		$requette = 'INSERT INTO prix_chambres (type_chambre, details, personnes, superficie, montant, est_actif) VALUES (:type_chambre, :details, :personnes, :superficie, :pu, :est_actif)';

		$inserer_type = $db->prepare($requette);

		$resultat = $inserer_type->execute([
			'type_chambre' => $type_chambre,
			'details' => $details_chambre,
			'personnes' => $details_personne_chambre,
			'superficie' => $details_superficie_chambre,
			'pu' => $pu,
			'est_actif' => $est_actif
		]);

		$enregistrer_type = $resultat;
	}

	return $enregistrer_type;
}



/**
 * Cette fonction permet de récupérer les type de chambre
 * 
 * @return bool|array
 */
function recuperer_type_chambres(): bool|array
{
	$liste_type_chambre = [];
	$db = connect_db();

	if (is_object($db)) {

		$requete = 'SELECT * FROM prix_chambres';

		$verifier_liste_type_chambre = $db->prepare($requete);

		$resultat = $verifier_liste_type_chambre->execute();

		if ($resultat) {

			$liste_type_chambre = $verifier_liste_type_chambre->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	return $liste_type_chambre;
}


/**
 * Cette fonction permet de récupérer les informations d'un type de chambre à partir de son id.
 *
 * @param int $id L'identifiant du type de chambre
 * @return array
 */
function recuperer_type_chambre_par_son_id(int $id): array
{
	$type_chambre = [];

	$db = connect_db();

	$requette = 'SELECT * FROM prix_chambres WHERE id = :id ';

	$verifier_type_chambre = $db->prepare($requette);

	$resultat = $verifier_type_chambre->execute([
		"id" => $id
	]);

	if ($resultat) {

		$type_chambre = $verifier_type_chambre->fetch(PDO::FETCH_ASSOC);
	}

	return $type_chambre;
}


/**
 * Cette fonction permet de supprimer defintivement un type de chambre de la base de données à partir de son numero de chambre.
 *
 * @param int $id L'id du type de chambre.
 * @return bool Indique si la suppression a réussi ou non.
 */
function supprimer_type_chambre(int $id): bool
{
	$type_chambre_est_supprimer = false;

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'DELETE FROM prix_chambres WHERE id = :id';

		$suppression_reussie = $db->prepare($requete);

		$resultat = $suppression_reussie->execute([
			'id' => $id,
		]);

		if ($resultat) {
			$type_chambre_est_supprimer = true;
		}
	}

	return $type_chambre_est_supprimer;
}

/**
 * Cette fonction permet de modifier le type d'une chambre existant dans la base de données via son id.
 *
 * @param int $id L'id du type de chambre
 * @param string $type_chambre Le type  de chambre
 * @param string $details Le details du type  de chambre
 * @param string $personnes Le nombre de personne pour chambre
 * @param string $superficies La superficies du type  de chambre
 * @param int $pu Le prix unitaire  de la chambre
 * @return bool Indique si la modification a réussi ou non.
 */

function modifier_type_chambre(int $id, string $type_chambre, string $details, string $personnes, string $superficies, float $pu): bool
{
	$modifier_type_chambre = false;

	$date = date("Y-m-d H:i:s");

	$db = connect_db();

	if (is_object($db)) {
		$requete = 'UPDATE prix_chambres  SET type_chambre = :type_chambre, details = :details, personnes = :personnes, superficie = :superficie, montant= :montant, maj_le = :maj_le WHERE id = :id';

		$modifier_type_chambre = $db->prepare($requete);

		$resultat = $modifier_type_chambre->execute([
			'id' => $id,
			'type_chambre' => $type_chambre,
			'details' => $details,
			'personnes' => $personnes,
			'superficie' => $superficies,
			'montant' => $pu,
			'maj_le' => $date
		]);

		if ($resultat) {

			$modifier_type_chambre = true;
		}
	}

	return $modifier_type_chambre;
}



function recuperer_nombre_reservations()
{
	$reservation_count = 0;

	$db = connect_db();

	if (is_object($db)) {
		$query = "SELECT count(*) as nbr_reservations FROM reservations";

		$verifier_reservations = $db->prepare($query);

		$resultat = $verifier_reservations->execute();

		if ($resultat) {
			$nbr_reservations = $verifier_reservations->fetch(PDO::FETCH_ASSOC)["nbr_reservations"];
			$reservation_count = $nbr_reservations;
		}
	}

	return $reservation_count;
}


function recuperer_nombre_reservations_encours()
{
	$reservation_count = 0;

	$db = connect_db();

	if (is_object($db)) {
		$query = "SELECT count(*) as nbr_reservations FROM reservations WHERE statut = 'En cours de validation' ";

		$verifier_reservations = $db->prepare($query);

		$resultat = $verifier_reservations->execute();

		if ($resultat) {
			$nbr_reservations = $verifier_reservations->fetch(PDO::FETCH_ASSOC)["nbr_reservations"];
			$reservation_count = $nbr_reservations;
		}
	}

	return $reservation_count;
}

function recuperer_nombre_reservations_active()
{
	$reservation_count = 0;

	$db = connect_db();

	if (is_object($db)) {
		$query = "SELECT count(*) as nbr_reservations FROM reservations WHERE statut = 'valider' ";

		$verifier_reservations = $db->prepare($query);

		$resultat = $verifier_reservations->execute();

		if ($resultat) {
			$nbr_reservations = $verifier_reservations->fetch(PDO::FETCH_ASSOC)["nbr_reservations"];
			$reservation_count = $nbr_reservations;
		}
	}

	return $reservation_count;
}

function recuperer_nombre_reservations_rejeter()
{
	$reservation_count = 0;

	$db = connect_db();

	if (is_object($db)) {
		$query = "SELECT count(*) as nbr_reservations FROM reservations WHERE statut = 'rejeter' ";

		$verifier_reservations = $db->prepare($query);

		$resultat = $verifier_reservations->execute();

		if ($resultat) {
			$nbr_reservations = $verifier_reservations->fetch(PDO::FETCH_ASSOC)["nbr_reservations"];
			$reservation_count = $nbr_reservations;
		}
	}

	return $reservation_count;
}


function recuperer_revenue_total_reservations_valide() {
    $total_revenue = 0.0;

    $db = connect_db();

    $query = "SELECT SUM(prix_total) as total_revenue FROM reservations WHERE statut = 'valide'";

    $verifier_revenue = $db->prepare($query);

    $resultat = $verifier_revenue->execute();

    if ($resultat) {

		$total_revenue = $verifier_revenue->fetch(PDO::FETCH_ASSOC)["total_revenue"];

		if (is_null($total_revenue)) {

			$total_revenue = 0.0;
		}

    }

    return $total_revenue;
}


function recuperer_nombre_commandes()
{
	$commande_count = 0;

	$db = connect_db();

	if (is_object($db)) {
		$query = "SELECT count(*) as nbr_commande FROM commande";

		$verifier_commandes = $db->prepare($query);

		$resultat = $verifier_commandes->execute();

		// Vérifiez si la requête a réussi
		if ($resultat) {
			// Récupérez le nombre de réservations
			$nbr_commande = $verifier_commandes->fetch(PDO::FETCH_ASSOC)["nbr_commande"];
			$commande_count = $nbr_commande;
		}
	}
	// Retournez le nombre de réservations
	return $commande_count;
}
