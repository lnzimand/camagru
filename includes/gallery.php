<?php
session_start();

require_once "connection.php";
require_once "functions.php";

try {
  $stmt = $connection->prepare("SELECT * FROM gallery ORDER BY upload_date DESC");
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    echo "<p>".$row['caption']."</p><br>";
    echo "<img src='".$row['img']."'width='40%' height='40%'><br>";
    echo '<div class="likes">
          <form action="likeNcomment.php" method="post">
            <input type="hidden" name="userid" value="'.$_SESSION['userid'].'">
            <input type="hidden" name="galleryid" value="'.$row['id'].'">
            <button type="submit" name="like" value="'.$row['img'].'">Like</button>
            <textarea name="comment" rows="2" cols="110"></textarea>
            <button type="submit" name="button">comment</button>
          </form>
        </div>';
    echo getLikes($row['id']);
    echo getComments($row['id']);
    }
}
catch(PDOException $e)
{
  echo "Error: " . $e->getMessage();
}

?>
