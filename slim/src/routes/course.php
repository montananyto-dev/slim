<?php


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/view/course', function () {

    require_once('dbconnect.php');
    $connection = connect_db();
    $query = "SELECT * FROM course";
    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: application/json');
        return json_encode($data);
    }
});

$app->get('/view/courseByOrganisationId/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');
    $connection = connect_db();
    $error = json_encode('There are no courses for this organisation');

    $id = $request->getAttribute('id');

    $query = "SELECT * FROM course where organisation_id = $id";

    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: application/json');
        return json_encode($data);
    }else{
        return json_encode($error);
    }

});

$app->post('/add/course', function ($request, $response) {

    require_once('dbconnect.php');
    $connection = connect_db();

    $validation = json_encode('The course has been added to the system');
    $error = json_encode('The course could not be added to the system');

    $query = "INSERT INTO kingsub3_FYP.course (organisation_id,course_name,course_description,course_year) VALUES (?,?,?,?)";
    $organisation_id = $request->getParsedBody()['organisationId'];
    $course_name = $request->getParsedBody()['courseName'];
    $course_description = $request->getParsedBody()['courseDescription'];
    $course_year = $request->getParsedBody()['courseYear'];

    $stmt = $connection->prepare($query);
    $stmt->bind_param("ssss",$organisation_id, $course_name, $course_description, $course_year);
    $stmt->execute();

    if ($stmt) {
        return $validation;
    } else {
        return $error;
    };

});
