<?php
global $db;

require_once "interface/details/requiredParametersUtils.php";

list($subscription) = assertAndObtainRequiredParameters($_GET, "q");
require_once "domain/Cesspool.php";

$user = new User($db);
$cesspool = new Cesspool($db, $user->getId());
$cesspool->savePushRegistrationId(substr($subscription , strripos($subscription, '/') + 1));