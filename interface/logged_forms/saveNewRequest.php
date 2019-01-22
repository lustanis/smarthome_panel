<?php

global $db;
require_once "interface/details/requiredParametersUtils.php";
list($deviceId, $functionName) = assertAndObtainRequiredParameters($_POST, "deviceId", "functionName");

require_once 'domain/User.php';
require_once 'domain/DeviceRequests.php';
$user = new User($db);
$request = new DeviceRequests($db);

$request->addNewFunctionRequest($user->getId(), $deviceId, $functionName);
