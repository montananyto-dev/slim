<?php

$app->get('/view/organisation', function () {

    require_once('dbconnect.php');
    $connection = connect_db();
    $query = "SELECT * FROM organisation";
    $result = $connection->query($query);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: application/json');
        return json_encode($data);
    }
});

$app->post('/add/organisation',function($request, $response)  {

    require_once('dbconnect.php');
    $connection = connect_db();
    $validation = json_encode('The organisation has been added to the system');
    $error = json_encode('The organisation could not be added to the system');

    //prepared statements
    $query = "INSERT INTO kingsub3_FYP.organisation
  (
   organisation_name, 
   organisation_address,
   organisation_type,
   organisation_phone_number,
   organisation_country,
   organisation_created_at) VALUES (?,?,?,?,?,SYSDATE())";

    $organisation_name = $request-> getParsedBody()['organisation_name'];
    $organisation_address = $request-> getParsedBody()['organisation_address'];
    $organisation_type = $request-> getParsedBody()['organisation_type'];
    $organisation_phone_number = $request->getParsedBody()['organisation_phone_number'];
    $organisation_country = $request->getParsedBody()['organisation_country'];

    $stmt = $connection->prepare($query);
    $stmt->bind_param("sssss",
        $organisation_name,
        $organisation_address,
        $organisation_type,
        $organisation_phone_number,
        $organisation_country);

    $stmt->execute();

    if($stmt) {

        return $validation;

    }else{
        return $error;
    }

});
