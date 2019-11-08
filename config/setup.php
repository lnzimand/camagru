<?php
require 'database.php';

try {
        $connection = new PDO("mysql:host=$dbhost;", $dbuser, $dbpass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "CREATE DATABASE IF NOT EXISTS `".$dbname."`";
        $connection->exec($query);
        $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Database created successfully<br>";
    } catch (PDOException $e) {
        echo "ERROR CREATING DB: $dbname<br>".$e->getMessage()."<br>";
        exit(-1);
    }

try {
        $query = "CREATE TABLE IF NOT EXISTS `users` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `username` VARCHAR(50) NOT NULL,
          `email` VARCHAR(100) NOT NULL,
          `password` VARCHAR(255) NOT NULL,
          `vkey` VARCHAR(50) NOT NULL,
          `verified` TINYINT(1) NOT NULL DEFAULT 0,
          UNIQUE(`email`, `username`)
        )";
        $connection->exec($query);
        // echo "Table users created successfully<br>";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: users <br>".$e->getMessage()."<br>";
    }

try {
        $query = "CREATE TABLE IF NOT EXISTS `gallery` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `userid` INT NOT NULL,
          `caption` VARCHAR(160),
          `img` VARCHAR(100) NOT NULL,
          `upload_date` DATETIME NOT NULL
          -- FOREIGN KEY (userid) REFERENCES users(id)
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
          -- FOREIGN KEY (userid) REFERENCES users(id),
          -- FOREIGN KEY (galleryid) REFERENCES gallery(id)
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
          -- FOREIGN KEY (userid) REFERENCES users(id),
          -- FOREIGN KEY (galleryid) REFERENCES gallery(id)
        )";
        $connection->exec($query);
        // echo "Table comment created successfully<br>";
    } catch (PDOException $e) {
        echo "ERROR CREATING TABLE: comment<br>".$e->getMessage()."<br>";
    }
?>
