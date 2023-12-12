<?php
$_SESSION['data'] = [];

if (!empty($_POST['type_chambre'])) {
    $_SESSION['data']['type_chambre'] = $_POST['type_chambre'];
}

header('location: ' . PATH_PROJECT . 'client/chambres');
