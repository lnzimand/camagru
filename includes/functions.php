<?php
include_once '../config/database.php';

function getComments($imagenu)
{
    include "connection.php";
    try{
        $stmt = $connection->prepare('SELECT * FROM comments WHERE galleryid = :imagenu');
        $stmt->bindParam(':imagenu', $imagenu);
        $stmt->execute();
        $val = $exe->setFetchMode(PDO::FETCH_ASSOC);
        return ($exe->fetchAll());
    }catch (PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
}

function getLikes($imagenu)
{
    echo $imagenu;
    echo $dbhost;
    try{
        echo "you shelter me";
        $connection = new PDO('mysql:host='."'localhost'".';dbname='."'accounts'", "root", "palesa");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $connection->prepare("SELECT COUNT(*) FROM likes WHERE galleryid = $imagenu");
        echo "and here";
        // $stmt->bindParam(':imagenu', );
        $stmt->execute();
        $val = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return ($stmt->fetchAll());
    }catch (PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
}
?>
