<?php
session_start();
require_once "../config/connection.php";
if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}

if ($_FILES['filename']) {
  switch ($_FILES['filename']['type']) {
    case 'image/jpeg':  $ext = 'jpg'; break;
    case 'image/png':   $ext = 'png'; break;
    case 'image/gif':   $ext = 'gif'; break;
    case 'image/tiff':  $ext = 'tif'; break;
    default:            $ext = '';    break;
  }
  if ($ext) {
    $username = $_SESSION['username'];
    $name = md5(time().$username).".".$ext;
    if (!file_exists('../images/user_images')) {
      mkdir('../images/user_images', 0755, true);
    }
    $folder = "../images/user_images";
    $file_path = $folder.$name;
    move_uploaded_file($_FILES['filename']['tmp_name'], $file_path);
    echo getcwd();
    try {
      $stmt = $connection->prepare("INSERT INTO gallery (userid, caption, img, upload_date) VALUES(:userid, :caption, :name, :upload_date)");
      $stmt->bindParam(':userid', $_SESSION['user_id']);
      $stmt->bindParam(':caption', $_POST['caption']);
      $stmt->bindParam(':name', $file_path);
      $stmt->bindParam(':upload_date', date("Y-m-d H:i:s"));
      $stmt->execute();

      header("location:home.php");
      exit();
    }
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  }
} else {
  header("location:home.php");
}

?>
