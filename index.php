
<?php
require "vendor/autoload.php";

// PROJET VAR
const PATH_PROJECT = '/gestion-hotel/';

// DATABASE ACCESS
const DATABASE_HOST = 'localhost';
const DATABASE_NAME = 'gestion_hotel';
const DATABASE_USERNAME = 'root';
const DATABASE_PASSWORD = '';

// MAIL ACCESS
const MAIL_ADDRESS = 'slescocotiers@gmail.com';
const MAIL_PASSWORD = 'wmiytltpsxnihyvr';

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
