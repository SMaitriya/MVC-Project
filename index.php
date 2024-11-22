<?php
session_start();
require_once('./Model/Connection.class.php');
$pdoBuilder = new Connection();
$db = $pdoBuilder->getDb();

if (
    isset($_GET['ctrl']) && !empty($_GET['ctrl']) &&
    isset($_GET['action']) && !empty($_GET['action'])
) {
    $ctrl = $_GET['ctrl'];
    $action = $_GET['action'];
} else {
    $ctrl = 'user';  // On appelle le contrôleur user par défaut
    $action = 'home';  // On utilise l'action home par défaut
}

require_once('./Controller/' . $ctrl . 'Controller.php');
$ctrl = $ctrl . 'Controller';
$controller = new $ctrl($db);
$controller->$action();

?>