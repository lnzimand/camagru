<?php
session_start();
require_once "connection.php";

if ($_FILES)
{
  switch ($_FILES['filename']['type']) {
    case 'image/jpeg':  $ext = 'jpg'; break;
    case 'image/png':   $ext = 'png'; break;
    case 'image/gif':   $ext = 'gif'; break;
    case 'image/tiff':  $ext = 'tif'; break;
    default:            $ext = '';    break;
  }
  if ($ext)
  {
    $name = md5(time().$username).".".$ext;
    if (!file_exists('../uploads/')) {
    mkdir('../uploads/', 0777, true);
    }
    $folder = "../uploads/";
    $file_path = $folder.$name;
    move_uploaded_file($_FILES['filename']['tmp_name'], $file_path);
    try {
      $stmt = $connection->prepare("INSERT INTO gallery (userid, caption, img, upload_date) VALUES(:userid, :caption, :name, :upload_date)");
      $stmt->bindParam(':userid', $_SESSION['userid']);
      $stmt->bindParam(':caption', $_POST['caption']);
      $stmt->bindParam(':name', $file_path);
      $stmt->bindParam(':upload_date', date("Y-m-d H:i:s"));
      $stmt->execute();

      header("location: login_success.php");
      exit();
    }
    catch(PDOException $e)
    {
      echo "Error: " . $e->getMessage();
    }
  }
}
?>
