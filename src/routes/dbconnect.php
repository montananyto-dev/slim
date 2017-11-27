<?php

//live connection
function connect_db() {
    $server = '108.179.213.60'; // this may be an ip address instead
    $user = 'kingsub3_tony';
    $pass = 'Kingston2017!';
    $database = 'kingsub3_FYP';
    $port = 3306;
    $connection = new mysqli($server, $user, $pass, $database,$port);

    return $connection;
}

//remember to add your ip on bluehost under
//Remote Mysql Database Access
//Add an Access Host