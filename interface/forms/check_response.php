<?php
global $db;

require_once "interface/details/requiredParametersUtils.php";
list($login, $password, $status, $deviceName) = assertAndObtainRequiredParameters($_GET, "l", "p","s", "d");

require_once 'domain/User.php';
require_once 'domain/DeviceResponses.php';
$user = new User($db);
$userData = $user->login($login, md5($password));

$deviceResponses = new DeviceResponses($db);
$deviceResponses->addResponse($userData["id"], $deviceName, $status);