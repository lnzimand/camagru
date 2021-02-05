<?php

session_start();

if(!isset($_SESSION["user_id"])) {
    header('location:login.php');
}

include('function.php');

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Camagru | HOME</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--<script src="asset/js/jquery.js"></script>!-->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    	<script src="asset/js/bootstrap.min.js"></script>
    	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    	
    	<script src="asset/js/bootstrap-datepicker.js"></script>
    	<script src="asset/js/bootstrap-datepicker.en-GB.min.js"></script>
    	<link rel="stylesheet" href="asset/css/bootstrap-datepicker.css">
    	<link rel="stylesheet" href="asset/css/images-grid.css">
    	<script src="asset/js/images-grid.js"></script>
    	<style>

    		.wrapper-preview
    		{
    			padding: 50px;
			    background: #fff;
			    box-shadow: 0 1px 4px rgba(0,0,0,.25);
			    border-radius: 10px;
			    text-align:center;
    		}

    		.wrapper-box
    		{
    			padding: 20px;
			    margin-bottom: 20px;
			    background: #fff;
			    box-shadow: 0 1px 4px rgba(0,0,0,.25);
			    border-radius: 10px;
    		}

    		.wrapper-box-title
    		{
    			font-size: 20px;
			    line-height: 100%;
			    color: #000;
			    padding-bottom: 8px;
    		}

    		.wrapper-box-description
    		{
    			font-size: 14px;
			    line-height: 120%;
			    color: #000;
    		}

    		#friend_request_list li
    		{
    			padding:10px 12px;
    			border-bottom: 1px solid #eee;
    		}

    		.nopadding {
			   padding: 0 !important;
			   margin: 0 !important;
			}

    	</style>
	</head>
	<body vlink="#385898" alink="#385898" style="background-color: #f5f6fa">
		<nav class="navbar navbar-default">
		  	<div class="container-fluid">
			    <div class="navbar-header">
			      	<a class="navbar-brand" href="home.php">Camagru</a>
			    </div>
			    <ul class="nav navbar-nav navbar-right">
			    	<li><a href="profile.php?action=view"><b>Profile</b></a></li>
					<li><a href="userPosts.php">Your Posts</a></li>
			    	<li><a href="logout.php"></span> Logout</a></li>
			    </ul>
		  	</div>
		</nav>
		<div class="container">