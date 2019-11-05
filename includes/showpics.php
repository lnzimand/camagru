<?php
session_start();

require "connection.php";

try {
  $stmt = $connection->prepare("SELECT * FROM gallery WHERE userid= :userid ORDER BY upload_date DESC");
  $stmt->bindParam(':userid', $_SESSION['userid']);
  $stmt->execute();

  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    echo "<p>".$row['caption']."</p><br>";
    echo "<img src='".$row['img']."'width='40%' height='40%'><br>";
    $text1 = <<<_END
    <!Doctype html>
    <html>
    <style>
    .btn-group button {
      background-color: grey;
      border: 1px solid #f1f1f1;
      color: white;
      padding: 10px 24px;
      cursor: pointer;
      float: left;
      width: 380px;
    }

    .btn-group:after {
      content: "";
      clear: both;
      display: table;
    }

    .btn-group button:not(:last-child) {
      border-right: none;
    }

    .btn-group button:hover {
      background-color: black;
    }
    </style>
    <body>
_END;
  $text2 = <<<_END
  <div class="btn-group">
     <button onclick="window.location.href='like_pic.php'">like</button>
     <button onclick="window.location.href='delete_pic.php'">delete</button>
   </div></body></html>
_END;
$text3 = <<<_END
<div class="btn-group">
   <button onclick="window.location.href='like_pic.php'">unlike</button>
   <button onclick="window.location.href='delete_pic.php'">delete</button>
 </div></body></html>
_END;
    if (!$row['like'])
    {
      echo $text1.$text2;
    }
    else {
      echo $text1.$text3;
    }

  }
}
catch(PDOException $e)
{
  echo "Error: " . $e->getMessage();
}
?>
