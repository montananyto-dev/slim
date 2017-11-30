<?php

$app->get('view/organisation', function () {

    require_once('dbconnect.php');
    $connection = connect_db();
    $query = "SELECT * FROM ORGANISATION";
    $result = $connection->query($query);

    while ($row = $result->fetch_assoc($result)) {

        $data[] = $row;

        if (isset($data)) {
            header('Content-Type: application/json');
            echo json_encode($data);
        }

    }

});