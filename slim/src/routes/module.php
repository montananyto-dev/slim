<?php


//return all the modules
$app->get('/view/module', function () {

    require_once('dbconnect.php');

    $connection = connect_db();

    $query = "SELECT * FROM module";

    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {

        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: application/json');
        return json_encode($data);
    }
});

$app->get('/return/specific/{id}', function ($request) {

    $id = $request->getAttribute('id');
    require_once('dbconnect.php');

    $connection = connect_db();

    $query = "SELECT module.* FROM module
              INNER JOIN module_course
              ON module.module_id = module_course.module_id
              INNER JOIN course
              ON module_course.course_id = course.course_id
              WHERE course.course_id = $id";

    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {

        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: application/json');
        return json_encode($data);
    }
});