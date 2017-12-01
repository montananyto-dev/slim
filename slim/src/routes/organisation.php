<?php

$app->get('/view/organisation', function () {

    require_once('dbconnect.php');
    $connection = connect_db();
    $query = "SELECT * FROM organisation";
    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: application/json');
        return json_encode($data);
    }
});

