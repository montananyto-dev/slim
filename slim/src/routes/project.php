<?php


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


$app->get('/view/project/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('No project for this user');


    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT project.* FROM project
              INNER JOIN team
              ON project.team_id = team.team_id
              INNER JOIN users_team
              ON team.team_id = users_team.team_id
              INNER JOIN users
              ON users_team.user_id = users.user_id
              WHERE users.user_id = $id";

    $result = $connection->query($query);
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: application/json');
        return json_encode($data);
    } else {

        return $response;
    }


});
