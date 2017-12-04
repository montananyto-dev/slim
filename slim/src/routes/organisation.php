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

        $response = "The organisation: " . $organisation_name . " has been added to the database";
        return $response;
    }else{
        echo'error';
    }

});
