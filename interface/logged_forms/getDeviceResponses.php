<?php

global $db;
require_once "interface/details/requiredParametersUtils.php";
list($deviceId) = assertAndObtainRequiredParameters($_POST, "deviceId");

require_once 'domain/User.php';
require_once 'domain/DeviceResponses.php';
$user = new User($db);
$deviceResponses = new DeviceResponses($db);

echo json_encode($deviceResponses->getDeviceResponses($user->getId(), $deviceId));