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


$app->post('/add/project', function ($request, $response) {

    $validation = json_encode('The project has been added to the system');
    $error = json_encode('The project could not be added to the system');

    require_once('dbconnect.php');
    $connection = connect_db();

    $array = $request->getParsedBody();

    $user_id = $array['userId'];

    $team_description = null;

    //prepared statements
    $query1 = "INSERT INTO kingsub3_FYP.team (team_description,team_created_at)VALUES (?,SYSDATE())";
    $stmt = $connection->prepare($query1);
    $stmt->bind_param("s", $team_description);
    $stmt->execute();
    $team_id = mysqli_insert_id($connection);

    $query2 = "INSERT INTO kingsub3_FYP.users_team (user_id,team_id)VALUES (?,?)";

    $stmt2 = $connection->prepare($query2);
    $stmt2->bind_param("ss", $user_id,$team_id);
    $stmt2->execute();

    $project_name = $array['projectName'];
    $project_description = $array['projectDescription'];
    $project_due_date = $array['projectDueDate'];
    $project_duration = $array['projectDuration'];
    $project_creator = $array['projectCreator'];

    $query3 = "INSERT INTO kingsub3_FYP.project(
    team_id,
    project_name,
    project_description,
    project_creator,
    project_due_date,
    project_duration,
    project_created_at)
                VALUES (?,?,?,?,?,?,SYSDATE())";

    $stmt3 = $connection->prepare($query3);
    $stmt3->bind_param("ssssss",
                        $team_id,
                        $project_name,
                        $project_description,
                        $project_creator,
                        $project_due_date,
                        $project_duration);

    $stmt3->execute();


    if ($stmt && $stmt2 && $stmt3){

        return $validation;

    } else {

        return $error;

    }

});


