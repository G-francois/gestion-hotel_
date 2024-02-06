<?php
session_start();
include './app/commum/fonction.php';

$params = explode('/', $_GET['p']);
$profile = "client";
$default_ressource = "acceuil";
$default_action = "index";
$default_action_folder = "app/" . $profile . "/" . $default_ressource . "/" . $default_action . ".php";

if (isset($_GET['p']) && !empty($_GET['p'])) {
    $ressource = (isset($params[1]) && !empty($params[1])) ? $params[1] : $default_ressource;
    $action = (isset($params[2]) && !empty($params[2])) ? $params[2] : $default_action;
    $action_folder = "app/" . $profile . "/" . $ressource . "/" . $action . ".php";
    if (file_exists($action_folder)) {
        require_once $action_folder;
    } else {
        require_once $default_action_folder;
    }
} else {
    require_once $default_action_folder;
}
