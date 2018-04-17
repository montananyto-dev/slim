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

$app->get('/view/project/projectID/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('No project for this user');


    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT * FROM project
             
              WHERE project.project_id = $id";

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

$app->get('/view/goal/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('No goal for this project');


    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT goal.* FROM goal
              INNER JOIN project
              ON project.project_id = goal.project_id
              WHERE project.project_id = $id";

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

$app->get('/view/objective/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('No objectives for this project');


    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT objective.* FROM objective
              INNER JOIN project
              ON project.project_id = objective.project_id
              WHERE project.project_id = $id";

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

$app->get('/view/workflowStep/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('No workflow steps for this project');


    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT workflow_step.* FROM workflow_step
              INNER JOIN project
              ON project.project_id = workflow_step.project_id
              WHERE project.project_id = $id";

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