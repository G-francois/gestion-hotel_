<?php
$id_utilisateur  = $params[3];
$token  = $params[4];
if (check_token_exist($id_utilisateur, $token, "VALIDATION_COMPTE")){

	if(suppression_logique_token($id_utilisateur) && activation_compte_utilisateur($id_utilisateur)){
        $_SESSION['validation-compte-message-success'] = "Votre compte est a présent validé. Vous pouvez vous connecter";
    }else{
		$_SESSION['validation-compte-message-erreur'] = "Oups!!! Une erreur s'est produite lors de la validation du compte. Veuillez contactez un administrateur";
	}

}else{
	$_SESSION['validation-compte-message-erreur'] = "Oups!!! la clé d'activation de compte est introuvable. Veuillez contactez un administrateur";
}

header('location: ' . PATH_PROJECT . 'client/connexion/index');
