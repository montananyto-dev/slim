<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT');


//locally
require ('../vendor/autoload.php');

//live
//require ('../../vendor/autoload.php');


$settings = ['settings'=> ['displayErrorDetails'=>true,],];
$app = new \Slim\App($settings);


//locally
require_once('./routes/login.php');
require_once('./routes/insertUser.php');
require_once('./routes/myname.php');
require_once ('./routes/testDBconnection.php');
require_once ('./routes/user.php');

//live
//require_once('../routes/login.php');
//require_once('../routes/insertUser.php');
//require_once('../routes/myname.php');
//require_once ('../routes/testDBconnection.php');
//require_once ('../routes/user.php');


$app->run();