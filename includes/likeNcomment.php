<?php
require_once "connection.php";

$userid = $_POST['userid'];
$gallerid = $_POST['galleryid'];
$comment = $_POST['comment'];

if (isset($_POST['like']))
{
  try {
    $stmt = $connection->prepare("INSERT INTO likes(userid, galleryid)
        VALUES('$userid', '$gallerid')");
    $stmt->execute();

    header("location: login_success.php");
  }
  catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
elseif (isset($_POST['comment'])) {
  try {
    $stmt = $connection->prepare("INSERT INTO comment(userid, galleryid, comment)
    VALUES('$userid', '$gallerid', '$comment')");
    $stmt->execute();

    header("location: login_success.php");
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

}

?>
