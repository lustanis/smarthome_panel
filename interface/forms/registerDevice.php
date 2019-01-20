<?php
global $db;

require_once "interface/details/requiredParametersUtils.php";
list($main_server_id, $device_id, $services) = assertAndObtainRequiredParameters($_GET, "main", "device", "services");

require_once 'domain/Devices.php';
$devices = new Devices($db);

$devices->registerDevice($main_server_id, $device_id, ...$services);
echo "ok";
