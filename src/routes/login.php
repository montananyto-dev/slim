<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/home/users',function(){

require_once('dbconnect.php');

$query = "SELECT * FROM tonyoo";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()){
  $data[] = $row;
}
if (isset($data)){
  header('Content-Type: application/json');
  echo json_encode($data);
}
});

?>