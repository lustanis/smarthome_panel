<?php
session_start();
try {
    if (empty($_GET['form_name'])) {
        throw new Exception("corrupted link!");
    }
    require 'vendor/autoload.php';
    require_once 'infrastructure/db/dbConnectionCreator.php';
    require_once 'domain/User.php';
    global $db;

    $user = new User($db);

    if (!$user->isLogged()) {
        throw new RuntimeException("user not logged");
    }
    require_once "interface/logged_forms/" . $_GET['form_name'];

} catch (Exception $e) {
   echo $e->getMessage();
}