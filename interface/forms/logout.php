<?php
require_once 'domain/User.php';
global $db;
$user = new User($db);
$redirection = "home.php";
$user->logout();

