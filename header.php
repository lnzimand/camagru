<?php
session_start();

if ($_SESSION['loggedin'])
{
  echo <<<_INIT
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <meta name="description" content="lnzimand's camagru">
      <meta name=viewport content="width=device-width, initial-scale=1">
      <title>Camagru</title>
      <style>
      .dropbtn {
        background-color: white;
        color: black;
        font-size: 15px;
      }

      .dropdown {
        position: absolute;
        display: inline-block;
        top: 0;
        right: 30%;
        padding: 16px;
        font-size: 15px;
      }

      .dropdown-content {
        display: none;
        position: absolute;
      }

      .dropdown-content a {
        color: black;
        text-decoration: none;
        display: block;
      }

      .dropdown-content a:hover {background-color: #ddd;}

      .dropdown:hover .dropdown-content {display: block;}

      .dropdown:hover .dropbtn {background-color: #f1f1f1;}
      </style>
    </head>
    <body>
      <nav>
      <div class="dropdown">
        <button class="dropbtn">Settings</button>
        <div class="dropdown-content">
          <a href="#">Profile</a>
          <a href="#">Change Password</a>
          <a href="#">Update Username</a>
          <a href="#">Update Email</a>
          <a href="#"></a>
        </div>
      </div>
      </nav>
    </body>
  </html>
_INIT;
}
else
{
  echo <<<_END
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
      <head>
        <meta charset="utf-8">
        <meta name="description" content="lnzimand's camagru">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title>Camagru</title>
        <link rel="stylesheet" href="includes/style.css">
      </head>
      <body>
        <nav>
          <a class="nav-item" href="#">Home</a>
          <a class="nav-item" href="#">About</a>
        </nav>
      </body>
    </html>
_END;
}
