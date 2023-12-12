<?php
require "vendor/autoload.php";

// PROJET VAR
define('PATH_PROJECT', '/gestion-hotel/');

// DATABASE ACCES
define('DATABASE_HOST', 'localhost');
define('DATABASE_NAME', 'gestion_hotel');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', '');

// MAIL ACCES
define('MAIL_ADDRESS', 'slescocotiers@gmail.com');
define('MAIL_PASSWORD', 'wmiytltpsxnihyvr');

$default_profile = "client";
$default_profile_folder = "app/client/index.php";
$params = [];

if (isset($_GET['p']) && !empty($_GET['p'])) {
    $params = explode('/', $_GET['p']);
    $profile = (isset($params[0]) && !empty($params[0])) ? $params[0] : $default_profile;
    $profile_folder = "app/" . $profile . "/index.php";
    if (file_exists($profile_folder)) {
        include $profile_folder;
    } else {
        include $default_profile_folder;
    }
} else {
    include $default_profile_folder;
}
