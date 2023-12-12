<?php
session_start();

include './app/commum/fonction.php';

// Extraction des paramètres de l'URL
$params = explode('/', $_GET['p']);

// Définition des valeurs par défaut
$profile = "administrateur";
$default_ressource = "connexion";
$default_action = "index";
$default_action_folder = "app/" . $profile . "/" . $default_ressource . "/" . $default_action . ".php";

// Vérifier si des paramètres sont présents dans l'URL
if (isset($_GET['p']) && !empty($_GET['p'])) {
    // Récupération de la ressource à partir des paramètres, sinon utiliser la valeur par défaut
    $ressource = (isset($params[1]) && !empty($params[1])) ? $params[1] : $default_ressource;
    
    // Récupération de l'action à partir des paramètres, sinon utiliser la valeur par défaut
    $action = (isset($params[2]) && !empty($params[2])) ? $params[2] : $default_action;
    
    // Construction du chemin vers le fichier d'action
    $action_folder = "app/" . $profile . "/" . $ressource . "/" . $action . ".php";
    
    // Vérifier si le fichier d'action existe, sinon utiliser le fichier d'action par défaut
    if (file_exists($action_folder)) {
        require_once $action_folder;
    } else {
        require_once $default_action_folder;
    }
} else {
    // Si aucun paramètre n'est présent dans l'URL, utiliser le fichier d'action par défaut
    require_once $default_action_folder;
}
