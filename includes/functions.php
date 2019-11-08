<?php

function getComments($imagenu)
{
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
    try{
        $stmt = $connection->prepare('SELECT * FROM likes WHERE galleryid = :imagenu');
        $stmt->bindParam(':imagenu', $imagenu);
        $stmt->execute();
        $val = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return ($stmt->fetchAll());
    }catch (PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
}
?>
