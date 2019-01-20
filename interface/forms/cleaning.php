<?php
require_once "domain/Cesspool.php";
require_once "domain/User.php";

global $db;
$user = new User($db);

$date = $_POST["current_date"];
if (isset($date)) {
    $cesspool = new Cesspool($db, $user->getId());
    $cesspool->empty($date);
}
else{
    throw new Exception("no valid date");
}