<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';


$settings = ['settings'=> ['displayErrorDetails'=>true,],];
$app = new \Slim\App($settings);

require_once('../routes/login.php');
require_once('../routes/insertUser.php');

$app->get('/hello/you/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;

});



$app->run();