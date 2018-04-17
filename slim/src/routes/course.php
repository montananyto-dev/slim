<?php

$app->get('/view/course',function(){

    require_once('dbconnect.php');

    $connection = connect_db();

    $query = "SELECT * FROM course";

    $result = $connection->query($query);

    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    if (isset($data)){
        header('Content-Type: application/json');
        return json_encode($data);
    }

});

$app->post('/add/course',function($request,$response) {

    require_once('dbconnect.php');
    $connection = connect_db();

    $validation = json_encode('The course has been added to the system');
    $error = json_encode('The course could not be added to the system');


    //prepared statements
    $query = "INSERT INTO kingsub3_FYP.course (

    course_name,
    course_description,
    course_created_at)
    
      VALUES (?,?,SYSDATE())";

    $course_name = $request->getParsedBody()['courseName'];
    $course_description = $request->getParsedBody()['courseDescription'];


    $stmt = $connection->prepare($query);

    $stmt->bind_param("ss",

        $course_name,
        $course_description
        );

    $stmt->execute();


    if ($stmt) {

        return $validation;

    } else {

        return $error;


    };

});
