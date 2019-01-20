<?php
require_once 'domain/User.php';
global $db;
$user = new User($db);

$redirection = "login.php";
$user->login($_POST['login'], md5($_POST['password']));

if($user->isLogged()){
    $redirection = "home.php";
}
        


