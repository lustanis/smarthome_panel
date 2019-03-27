<?php
global $db;

require_once "interface/details/requiredParametersUtils.php";

list($mainServerId, $devicesId, $value, $reportId) =
    assertAndObtainRequiredParameters($_GET, "main", "device", "value", "report_id");
require_once "domain/WaterCounter.php";
require_once "domain/Devices.php";

$devices = new Devices($db);
$counter = new WaterCounter($db, $devices->getUserIdByMainServerId($mainServerId, $devicesId));
$counter->addCounting($devicesId, $value, date("y-m-d") . "_" . $reportId);
echo "OK";
