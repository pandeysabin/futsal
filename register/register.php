<?php 
	require "../connection/connection.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register - Be a member</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/home.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/register.css" />
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
					Nepal(NP)<img src="images/nepal.jpg" width="20px" />
					<div id="dt">
						
					</div>
				</div>
				<span id="member">		
					<a href="../login/login.php">Login</a>
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

   
    <div class="register">
        <h3>Register</h3>
        <form action="" method="POST">
            <table>
                <tr>
                    <td>Firstname</td>
                </tr>
				<tr>
					<td><input id="fname" type="text" name="fname" placeholder="Enter your firstname" required="required" /></td>
				</tr>
				<tr>
					<td>Middlename</td>
				</tr>
				<tr>
					<td><input id="mname" type="text" name="mname" placeholder="Enter your middlename" /></td>
				</tr>
				<tr>
					<td>Lastname</td>
				</tr>
				<tr>
					<td><input id="lname" type="text" name="lname" placeholder="Enter your lastname" required="required" /></td>
				</tr>
				<tr>
					<td>Password</td>
				</tr>
				<tr>
					<td><input id="pwd" type="password" name="pwd" placeholder="Enter your password" required="required" /></td>
				</tr>
				<tr>
					<td>Confirm password</td>
				</tr>
				<tr>
					<td><input id="cpwd" type="password" name="cpwd" placeholder="Confirm your password" required="required" /></td>
				</tr>
				<tr>
					<td><input type="submit" name="sbmt" value="Register" /></td>
				</tr>
            </table>
        </form>
    </div>

    <div class="bottom">
        <div style=" width: 1200px;margin: auto;height: 200px">
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
                <a id="tw" title="twitter_handler" target="_blank" href="http://www.twitter.com/online_futsal"><img src="../images/twitter.jpg" alt="twitter" /></a>
            </span>
            <div class="copyright" align="middle">
                <p>&copy 2006-2017<a href="http://www.gofootsal.com"> GoFutsal.com</a>. All Rights Reserved</p>
                <p>Kantipur Mall, Lalitpur</p>
        </div>
	</div>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/register.js"></script>
</body>
</html>