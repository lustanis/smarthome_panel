<?php
global $db;

require_once "interface/details/requiredParametersUtils.php";

list($userId) = assertAndObtainRequiredParameters($_POST, "user_id");
require_once 'domain/WaterCounter.php';
$waterCounter = new WaterCounter($db, $userId);

header('Content-Type: application/json');
echo '{"space_amount": ' . $waterCounter->getFreeSpace($userId) . "}";
