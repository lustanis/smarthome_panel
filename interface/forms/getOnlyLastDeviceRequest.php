<?php
global $db;

require_once "interface/details/requiredParametersUtils.php";
list($login, $password, $deviceName) = assertAndObtainRequiredParameters($_GET, "login", "password", "deviceName");

require_once 'domain/User.php';
require_once 'domain/DeviceRequests.php';
$user = new User($db);
$userData = $user->login($login, md5($password));

$deviceRequests = new DeviceRequests($db);
echo $deviceRequests->getLastOneAndRemoveAll($user["id"], $deviceName);
