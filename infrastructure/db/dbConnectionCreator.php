<?php

use Medoo\Medoo;

$db = new Medoo([
    // required
    'database_type' => 'mysql',
    'database_name' => '28482622_cesspool',
    'server' => 'localhost',
    'username' => '28482622_cesspool',
    'password' => 'FU3y7TVd6',

    // [optional]
    'charset' => 'utf8',
//    'port' => 3306,

    // [optional] Table prefix
//    'prefix' => 'PREFIX_',

    // [optional] Enable logging (Logging is disabled by default for better performance)
//    'logging' => true,

    // [optional] MySQL socket (shouldn't be used with server and port)
//    'socket' => '/tmp/mysql.sock',

    // [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
//    'option' => [
//        PDO::ATTR_CASE => PDO::CASE_NATURAL
//    ],

    // [optional] Medoo will execute those commands after connected to the database for initialization
//    'command' => [
//        'SET SQL_MODE=ANSI_QUOTES'
//    ]
]);




