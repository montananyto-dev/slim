<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT');


require ('../../vendor/autoload.php');

$settings = ['settings'=> ['displayErrorDetails'=>true,],];

$app = new \Slim\App($settings);


require_once('../routes/login.php');
require_once ('../routes/dbconnect.php');
require_once ('../routes/user.php');
require_once ('../routes/user-type.php');
require_once('../routes/module.php');
require_once('../routes/organisation.php');
require_once('../routes/course.php');
require_once ('../routes/project.php');


$app->run();