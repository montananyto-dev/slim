<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/11/2017
 * Time: 21:34
 */

$app->get('/home/connect',function(){

    require_once('dbconnect.php');

    $connection = connect_db();

});
