<?php

session_start();
require_once "../config/connection.php";

if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}

$error_message = '';

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
    if (!file_exists('../images/user_images/')) {
      mkdir('../images/user_images/', 0755, true);
    }
    $folder = "../images/user_images/";
	$file_path = $folder.$name;
	// $error_message = $_POST['caption'];
    move_uploaded_file($_FILES['filename']['tmp_name'], $file_path);
	try {
      $stmt = $connection->prepare("INSERT INTO gallery (userid, caption, img, upload_date) VALUES(:userid, :caption, :name, :upload_date)");
      $stmt->bindParam(':userid', $_SESSION['user_id']);
      $stmt->bindParam(':caption', $_POST['caption']);
      $stmt->bindParam(':name', $file_path);
      $stmt->bindParam(':upload_date', date("Y-m-d H:i:s"));
      $stmt->execute();
	} catch(PDOException $e) {
      $error_message = $e->getMessage();
    }
  }
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

			.dropbtn {
				background-color: #4CAF50;
				color: white;
				padding: 16px;
				font-size: 16px;
				border: none;
			}

			.dropdown {
				position: relative;
				display: inline-block;
			}

			.dropdown-content {
				display: none;
				position: absolute;
				background-color: #f1f1f1;
				min-width: 160px;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
				z-index: 1;
			}

			.dropdown-content a {
				color: black;
				padding: 12px 16px;
				text-decoration: none;
				display: block;
			}

			.dropdown-content a:hover {background-color: #ddd;}

			.dropdown:hover .dropdown-content {display: block;}

			.dropdown:hover .dropbtn {background-color: #3e8e41;}

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
					<li>
						<div class="dropdown">
							<button class="dropbtn">Change Credentials</button>
							<div class="dropdown-content">
								<a href="changing_passwd.php">Change Password</a>
								<a href="update_username.php">Update Username</a>
								<a href="update_email.php">Update Email</a>
								<a href="email_notification.php">Notifications</a>
							</div>
						</div>
					</li>
			    	<li><a href="logout.php">Logout</a></li>
			    </ul>
		  	</div>
		</nav>
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<form method='post' id="post" action="home.php" enctype='multipart/form-data'>
									<div class="col-md-6">
										<h3 class="panel-title">Create Post</h3>
									</div>
									<div class="col-md-6 text-right">
										<span class="btn btn-success btn-xs fileinput-button">
											<!-- <input type="file" name="files[]"/> -->
												<span>Add File</span>	
												<input type='file' name='filename'><br>
										</span>
									</div>
									<div class="panel-body">
										<textarea name="caption" id="content" cols="85" rows="5"></textarea>
										<!-- <div id="content_area" name="caption" contenteditable="true" placeholder="Write Caption...."></div> -->
									</div>
									<div class="panel-footer" align="right">
										<input type="submit" class="btn btn-primary btn-md" value='Post'/>
									</div>
								</form>
							</div>
						</div>
					</div>
					<br />
					<div>
						<label class="text-danger"><?php echo $error_message; ?></label>
					</div>
					<div id="timeline_area">
						<?php require_once "gallery.php"; ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-6">
									<h3 class="panel-title">Camera</h3>
								</div>
								<div class="col-xs-6">
									<!-- <input type="text" name="search_friend" id="search_friend" class="form-control input-sm" placeholder="Search" /> -->
								</div>
							</div>
						</div>
						<div class="panel-body">
							<div id="photos"></div>
							<div id="camera">
								<span class="tooltip"></span>
								<span class="camTop"></span>
								<div id="screen"></div>
								<div id="buttons">
									<div class="buttonPane">
										<a id="shootButton" href="" class="blueButton">Shoot!</a>
									</div>
									<div class="buttonPane hidden">
										<a id="cancelButton" href="" class="blueButton">Cancel</a> <a id="uploadButton" href="" class="greenButton">Upload!</a>
									</div>
								</div>
								<span class="settings"></span>
							</div>
							<!-- <div class="text-center">
								<div id="camera_info"></div>
								<div id="camera"></div><br>
								<button id="take_snapshots" class="btn btn-success btn-sm">Take Snapshots</button>
							</div>
							<div>
								<table class="table">
									<thead>
										<tr>
											<th>Image</th><th>Image Name</th>
										</tr>
									</thead>
									<tbody id="imagelist">
									</tbody>
								</table>
							</div> -->
							<!-- <div id="friends_list"></div> -->
						</div>
					</div>
				</div>
			</div>

		</div>
		<br />
		<br />
	</body>
</html>
<script>
	$(document).ready(function(){

		var camera = $('#camera'),
			photos = $('#photos'),
			screen =  $('#screen');

		var template = '<a href="uploads/original/{src}" rel="cam" '
			+'style="background-image:url(uploads/thumbs/{src})"></a>';

		/*----------------------------------
			Setting up the web camera
		----------------------------------*/

		webcam.set_swf_url('assets/webcam/webcam.swf');
		webcam.set_api_url('upload.php');   // The upload script
		webcam.set_quality(80);             // JPEG Photo Quality
		webcam.set_shutter_sound(true, 'assets/webcam/shutter.mp3');

		// Generating the embed code and adding it to the page:
		screen.html(
			webcam.get_html(screen.width(), screen.height())
		);

		/*----------------------------------
			Binding event listeners
		----------------------------------*/

		var shootEnabled = false;

		$('#shootButton').click(function(){

			if(!shootEnabled){
				return false;
			}

			webcam.freeze();
			togglePane();
			return false;
		});

		$('#cancelButton').click(function(){
			webcam.reset();
			togglePane();
			return false;
		});

		$('#uploadButton').click(function(){
			webcam.upload();
			webcam.reset();
			togglePane();
			return false;
		});

		camera.find('.settings').click(function(){
			if(!shootEnabled){
				return false;
			}

			webcam.configure('camera');
		});

		// Showing and hiding the camera panel:

		var shown = false;
		$('.camTop').click(function(){

			$('.tooltip').fadeOut('fast');

			if(shown){
				camera.animate({
					bottom:-466
				});
			}
			else {
				camera.animate({
					bottom:-5
				},{easing:'easeOutExpo',duration:'slow'});
			}

			shown = !shown;
		});

		$('.tooltip').mouseenter(function(){
			$(this).fadeOut('fast');
		});
	}

	/*----------------------
        Callbacks
    ----------------------*/

    webcam.set_hook('onLoad',function(){
        // When the flash loads, enable
        // the Shoot and settings buttons:
        shootEnabled = true;
    });

    webcam.set_hook('onComplete', function(msg){

        // This response is returned by upload.php
        // and it holds the name of the image in a
        // JSON object format:

        msg = $.parseJSON(msg);

        if(msg.error){
            alert(msg.message);
        }
        else {
            // Adding it to the page;
            photos.prepend(templateReplace(template,{src:msg.filename}));
            initFancyBox();
        }
    });

    webcam.set_hook('onError',function(e){
        screen.html(e);
	});
	
	/*-------------------------------------
        Populating the page with images
    -------------------------------------*/

    var start = '';

    function loadPics(){

        // This is true when loadPics is called
        // as an event handler for the LoadMore button:

        if(this != window){
            if($(this).html() == 'Loading..'){
                // Preventing more than one click
                return false;
            }
            $(this).html('Loading..');
        }

        // Issuing an AJAX request. The start parameter
        // is either empty or holds the name of the first
        // image to be displayed. Useful for pagination:

        $.getJSON('browse.php',{'start':start},function(r){

            photos.find('a').show();
            var loadMore = $('#loadMore').detach();

            if(!loadMore.length){
                loadMore = $('<span>',{
                    id          : 'loadMore',
                    html        : 'Load More',
                    click       : loadPics
                });
            }

            $.each(r.files,function(i,filename){
                photos.append(templateReplace(template,{src:filename}));
            });

            // If there is a next page with images:
            if(r.nextStart){

                // r.nextStart holds the name of the image
                // that comes after the last one shown currently.

                start = r.nextStart;
                photos.find('a:last').hide();
                photos.append(loadMore.html('Load More'));
            }

            // We have to re-initialize fancybox every
            // time we add new photos to the page:

            initFancyBox();
        });

        return false;
    }

    // Automatically calling loadPics to
    // populate the page onload:

	loadPics();
	
	/*----------------------
        Helper functions
    ------------------------*/

    // This function initializes the
    // fancybox lightbox script.

    function initFancyBox(filename){
        photos.find('a:visible').fancybox({
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic',
            'overlayColor'  : '#111'
        });
    }

    // This function toggles the two
    // .buttonPane divs into visibility:

    function togglePane(){
        var visible = $('#camera .buttonPane:visible:first');
        var hidden = $('#camera .buttonPane:hidden:first');

        visible.fadeOut('fast',function(){
            hidden.show();
        });
    }

    // Helper function for replacing "{KEYWORD}" with
    // the respectful values of an object:

    function templateReplace(template,data){
        return template.replace(/{([^}]+)}/g,function(match,group){
            return data[group.toLowerCase()];
        });
    }
});


</script>