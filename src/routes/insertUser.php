<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/home/add/users',function($request){

    echo 'test';

    require_once('dbconnect.php');
    //prepared statements
    $query = "INSERT INTO `kingsub3_tony`.`tonyoo` (`username`, `name`, `password`) 
    VALUES (?,?,?)";
    
    
    $stmt = $mysqli->prepare($query);
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


?>
