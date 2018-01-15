<?php

//view users

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


//add a user to the system

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

    if ($stmt && $stmt2 && $stmt3) {

        return $validation;

    } else {

        return $error;

    }

});