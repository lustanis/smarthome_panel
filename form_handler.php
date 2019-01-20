<?php
$formsWithoutRedirection = ["waterCounting.php", "getFreeSpace.php", "registerIp.php", "registerDevice.php",
    "dailyCron_checkEmptySpace.php"];
$doesNotRequireRedirection = in_array($_GET["form_name"], $formsWithoutRedirection);
if (!$doesNotRequireRedirection) {
    session_start();
}
try {
    if (empty($_GET['form_name'])) {
        throw new Exception("corrupted link!");
    }
    require 'vendor/autoload.php';
    require_once 'infrastructure/db/dbConnectionCreator.php';
    require_once 'domain/User.php';
    global $db;

    $user = new User($db);
    $doesNotRequireToBeLogged = in_array($_GET['form_name'], ["login.php", "register.php"]) || $doesNotRequireRedirection;
    if (!$user->isLogged() && !$doesNotRequireToBeLogged) {
        require_once "interface/forms/login.php";
    } else {
        require_once "interface/forms/" . $_GET['form_name'];
    }
} catch (Exception $e) {
    if ($doesNotRequireRedirection) {
        echo "FATAL EXCEPTION: " . $e->getMessage();
        exit(0);
    } else {
        $_SESSION["message_error"] = $e->getMessage();
    }
}
if (!$doesNotRequireRedirection) {
    if ($user->isLogged()) {
        if (isset($redirection)) {
            header("Location: ../" . $redirection);
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    } else {
        header("Location: ../login.php");
    }
}