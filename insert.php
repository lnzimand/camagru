<?php
$dbhost = 'localhost';
$dbname = 'accounts';
$dbuser = 'root';
$dbpass = 'palesa';

class connect
{

  public function connection()
  {
    global $dbhost, $dbname, $dbpass, $dbuser;
    try {
      $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    }
    catch (PDOException $e) {
      echo "Connection failed" . $e->getMessage();
    }
  }
}

class insert extends connect
{
  function push($query)
  {
    global $dbhost, $dbname, $dbpass, $dbuser;
    try {
        parent::connection;
        $connection->exec($query);
        echo "New record created successfully";
        }
        catch(PDOException $e)
        {
          echo $query . "<br>" . $e->getMessage();
        }

      $connection = null;
    }
}
?>
