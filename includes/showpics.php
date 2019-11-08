<?php
session_start();

require_once "connection.php";
require_once "functions.php";

try {
  $stmt = $connection->prepare("SELECT * FROM gallery WHERE userid= :userid ORDER BY upload_date DESC");
  $stmt->bindParam(':userid', $_SESSION['userid']);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    echo "<p>".$row['caption']."</p><br>";
    echo "<img src='".$row['img']."'width='40%' height='40%'><br>";
    echo '<div class="likes">
          <form action="delete_pic.php" method="post">
            <button type="submit" name="delete" value="'.$row['img'].'">delete</button>
          </form>
        </div>';
    }
}
catch(PDOException $e)
{
  echo "Error: " . $e->getMessage();
}
?>
