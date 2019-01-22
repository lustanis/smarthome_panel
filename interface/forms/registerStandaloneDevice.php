<?php
global $db;
require_once "interface/details/requiredParametersUtils.php";

list($login, $password, $type, $functions) = assertAndObtainRequiredParameters($_GET, "login", "password", "type", "functions");

require_once 'domain/User.php';
$user = new User($db);
$userData = $user->login($login, md5($password));

require_once 'domain/Devices.php';
$devices = new Devices($db);

$newDeviceName = $devices->registerStandaloneDevice($userData["id"], $type, $functions);
echo "name=$newDeviceName&id=".$userData["id"];