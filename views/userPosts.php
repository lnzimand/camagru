<?php

session_start();
require_once "../config/connection.php";

if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}

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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    	<script src="asset/js/bootstrap-datepicker.js"></script>
    	<script src="asset/js/bootstrap-datepicker.en-GB.min.js"></script>
    	<link rel="stylesheet" href="asset/css/bootstrap-datepicker.css">
    	<link rel="stylesheet" href="asset/css/images-grid.css">
		<script src="asset/js/images-grid.js"></script>
    	<style>

			[contenteditable] {
				outline: 0px solid transparent;
				min-height:100px;
				height: auto;
				cursor: auto;
			}

			[contenteditable]:empty:before {
				content: attr(placeholder);
				color:#ccc;
				cursor: auto;
			}

			[placeholder]:empty:focus:before {
				content: "";
			}

			#temp_url_content a {
				text-decoration: none;
			}
			#temp_url_content a:hover {
				text-decoration: none;
			}
			#temp_url_content h3, #temp_url_content p {
				padding:0 16px 16px 16px;
			}

			.fileinput-button input {
				position: absolute;
				top: 0;
				right: 0;
				margin: 0;
				height: 100%;
				opacity: 0;
				filter: alpha(opacity=0);
				font-size: 200px !important;
				direction: ltr;
				cursor: pointer;
			}
			.wrapper-preview {
				padding: 50px;
				background: #fff;
				box-shadow: 0 1px 4px rgba(0,0,0,.25);
				border-radius: 10px;
				text-align:center;
			}

			.wrapper-box {
				padding: 20px;
				margin-bottom: 20px;
				background: #fff;
				box-shadow: 0 1px 4px rgba(0,0,0,.25);
				border-radius: 10px;
			}

			.wrapper-box-title {
				font-size: 20px;
				line-height: 100%;
				color: #000;
				padding-bottom: 8px;
			}

			.wrapper-box-description {
				font-size: 14px;
				line-height: 120%;
				color: #000;
			}

			#friend_request_list li {
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
                    <li><a href="userPosts.php">Your Posts</a>
			    	<li><a href="logout.php">Logout</a></li>
			    </ul>
		  	</div>
		</nav>
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<br />
					<div id="timeline_area">
						<?php require_once "showpics.php"; ?>
					</div>
				</div>
			</div>

		</div>
		<br />
		<br />
	</body>
</html>