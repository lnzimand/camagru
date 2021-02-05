<?php

require_once 'credentials.php';
try {
    $connection = new PDO(
        "mysql:host=$dbhost;",
        $dbuser,
        $dbpass
    );
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "CREATE DATABASE IF NOT EXISTS `".$dbname."`";
    $connection->exec($query);
    $connection = new PDO(
        "mysql:host=localhost;dbname=accounts",
        $dbuser,
        $dbpass,
    );
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    include_once('setup.php');

} catch (PDOException $e) {
    echo $e->getMessage();
}

?>