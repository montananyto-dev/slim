<?php

$app->get('/view/usertype', function () {

    require_once('dbconnect.php');
    $connection = connect_db();
    $query = "SELECT * FROM user_type";
    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: application/json');
        return json_encode($data);
    }
});