<?php
		require_once '../core.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Page Title</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" media="screen" href="main.css" />
	<script src="main.js"></script>
</head>
<body>
	
</body>
</html>



<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" media="screen" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../../css/lightbox.min.css">
		<link rel="stylesheet" type="text/css" href="../../css/home.css">
		<link rel="stylesheet" type="text/css" href="../../css/login.css">	

	</head>


	<body>	
		<div class="wrapper">
			<div class="top">
				<center>
					<strong>
						<a title="Futsal home" style="font-family: Bahnschrift;font-size:50px;color: #000;" href="http://www.gofootsal.com">GoFutsal.com<sup style="font-size: 20px">&reg</sup></a>
						<p><sup style="color: black;">for Kathmandu Valley</sup></p>
					</strong>
				</center>
				<span id="lang">
					<select onclick="">
						<option hidden="">Language</option>
						<option>English</option>
						<option>नेपाली</option>
					</select>
				</span>
				<div class="date">
					Nepal(NP)<img src="../../images/nepal.jpg" width="20px" />
					<div id="dt">
						
					</div>
				</div>
				<span id="member">		
					<a href="../register/register.php">Register</a>
				</span>
			</div>
			<div style="font-size:16px;" class="nav">
				<ul>
					<li><a title="Go To Home" href="../first.php">Home</a></li>
					<li><a title="Services" href="#">Services</a>
							<ul class="services">
								<li><a href="#">Booking</a></li>
								<li><a href="#">League</a></li>
							</ul>
					</li>
					<li><a title="Gallery" href="gallery.php">Gallery</a></li>
					<li><a title="Contact Us" href="#">About</a></li>
				</ul>		
			</div>
		</div>

		<div class="login-form">
			<h3>Login</h3>
				<form  action="authentication.php" method = "post">
					<table>	
							<tr>
								<td><label for="">Username</label></td>
							</tr>										
							<tr>
								<td><input id="uname" type="text" value="" name="uname" required="required" placeholder="Enter your username" /></td>
							</tr>
							<tr>
								<td><label for="">Password</label></td>
							</tr>
							<tr>
								<td><input id="pwd" type="password" name="pwd" placeholder="Enter your password" value="" required="required" /></td>
							</tr>
							<tr>
								<td><input type="submit" name="submit" value="Let me in" /></td>
							</tr>
					</table>
				</form>
			
		</div>

        <div class="bottom">
			<div style="width: 1200px;margin: auto;height: 200px">
			<span id="contactDetails">
				<img src="../images/telephoeLogo.png" /><u>01xxxxxxx</u>
				<img src="../images/mobileLogo.png" /><u>9xxxxxxxxxx</u>
				<span>
					<p style="color:#f7f7f7;">Please send us some feedback</p>
					<a href="https://mail.google.com">gotofutsal@gmail.com</a>
				</span>
			</span>
			<span id="social">
				<a id="fb" title="facebook_page" target="_blank	" href="http://www.facebook.com/online_futsal"><img src="../images/fb.png" alt="facebook" /></a>
				<a id="tw" title="twitter_handler" target="_blank" href="http://www.twitter.com/online_futsal"><img src="../../images/twitter.jpg" alt="twitter" /></a>
			</span>
			<div class="copyright" align="middle">
				<p>&copy 2006-2017<a href="http://www.gofootsal.com"> GoFutsal.com</a>. All Rights Reserved</p>
				<p>Kantipur Mall, Lalitpur</p>
			</div>
		</div>
    </body>
	
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/home.js"></script>
	<script type="text/javascript" src="../js/login.js"></script>

</html>