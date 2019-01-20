<?php
require_once 'domain/User.php';
global $db;
if (isset($_POST['velocity'])) {
    $user = new User($db);

    $user->changeVelocity($_POST['velocity']);
}
