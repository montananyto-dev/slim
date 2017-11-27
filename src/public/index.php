<?php

header('Access-Control-Allow-Origin: *');  

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';


$settings = ['settings'=> ['displayErrorDetails'=>true,],];
$app = new \Slim\App($settings);

require_once('../routes/login.php');
require_once('../routes/myname.php');
require_once('../routes/insertUser.php');


$app->run();

?>