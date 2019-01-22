<?php

global $db;
require_once "interface/details/requiredParametersUtils.php";
list($deviceId, $functionName) = assertAndObtainRequiredParameters($_POST, "deviceId", "functionName");

require_once 'domain/User.php';
require_once 'domain/Devices.php';
$user = new User($db);
$devices = new Devices($db);

$devices->addNewFunctionRequest($user->getId(), $deviceId, $functionName);
