<?php
session_start();
require 'vendor/autoload.php';

require_once 'infrastructure/db/dbConnectionCreator.php';
require_once 'view/viewBuilder.php';
require_once 'domain/User.php';
if(empty($_GET['page_name'])){
    throw new Exception("corrupted link!");
}
global $db;
$user = new User($db);
buildPage(($user->isLogged()? $_GET['page_name'] : "login.php"));
?>