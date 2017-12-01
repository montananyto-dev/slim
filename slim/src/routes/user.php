<?php

//view users
$app->get('/view/user',function(){

    require_once('dbconnect.php');

    $connection = connect_db();


    $query = "SELECT  
                users.user_first_name first_name,
                users.user_last_name last_name,
                users.user_password password,
                users.user_email email,
                users.user_phone_number phone_number,
                course.course_name course ,
                users.user_departement departement,
                users.user_about_me about_me
                FROM users
                inner join users_course
                on users.user_id = users_course.user_id
                inner join course
                on users_course.course_id = course.course_id
                inner join module_course
                on course.course_id = module_course.course_id
                inner join module
                on module_course.module_id = module.module_id
                group by users.user_id";

    $result = $connection->query($query);

    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    if (isset($data)){
        header('Content-Type: application/json');
        return json_encode($data);
    }
});

//insert a user
$app->post('/add/user',function($request,$response){

    require_once('dbconnect.php');
    $connection = connect_db();

    //prepared statements
    $query = "INSERT INTO `kingsub3_tony`.`tonyoo` (`username`, `name`, `password`) VALUES (?,?,?)";

    $stmt = $connection->prepare($query);
    $stmt->bind_param("sss", $username, $name, $password);
    $username = $request->getParsedBody()['username'];
    $name = $request->getParsedBody()['name'];
    $password = $request->getParsedBody()['password'];
    $stmt->execute();

    echo($username);
    echo($password);
    echo($name);

    echo "inserted";

});