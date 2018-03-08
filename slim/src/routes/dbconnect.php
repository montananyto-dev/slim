<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//live connection
//function connect_db() {
//    $server = '108.179.213.60'; // this may be an ip address instead
//    $user = 'kingsub3_tony';
//    $pass = 'Kingston2017!';
//    $database = 'kingsub3_FYP';
//    $port = 3306;
//    $connection = new mysqli($server, $user, $pass, $database,$port);
//
//    return $connection;
//}

//remember to add your ip on bluehost under
//Remote Mysql Database Access
//Add an Access Host


//connect locally
//function connect_db (){
//    $server = 'localhost'; // this may be an ip address instead
//    $user = 'root';
//    $pass = '';
//    $database = 'kingsub3_fyp';
//    $connection = new mysqli($server, $user, $pass, $database);
//
//    return $connection;
//}

//connect live DB

try {
    $connection = new PDO('mysql:108.179.213.60;port=3306;dbname=kingsub3_FYP', 'kingsub3_tony', 'Kingston2017!');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo 'Connection success';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
//
//function connect_db() {
//    $server = '108.179.213.60'; // this may be an ip address instead
//    $user = 'kingsub3_tony';
//    $pass = 'Kingston2017!';
//    $database = 'kingsub3_FYP';
//    $connection = new mysqli($server, $user, $pass, $database);
//
//    return $connection;
//}