<?php
global $db;

require_once "interface/details/requiredParametersUtils.php";
list($ip) = assertAndObtainRequiredParameters($_GET, "ip");

$db->insert("info", ["desc" => "new ip: " . str_replace("I", ".", $ip)]);
echo "ok";