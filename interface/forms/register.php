<?php
require_once 'domain/User.php';
global $db;
$user= new User($db);
$redirection = "register.php";
$user->register($_POST['login'], $_POST["password1"]);
$redirection = "login.php";
$_SESSION['message_ok'] = "rejestracja OK. zaloguj sie teraz";


