<?php

try {
        $query = "CREATE TABLE IF NOT EXISTS `login_data` (
          `login_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `user_id` int(11) NOT NULL,
          `login_otp` int(6) NOT NULL,
          `last_activity` datetime NOT NULL,
          `login_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        $connection->exec($query);
        // echo "Table users created successfully<br>";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: users <br>".$e->getMessage()."<br>";
    }

try {
        $query = "CREATE TABLE IF NOT EXISTS `register_user` (
          `register_user_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `user_name` varchar(250) NOT NULL,
          `user_email` varchar(250) NOT NULL,
          `user_password` varchar(250) NOT NULL,
          `user_activation_code` varchar(250) NOT NULL,
          `user_email_status` enum('not verified','verified') NOT NULL,
          `email_notification` VARCHAR(3) NOT NULL DEFAULT 'YES',
          `user_otp` int(11) NOT NULL,
          `user_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `user_avatar` varchar(100),
          `user_birthdate` date,
          `user_gender` enum('Male','Female'),
          `user_address` text,
          `user_city` varchar(250),
          `user_zipcode` varchar(30),
          `user_state` varchar(250),
          `user_country` varchar(250)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        $connection->exec($query);
        // echo "Table gallery created successfully<br>";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: gallery<br>".$e->getMessage()."<br>";
    }

try {
        $query  = "CREATE TABLE IF NOT EXISTS `posts_table` (
          `posts_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `user_id` int(11) NOT NULL,
          `post_content` text NOT NULL,
          `post_code` varchar(100) NOT NULL,
          `post_datetime` datetime NOT NULL,
          `post_status` enum('Publish', 'Draft') NOT NULL,
          `post_type` enum('Text', 'Media') NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        $connection->exec($query);
        // echo "Table like created successfully<br>";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: like <br>".$e->getMessage()."<br>";
    }

try {
        $query = "CREATE TABLE IF NOT EXISTS `media_table` (
          `media_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `post_id` int(11) NOT NULL,
          `media_path` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        $connection->exec($query);
        // echo "Table comment created successfully<br>";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: comment<br>".$e->getMessage()."<br>";
    }

    try {
      $query = "CREATE TABLE IF NOT EXISTS `gallery` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `userid` INT NOT NULL,
        `caption` VARCHAR(160),
        `img` VARCHAR(100) NOT NULL,
        `upload_date` DATETIME NOT NULL
      )";
      $connection->exec($query);
      // echo "Table gallery created successfully<br>";
  } catch (PDOException $e) {
      echo "ERROR CREATING TABLE: gallery<br>".$e->getMessage()."<br>";
  }

  try {
        $query  = "CREATE TABLE IF NOT EXISTS `likes` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `userid` INT NOT NULL,
          `galleryid` INT NOT NULL
        )";
        $connection->exec($query);
        // echo "Table like created successfully<br>";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: like <br>".$e->getMessage()."<br>";
    }

  try {
        $query = "CREATE TABLE IF NOT EXISTS `comment` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `userid` INT NOT NULL,
          `galleryid` INT NOT NULL,
          `comment` VARCHAR(255) NOT NULL
        )";
        $connection->exec($query);
        // echo "Table comment created successfully<br>";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: comment<br>".$e->getMessage()."<br>";
    }

?>
