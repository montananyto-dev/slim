<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app->get('/view/user', function () {

    require_once('dbconnect.php');
    $connection = connect_db();
    $query = "SELECT * FROM `users`";
    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: application/json');
        return json_encode($data);
    }
});

$app->get('/view/user/course/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('There are no users for this course');


    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT * FROM users
              INNER JOIN users_course
              ON users.user_id = users_course.user_id
              INNER JOIN course
              ON users_course.course_id = course.course_id
              WHERE course.course_id = $id";

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

$app->get('/view/user/module/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('There are no users for this module');


    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT * FROM users
              INNER JOIN users_module
              ON users.user_id = users_module.user_id
              INNER JOIN module
              ON users_module.module_id = module.module_id
              where module.module_id = $id";

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

$app->get('/view/user/organisation/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('There are no users for this organisation');

    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT * FROM users WHERE organisation_id = $id";

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

$app->get('/view/user/organisationName/{id}', function (ServerRequestInterface $request,ResponseInterface $response) {

    require_once('dbconnect.php');

    $response = json_encode('There are no organisation name for this organisation');

    $connection = connect_db();
    $id = $request->getAttribute('id');

    $query = "SELECT organisation_name FROM organisation WHERE organisation_id = $id";

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

$app->put('/edit/user',function(ServerRequestInterface $request,ResponseInterface $response){

    require_once('dbconnect.php');
    $connection = connect_db();

    $validation = json_encode('The user has been updated');
    $error = json_encode('The user could not be update');

    $user_id = $request->getParsedBody()['userIdForm'];
    $user_first_name = $request->getParsedBody()['userFirstNameForm'];
    $user_last_name = $request->getParsedBody()['userLastNameForm'];
    $user_phone_number = $request->getParsedBody()['userPhoneNumberForm'];
    $user_Email = $request->getParsedBody()['userEmailForm'];
    $user_department = $request->getParsedBody()['userDepartmentForm'];

    $user_id = array_shift( $user_id);
    $user_first_name = array_shift( $user_first_name);
    $user_last_name = array_shift( $user_last_name);
    $user_phone_number = array_shift( $user_phone_number);
    $user_Email = array_shift( $user_Email);
    $user_department = array_shift( $user_department);

    $query = "UPDATE  kingsub3_FYP.users SET
    user_first_name = ?,
    user_last_name = ?,
    user_email = ?,
    user_phone_number = ?,
    user_department = ?
    WHERE user_id = $user_id";



    $stmt = $connection->prepare($query);

    $stmt->bind_param("sssss",
        $user_first_name,
        $user_last_name,
        $user_Email,
        $user_phone_number,
        $user_department);

    $stmt->execute();

    if($stmt){

       return $validation;

    }else{

        return $error;
    }

});

$app->post('/add/user', function ($request, $response) {

    require_once('dbconnect.php');
    $connection = connect_db();

    $validation = json_encode('The user has been added to the system');
    $error = json_encode('The user could not be added to the system');

    $array = $request->getParsedBody();

    $user_type = $array['userType'];


    //prepared statements
    $query = "INSERT INTO kingsub3_FYP.users (

    organisation_id,
    user_type_id,
    user_first_name,
    user_last_name,
    user_password,
    user_email,
    user_phone_number,
    user_department,
    user_date_of_birth,
    user_created_at)
    
      VALUES (?,?,?,?,?,?,?,?,?,SYSDATE())";

    $organisation_id = $array['organisation'];
    $user_type_id = $array['userType'];
    $user_first_name = $array['firstName'];
    $user_last_name = $array['lastName'];
    $user_password = $array['password']['passwordInput'];
    $user_date_of_birth = $array['dateOfBirth'];
    $user_email = $array['email'];
    $user_phone_number = $array['phoneNumber'];
    $user_department = $array['department'];

    $stmt = $connection->prepare($query);

    $stmt->bind_param("sssssssss",
        $organisation_id,
        $user_type_id,
        $user_first_name,
        $user_last_name,
        $user_password,
        $user_email,
        $user_phone_number,
        $user_department,
        $user_date_of_birth);

    $stmt->execute();

    if ($user_type != 3) {

        $module_id_temp = $array['courseModule']['module'];
        $course_id_temp = $array['courseModule']['course'];
        $user_id = mysqli_insert_id($connection);

        foreach ($course_id_temp as $value) {

            $course_id = $value;
            $query2 = "INSERT INTO kingsub3_FYP.users_course (user_id,course_id) VALUES (?,?)";
            $stmt2 = $connection->prepare($query2);
            $stmt2->bind_param("ss", $user_id, $course_id);
            $stmt2->execute();

        }

        foreach ($module_id_temp as $value) {

            $module_id = $value;
            $query3 = "INSERT INTO kingsub3_FYP.users_module (user_id,module_id) VALUES (?,?)";
            $stmt3 = $connection->prepare($query3);
            $stmt3->bind_param("ss", $user_id, $module_id);
            $stmt3->execute();
        }
    }

    if ($stmt || ($stmt2 && $stmt3)) {

        return $validation;

    } else {

        return $error;

    }

});




//
//$app->get('/view/user', function () {
//
//    require_once('dbconnect.php');
//    $connection = connect_db();
//    $query = $connection->prepare("SELECT * FROM users");
//    $query->execute();
//    $result = $query->fetchAll(\PDO::FETCH_ASSOC);
//
//
//    if (isset($result)) {
//        header('Content-Type: application/json');
//        return json_encode($result);
//    }
//});
//