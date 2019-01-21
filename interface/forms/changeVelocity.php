<?php
require_once 'domain/User.php';
global $db;

require_once "interface/details/requiredParametersUtils.php";
list($velocity) = assertAndObtainRequiredParameters($_POST, "velocity");

$user->changeVelocity($velocity);
