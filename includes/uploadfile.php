<?php session_start();
if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true)
{
  header("location: ../login.php");
  exit();
}
?>
<body>
    <?php echo '<h3>Login Success, Welcome - '.$_SESSION['username'].'</h3>';?>
    <form method='post' action='upload.php' enctype='multipart/form-data'>
      Select a JPG, GIF, PNG or TIF  File:
      <input type='file' name='filename'><br>
      <textarea name='caption' rows='a' cols='50' placeholder="Caption"></textarea><br>
      <input type='submit' value='upload'><br>
    </form>
</body>
