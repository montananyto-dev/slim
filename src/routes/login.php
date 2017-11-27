<?php

$app->get('/home/users',function(){

require_once('dbconnect.php');

$connection = connect_db();

$query = "SELECT * FROM `users`";
$result = $connection->query($query);

while($row = $result->fetch_assoc()){
  $data[] = $row;
}
if (isset($data)){
  header('Content-Type: application/json');
  echo json_encode($data);
}
});

