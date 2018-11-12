<?php
	require 'php/core.inc.php';

	$userIp = $_SERVER["REMOTE_ADDR"];

	function ipAdd() 
	{
		global $conn, $userIp;	
		$ip = $userIp;
		$query = "INSERT INTO `hitsIp` VALUES('$ip')";
		$queryRun = mysqli_query($conn, $query);
		if($queryRun)
		{
			//
		}
		else
		{
			echo mysqli_error($conn);
		}
	}

	
	function ipCheck()
	{
		global $conn, $userIp;
		$query = "SELECT `ip` FROM `hitsIp`";
		$queryRun = mysqli_query($conn, $query);
		if(($queryRun)) 
		{
			if(mysqli_num_rows($queryRun) == NULL) 
			{
				return true;
			} 
			else 
			{
				while($row = mysqli_fetch_assoc($queryRun)) 
				{
					$ip = $row['ip'];
					if($userIp == $ip) 
					{
						return false;
					}
				}
				return true;
			}
		} 
		else 
		{
			echo mysqli_error($conn);
		}
		
	}

	function updateCount() 
	{
		global $conn;
		$query = "SELECT `counts` FROM `hitsCount`";
		$queryRun = mysqli_query($conn, $query);
		if($queryRrun) 
		{
			$row = mysqli_fetch_assoc($queryRun);
			$count = $row['counts'];
			$count = $count + 1;
			$query1 = "UPDATE hitsCount SET counts = $count";
			$queryRun1 = mysqli_query($conn, $query1);
			if($queryRun1) 
			{
				return true;
			}
			else 
			{
				echo mysqli_error($conn);
			}

		} 
		else 
		{
			echo mysqli_error($conn);
		}
	}
	// echo phpinfo();	 		


	if(ipCheck()) 
	{
		if(updateCount())
		{
			ipAdd();
		}
	}

	if( isset( $_GET['mode']) == "auth" )
	{  			
		if ( $_SERVER["REQUEST_METHOD"] == "POST" ) 
		{
			$unameErr = $pwdErr = "";
			$username = $password = "";
			if (empty($_POST["uname"])) 
			{
				$unameErr = "Please enter username.";
				echo '<script>',
					'alert("Please enter username.")';
			}
			else 
			{
				$username = mysqli_real_escape_string($conn, $_POST['uname']);
				if( empty($_POST["pwd"]))
				{
					$pwdErr = "Please enter password.";
				}
				else
				{
					$password = mysqli_real_escape_string($conn, $_POST['pwd']);
					$password_hash = sha1($password);
					$query = "SELECT `id` FROM `users` WHERE user_name='$username' AND pwd='$password_hash'";
				
					$query_run = mysqli_query($conn, $query);
					
					
					if($query_run) 
					{
						$query_num_rows = mysqli_num_rows($query_run);
							
						if($query_num_rows == NULL) 
						{
							echo "Invalid username/password";
						}
						else if($query_num_rows == 1)
						{
							while($array = mysqli_fetch_assoc($query_run)) 
							{
								$user_id = $array['id'];
								$_SESSION['user_id'] = $user_id;
								header ('location:first.php');
							}
						}
						else 
						{
							echo "No two same data";
						}
					}
					else 
					{
					echo mysqli_error($conn);
					// echo mysqli_error($q);
					}
				}
				
			}

			
			
			
		}
	}


?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>No.1 Futsal online Booking website for Kathmandu Valley</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/lightbox.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/home.css">	
	</head>
	<body>
		

		<div class="wrapper">
			<div class="top">
				<center>
					<strong>
						<a title="Futsal home" style="font-family: Bahnschrift;font-size:50px;color: #000;" href="http://www.gofootsal.com">GoFutsal.com<sup style="font-size: 20px">&reg</sup></a>
						<sup style="color: black;">for Kathmandu Valley</sup>
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
					Nepal(NP)<img src="images/nav/nepal.jpg" width="20px" />
				</div>



				<!-- <span id="member">		
					<a href=""><?php $firstname ?></a>
				</span> -->
				<?php
								if(loggedIn()) {
									$query = "SELECT `firstName` FROM `users` WHERE `id` = '".$_SESSION['userId']."'";
									if($query_run = mysqli_query($conn, $query)) {
										if($mysqli_num_rows = mysqli_num_rows($query_run)) {
											while($array = mysqli_fetch_assoc($query_run)) {
												$firstname = $array['first_name'];
				?>
												<div id="member">
													<div class="btn-group user">
													<button type="button" class="btn btn-danger dropdown-toggle user-name" data-toggle="dropdown"><a href=""><?php echo $firstname ?></a></button>		
													<div class="dropdown-menu">
														<a class="dropdown-item" href="#">Settings</a>
														<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="#">Logout</a>
														</div>
													</div>
												</div>
								<?php 
											}
										}
									}
								}
								else if(!loggedIn()) {
									?>
									<div id="member">
										<button id="login">Login</button>
										<button id="register">Register</button>
									</div>
<?php
				}
				else {
					echo mysqli_error($conn);
				}
?>
			</div>
			<div style="font-size:16px;" class="nav">
				<ul>
					<li><a title="Go To Home" href="#">Home</a></li>
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




		<div class="content">
			<div class="login-form" style="display: none;">
				<h3 style="text-align: center;">Login</h3>
				<form name="logInForm"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?mode=auth" method="POST" onsubmit="return loginFormValidate()">
					<center>
						<table>	
								<tr>
									<td><label for="uname">Username</label></td>
								</tr>										
								<tr>
									<td><input id="uname" type="text" name="uName" placeholder="Enter your username" autofocus /></td>
								</tr>
								<?php
									if(isset($unameErr) && !empty($unameErr))
									{
								?>
										<div class="errMessage">
											<p style="color: red">Please enter your username.</p>
										</div>
								<?php
									$unameErr = "";	
									}
								?>
								<tr>
									<td><label for="pwd">Password</label></td>
								</tr>
								<tr>
									<td><input id="pwd" type="password" name="pwd" placeholder="Enter your password" value=""  /></td>
								</tr>
								<tr>
									<td><input type="submit" name="submit" value="Let me in" /></td>
								</tr>
						</table>
					</center>
				</form>
			</div>
			<div class="register" style="display: none;">
				<h3>Register</h3>
				<form action="" method="POST">
					<table>
						<tr>
							<td>Firstname</td>
						</tr>
						<tr>
							<td><input id="fname" type="text" name="fname" value="" placeholder="Enter your firstname" required="required" /></td>
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
							<td><input id="lpwd" type="password" name="pwd" placeholder="Enter your password" required="required" /></td>
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
    
			<div class="home">
				<p style="text-align: center;font-size: 50px;">"Welcome to futsal World"</p>
				<div class="left_home">
					<span id="img">
						<a href="images/body/messi.jpg" data-lightbox="CEO" data-title="CEO, Futsal Developement Program, Nepal">
							<img src="images/body/messi.jpg" width="100px" height="100px" />
							<hr style="width:100px;" />
							<p style="color: #000;font-family: Chiller;font-size: 20px;"><b>4-times Football Awards Winner</b></p>
							<p style="color:#000;font-size: 30px"><b>--Lionel Messi</b></p>
						</a>
					</span>
					<p>
						Lorem ipsum dolor sit amet, consectetur 
							dipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum..

						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>
				<div class="right_home">
					<div id="slider_news">
						<p>
							<span style="color: #fff;font-family: Bahnschrift;font-size: 20px;">Some of the glimpses.</span>
						</p>
						<div id="slider">
							<a href="images/body/goal.jpg" data-lightbox="pics" data-title="Futsal"><img src=" images/body/goal.jpg" width="100px" height="100px" /></a>
							<a href=" images/body/hi-res-33b03d2441834e692497946ec5bf8cdf_crop_north.jpg" data-lightbox="pics" data-title="Futsal"><img src="images/body/hi-res-33b03d2441834e692497946ec5bf8cdf_crop_north.jpg" width="100px" height="100px" /></a>
							<a href=" images/body/hi-res-692aa20d167fb4238095cd980b0786b7_crop_north.jpg" data-lightbox="pics" data-title="Futsal"><img src="images/body/hi-res-692aa20d167fb4238095cd980b0786b7_crop_north.jpg" width="100px" height="100pxs" /></a>
						</div>
						<div class="news" align="middle">
							<p style="text-align: center;">Latest News and Transfers</p>
							<div id="first">
								<a href="https://www.espnfc.com" target="_blank"><b>Messi tends to stay in FC.....</b></a>
							</div>
							<div id="second">
								<a href="https://goal.com" target="_blank"><b>Ronaldo in conversation with PSG for January move.....</b></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="gallery">
				<div id="photo_gallery">
					<p style="font-size: 20px;text-align:center;"><b>Photo Gallery</b></p>
					<a href="images/body/footsal.jpg" data-lightbox="gallery" data-title="One of the footsal grounds in Kathmandu Valley"><img src="images/body/footsal.jpg" width="200px" height="100px" /></a>
					<a href="images/body/futsal1.jpg" data-lightbox="gallery" data-title="Playing in footsal ground in holidays"><img src="images/body/futsal1.jpg" width="200px" height="100px" /></a>
					<a href="images/body/futsal3.jpg" data-lightbox="gallery" data-title="Futsal at night is awesome as heaven"><img src="images/body/futsal3.jpg" width="200px" height="100px" /></a>
				</div>
				<hr style="border-width: 5px;" />	
				<div id="videoclips">
					<p style="font-size: 20px;text-align: center;"><b>Video Gallery</b></p>
					<iframe width="500" height="315" src="https://www.youtube.com/embed/MoHnffhBwqs" frameborder="0" allowfullscreen></iframe>
					<iframe width="500" height="315" src="https://www.youtube.com/embed/0j1B1eStj3k" frameborder="0" allowfullscreen></iframe>
					<iframe src="https://www.youtube.com/embed/HcwfIU9uFlY" width="500" height="315" frameborder="0" allowfullscreen></iframe>

				</div>
			</div>
			<div id="about">
				<div id="messageceo">
					<p style="font-size: 20px;font-family: Lucida Handwriting;color: #1d247c;"><u>Message from CEO....</u></p>
					<img src="images/body/CEO.jpg" width="150px" height="150px" />
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.s
					</p>
				</div>
				<div id="managing-director">
					<p style="font-family: Lucida Handwriting;color: #1d247c;"><u>Message from MD</u></p>
					<img src="images/body/CEO.jpg" width="150px" height="150px" alt="Message Director" />
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>
			</div>
		</div>
		



		<div class="bottom">
			<div style=" width: 1200px;margin: auto;height: 200px">
				<span id="contactDetails">
					<img src="images/bottom/telephoeLogo.png" /><u>01xxxxxxx</u>
					<img src="images/bottom/mobileLogo.png" /><u>9xxxxxxxxxx</u>
					<span>
						<p style="color:#f7f7f7;">Please send us some feedback</p>
						<a href="https://mail.google.com">gotofutsal@gmail.com</a>
					</span>
				</span>
				<span id="social">
					<a id="fb" title="facebook_page" target="_blank	" href="http://www.facebook.com/online_futsal"><img src="images/bottom/socialMedia/fb.png" alt="facebook" /></a>
					<a id="tw" title="twitter_handler" target="_blank" href="http://www.twitter.com/online_futsal"><img src="images/bottom/socialMedia/twitter.jpg" alt="twitter" /></a>
				</span>
				<div class="copyright" align="middle">
					<p>&copy 2006-2017<a href="http://www.gofootsal.com"> GoFutsal.com</a>. All Rights Reserved</p>
					<p>Kantipur Mall, Lalitpur</p>
				</div>
			</div>
		</div>	
		
		<noscript>
      		You need to enable JavaScript to run this app.
		</noscript>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin></script>
		<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="js/lightbox.min.js"></script>
  	
	  	<script type="text/javascript" src="js/home.js"></script>
	
	</body>
</html>