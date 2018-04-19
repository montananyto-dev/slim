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

$app->get('/view/allTasks/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');
    $response = json_encode('No tasks for this project');

    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT task.* FROM task
              INNER JOIN project
              ON project.project_id = task.project_id
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

$app->get('/view/taskByStatus/{id}/{id2}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');
    $response = json_encode('No tasks for this project');

    $connection = connect_db();
    $project_id = $request->getAttribute('id');
    $task_status = $request->getAttribute('id2');

    $query = "SELECT task.* FROM task
              INNER JOIN project
              ON project.project_id = task.project_id
              WHERE project.project_id = $project_id AND task.task_status = $task_status";

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

$app->get('/view/taskByProjectAndTaskId/{id}/{id2}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');
    $response = json_encode('No tasks for this project');

    $connection = connect_db();
    $project_id = $request->getAttribute('id');
    $task_id = $request->getAttribute('id2');

    $query = "SELECT task.* FROM task
              INNER JOIN project
              ON project.project_id = task.project_id
              WHERE project.project_id = $project_id AND task.task_id = $task_id";

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

$app->put('/update/task', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');
    $connection = connect_db();

    $response = json_encode('The task could not be updated');
    $validation = json_encode('The task has been updated');

    $array = $request->getParsedBody();
    $task_status = $array['taskStatus'];
    $projectId = $array['projectId'];
    $taskId = $array['taskId'];

    $query = "UPDATE  kingsub3_FYP.task SET
    task_status = ?,
    task_updated_at = SYSDATE()

    WHERE project_id = $projectId AND task_id = $taskId";

    $stmt = $connection->prepare($query);

    $stmt->bind_param("s", $task_status);

    $stmt->execute();

    if ($stmt){
        return $validation;
    } else {
        return $response;
    }
});

$app->get('/view/task/comment/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('No comments for this task');


    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT task_comment.* FROM task_comment
              INNER JOIN task t on task_comment.task_id = t.task_id
              WHERE t.task_id = $id";

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

$app->get('/view/teamMembers/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');
    $response = json_encode('No team members for this project');

    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT users.* FROM users
              INNER JOIN users_team u 
              on users.user_id = u.user_id
              INNER JOIN team t 
              on u.team_id = t.team_id
              INNER JOIN project p 
              on t.team_id = p.team_id
              WHERE p.project_id = $id";

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

$app->get('/view/comment/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');
    $response = json_encode('No comments for this project');

    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT project_comment.* FROM project_comment
              INNER JOIN project
              ON project.project_id = project_comment.project_id
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

$app->get('/view/task/{id}/{id2}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');
    $response = json_encode('No tasks for this project');

    $connection = connect_db();
    $project_id = $request->getAttribute('id');
    $task_status = $request->getAttribute('id2');

    $query = "SELECT task.* FROM task
              INNER JOIN project
              ON project.project_id = task.project_id
              WHERE project.project_id = $project_id AND task.task_status = $task_status";

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

$app->post('/add/comment', function ($request, $response) {

    $validation = json_encode('The comment has been added to the task');
    $error = json_encode('The comment could not be added to the task');

    require_once('dbconnect.php');
    $connection = connect_db();

    $array = $request->getParsedBody();

    $task_comment_description = $array['description'];
    $task_id = $array['taskIdForm'];
    $task_comment_creator = $array['creator'];

    $query = "INSERT INTO kingsub3_FYP.task_comment (
              task_comment.task_id,
              task_comment.task_comment_description,
              task_comment.task_comment_creator,
              task_comment.task_comment_created_at)
              
               VALUES (?,?,?,SYSDATE())";

    $stmt = $connection->prepare($query);
    $stmt->bind_param("sss",$task_id, $task_comment_description,$task_comment_creator);
    $stmt->execute();
    $task_comment_id = mysqli_insert_id($connection);


    if ($stmt){

        return $validation;

    } else {

        return $error;

    }

});