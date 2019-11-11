<?php
include_once('connection.php');
session_start();
include_once ("../header.php");
$per_page = 5;

if (isset($_GET['page'])) {
  $page = $_GET['page'] - 1;
  $offset = $page * $per_page;
}
else {
  $page = 0;
  $offset = 0;
}

try {
  $stmt = $connection->prepare("SELECT count(id) FROM gallery ORDER by upload_date DESC");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $total_images = $result[0]['count(id)'];


  if ($total_images > $per_page) {
    $num = $total_images / $per_page;
    $pages_total = ceil($num);
    $page_up = $page + 2;
    $page_down = $page;
    $display ='';
  }
  else {
    $pages = 1;
    $pages_total = 1;
    $display = ' class="display-none"';
  }

}
catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

echo '<h2'.$display.'>Page '; echo $page + 1 .' of '.$pages_total.'</h2>';

$i = 1;

echo '<div id="pageNav"'.$display.'>';

if ($page) {
echo '<a href="gallery.php"><button><<</button></a>';
echo '<a href="login_success.php?page='.$page_down.'"><button><</button></a>';
}

for ($i=1;$i<=$pages_total;$i++) {
if(($i==$page+1)) {
echo '<a href="login_success.php?page='.$i.'"><button class="active">'.$i.'</button></a>';
}

if(($i!=$page+1)&&($i<=$page+3)&&($i>=$page-1)) {
echo '<a href="login_success.php?page='.$i.'"><button>'.$i.'</button></a>'; }
}

if (($page + 1) != $pages_total) {
echo '<a href="login_success.php?page='.$page_up.'"><button>></button></a>';
echo '<a href="login_success.php?page='.$pages_total.'"><button>>></button></a>';
}
echo '</div>';

echo '<div id="gallery">';
try {
$stmt = $connection->prepare("SELECT * FROM gallery ORDER BY upload_date DESC LIMIT $offset, $per_page");
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {

$image=$row['img'];

echo '<div class="img-container">';
echo '<div class="img">';
echo $row['caption']."<br>";
echo '<a href="'.$image.'">';
echo '<img src="'.$image.'" width="40%" height="40%">';
echo '</a><br>';
$stmt = $connection->prepare("SELECT COUNT(*) FROM likes WHERE galleryid =".$row['id']);
$stmt->execute();
$likes = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo $likes[0]['COUNT(*)']. " people liked this";
if ($_SESSION['loggedin'] === true)
{
  echo '<div class="likes">
      <form action="likeNcomment.php" method="post">
        <input type="hidden" name="userid" value="'.$_SESSION['userid'].'">
        <input type="hidden" name="galleryid" value="'.$row['id'].'">
        <button type="submit" name="like" value="'.$row['img'].'">Like</button>
        <textarea name="comment" rows="2" cols="110"></textarea>
        <button type="submit" name="button">comment</button>
      </form>
    </div>';
}
$stmt = $connection->prepare("SELECT * FROM comment WHERE galleryid =".$row['id']);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<h5>Comments</h5>";
foreach ($comments as $value) {
  echo "<p>".$value['comment']."</p>";
}
echo '</div>';
echo '</div>';

  }
}
catch(PDOException $e)
{
  echo "Error: " . $e->getMessage();
}

echo '</div>';

echo '<div class="clearfix"></div>';
include_once("../footer.php");
?>
