<?php

try {
    $connection = new PDO('mysql:108.179.213.60;port=3306;dbname=kingsub3_FYP', 'kingsub3_tony', 'Kingston2017!');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo 'Connection success';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
