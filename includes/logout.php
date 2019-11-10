<?php
session_start();
foreach ($_SESSION as $value) {
  unset($value);
}
session_destroy();
header("location:../login.php");
exit();
?>
