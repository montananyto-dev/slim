<?php

$app->post('/home/add/users',function($request,$response){

    require_once('dbconnect.php');
    $connection = connect_db();

    //prepared statements
    $query = "INSERT INTO `kingsub3_tony`.`tonyoo` (`username`, `name`, `password`) VALUES (?,?,?)";
    
    $stmt = $connection->prepare($query);
    $stmt->bind_param("sss", $username, $name, $password);
    $username = $request->getParsedBody()['username'];
    $name = $request->getParsedBody()['name'];
    $password = $request->getParsedBody()['password'];
    $stmt->execute();

    echo($username);
    echo($password);
    echo($name);

    echo "inserted";

});

