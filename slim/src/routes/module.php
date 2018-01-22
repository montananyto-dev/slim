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

$app->get('/return/specific[/{id:.*}]', function ($request, $response, $args) {

    $id = explode('/', $request->getAttribute('id'));

    $ids = implode(',',$id);


        require_once('dbconnect.php');

        $connection = connect_db();

        $query = "SELECT module.* FROM module
              INNER JOIN module_course
              ON module.module_id = module_course.module_id
              INNER JOIN course
              ON module_course.course_id = course.course_id
              WHERE course.course_id IN ($ids)";

        $result = $connection->query($query);

        while ($row = $result->fetch_assoc()) {

            $data[] = $row;
        }
        if (isset($data)) {
            header('Content-Type: application/json');
            return json_encode($data);
        }else{

            header('Content-Type: application/json');
            $response = 'This course do not have any module';
            return $obj = json_encode($response);

    }


});




$app->post('/add/module',function($request,$response) {

    require_once('dbconnect.php');
    $connection = connect_db();

    $validation = json_encode('The module has been added to the system');
    $error = json_encode('The module could not be added to the system');


    //prepared statements
    $query = "INSERT INTO kingsub3_FYP.module (

    module_name,
    module_year,
    module_description,
    module_created_at)
    
      VALUES (?,?,?,SYSDATE())";

    $module_name = $request->getParsedBody()['moduleName'];
    $module_year = $request->getParsedBody()['moduleYear'];
    $module_description = $request->getParsedBody()['moduleDescription'];

    $stmt = $connection->prepare($query);

    $stmt->bind_param("sss",

        $module_name,
        $module_year,
        $module_description);

    $stmt->execute();


    if ($stmt) {

        return $validation;

    } else {

        return $error;


    };

});