<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 29/11/2017
 * Time: 21:43
 */


$app->get('/view/users',function(){

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
        echo json_encode($data);
    }
});