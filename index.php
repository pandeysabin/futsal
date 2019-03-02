<?php
	require 'php/core.inc.php';
	$options = [
		'cost' => 10,
	];
	$password_hash = password_hash("Ab_r$37849", PASSWORD_BCRYPT, $options);
	echo $password_hash;
	if (password_verify('Ab_r$37849', $password_hash )) {
		echo "Password is valid.";
	}

	$userIp = $_SERVER["REMOTE_ADDR"];

	function ipAdd() 
	{
		global $conn, $userIp;	
		$ip = $userIp;
		$query = "INSERT INTO `hitsIp` VALUES('$ip')";
		$queryRun = mysqli_query($conn, $query);
		if ($queryRun) {
			//  
			echo mysqli_error($conn);
		}
	}

	function ipCheck()
	{
		global $conn, $userIp;
		$query = "SELECT `ip` FROM `hitsIp`";
		$queryRun = mysqli_query($conn, $query);
		if (($queryRun)) {
			if (mysqli_num_rows($queryRun) == NULL) {
				return true;
			} else {
				while ($row = mysqli_fetch_assoc($queryRun)) {
					$ip = $row['ip'];
					if ($userIp == $ip) {
						return false;
					}
				}
				return true;
			}
		} else {
			echo mysqli_error($conn);
		}
		
	}

	function updateCount() 
	{
		global $conn;
		$query = "SELECT `counts` FROM `hitsCount`";
		$queryRun = mysqli_query($conn, $query);
		if ($queryRun) {
			$row = mysqli_fetch_assoc($queryRun);
			$count = $row['counts'];
			$count = $count + 1;
			$query1 = "UPDATE hitsCount SET counts = $count";
			$queryRun1 = mysqli_query($conn, $query1);
			if ($queryRun1) {
				return true;
			} else {
				echo mysqli_error($conn);
			}
		} else {
			echo mysqli_error($conn);
		}
	} 	
	
	function isConnected()
	{
		$connected = @fsockopen("www.google.com", 80);

		if ($connected) {
			$is_conn = true; //action when connected.
		}
	}


	if (ipCheck()) {
		if (updateCount()) {
			ipAdd();
		}
	}

	// Registering a user
	if (isset($_GET['mode']) == "register") {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['sbmt'])) {
				$fnameErr = $mnameErr = $lnameErr = $pwdErr = "";
				$firstName = $_POST['fname']; 
				$middleName = $_POST['mname'];
				$lastName = $_POST['lname'];
				$email = $_POST['email'];
				$password = $_POST['pwd'];
				$password_again = $_POST['cpwd'];

				if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password) && !empty($password_again)) {
					if ($password != $password_again) {
						echo '<script>',
							'alert("passwords didn\'t match.")',
							'</script>';
					} else {
						$password_hash = sha1($password);
						$query = "SELECT `emailid` FROM `udetails` WHERE `emailid`='$email'";
						$query_run = mysqli_query($conn, $query);

						if ($query_run) {
							if (mysqli_num_rows($query_run) == 1) {
								echo "It's already used sir. Please try another one.";
							} else {
								$insertQuery = "INSERT INTO `udetails` (fname, mname, lname, emailid, pwd) VALUES('$firstName', '$middleName', '$lastName', '$email', '$password_hash')";
								$query_run = mysqli_query($conn, $insertQuery);

								if ($query_run) {
								?>
									<div style="padding: 20px; margin: 10px;">
										<h1>Congratulations, you're successfully register</h1>
									</div>
								<?php	
								} else {
									echo '<script>', 'alert("Query isn\'t being run.")', '</script>';
								}
							}
						} else {
							echo mysqli_error($conn);
						}
					}
				} else {
					echo '<script>',
						'alert("Please enter all required fields if you really want to register for the futsal community.")',
						'</script>';
				}
			}
		}
	}

	# check if user wants to login and authenticate the user
	if (isset($_GET['mode']) == "auth") {  			
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST["submit"])) {
				$unameErr = $pwdErr = "";
				$username = $password = "";
				if (empty($_POST["uName"])) {
					$unameErr = "Please enter username.";
					echo '<script>',
						'alert("Please enter username.")',
						'</script>';
				} else {
					$username = mysqli_real_escape_string($conn, $_POST['uName']);
					if (empty($_POST["pwd"])) {
						$pwdErr = "Please enter password.";
					} else {
						$password = mysqli_real_escape_string($conn, $_POST['pwd']);
						
						$query = "SELECT `id`, `pwd` FROM `logInData` WHERE uname='$username'";
						$query_run = mysqli_query($conn, $query);
						
						if ($query_run) {
							$query_num_rows = mysqli_num_rows($query_run);
								
							if ($query_num_rows == NULL) {
								echo "Invalid username";
							} else if ($query_num_rows == 1) {
								while ($array = mysqli_fetch_assoc($query_run)) {
									$password_hash = $array['pwd'];
									if (password_verify($password, $password_hash)) {
										echo "Password is valid.";
										$userId = $array['id'];
										$_SESSION['userId'] = $userId;
										header ('location:index.php');
									}
									
								}
							} else {
								echo "No two same data";
							}
						} else {
						echo mysqli_error($conn);
						// echo mysqli_error($q);
						}
					}
				}
			}
		}
	}

	# check if logout button is click and perform action according to it.
	if (isset($_GET['mode']) == "logout") {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['logout'])) {
				session_start();

				$_SESSION = array();

				if (ini_get("session.use_cookies")) {
					$params = session_get_cookie_params();
					setcookie(session_name(), '', time() - 4200,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
					);
				}

				// Finally, destroy the session.
				session_destroy();

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
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<!-- <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css"> -->
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
									$query = "SELECT `fname` FROM `udetails` WHERE `id` = '".$_SESSION['userId']."'";
									if($query_run = mysqli_query($conn, $query)) {
										if($mysqli_num_rows = mysqli_num_rows($query_run)) {
											while($array = mysqli_fetch_assoc($query_run)) {
												$firstName = $array['fname'];
				?>
												<div id="member">
													<div class="btn-group user">
														<button type="button" class="btn btn-danger dropdown-toggle user-name" data-toggle="dropdown"><a href=""><?php echo $firstName ?></a></button>		
														<div class="dropdown-menu">
															<a class="dropdown-item" href="#">Settings</a>
															<div class="dropdown-divider"></div>
															<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>?mode=logout" method="POST">
																<input type="submit" name="logout" value="Logout" class="dropdown-item">
															</form>
															
														</div>
													</div>
												</div>
								<?php 
											}
										}
									}
								} else if(!loggedIn()) {
									?>
									<div id="member">
										<button id="login">Login</button>
										<button id="register">Register</button>
									</div>
			<?php
								} else {
									echo mysqli_error($conn);
						}
			?>
			</div>
			<div style="font-size:16px;" class="nav">
				<ul>
					<li><a title="Go To Home" href="<? echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">Home</a></li>
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
				<form name="logInForm"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?mode=auth" method="POST" >
					<center>
						<table>
							<div>
								<tr>
									<td><label for="uname">Username</label></td>
								</tr>										
								<tr>
									<td><input id="uname" type="text" name="uName" placeholder="Enter your username" pattern="^[A-Za-z][A-Za-z0-9.-_]{6,15}$"  title="Please enter a valid username" required autofocus  /></td>
									
								</tr>
							</div>
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
									<td><input id="pwd" type="password" name="pwd" placeholder="Enter your password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#$%^&*?<>~`_]).{8,}$"  title="It should contain at least one uppercase letter, one lowercase letter, one digit and a special character i.e. 8 characters in total." required /></td>
									
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
				<form name="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?mode=register" method="POST">
					<table>
						<tr>
							<td><label for="fname">Firstname</label></td>
						</tr>
						<tr>
							<td><input id="fname" type="text" name="fname" value="<?php $firstName ?>" placeholder="Enter your firstname" autofocus /></td>
						</tr>
						<tr>
							<td><label for="mname">Middlename</label></td>
						</tr>
						<tr>
							<td><input id="mname" type="text" name="mname" value="<?php $middleName ?>" placeholder="Enter your middlename" /></td>
						</tr>
						<tr>
							<td><label for="lname">Lastname</label></td>
						</tr>
						<tr>
							<td><input id="lname" type="text" name="lname" value="<?php $lastName ?>" placeholder="Enter your lastname" /></td>
						</tr>
						<tr>
							<td><label for="email">E-mail</label></td>
						</tr>
						<tr>
							<td><input type="email" name="email" id="email" value="<?php $email ?>" placeholder="Enter your email" /></td>
						</tr>
						<tr>
							<!-- <td><label for="uname">Username</label></td>		
						</tr>
						<tr>
							<td><input id="uname" type="text" name="uname" placeholder="Enter your username" required="required" /></td>
						</tr> -->
						<tr>
							<td><label for="lpwd">Password</label></td>
						</tr>
						<tr>
							<td><input id="lpwd" type="password" name="pwd" placeholder="Enter your password" /></td>
						</tr>
						<tr>
							<td><label for="cpwd">Confirm password</label></td>
						</tr>
						<tr>
							<td><input id="cpwd" type="password" name="cpwd" placeholder="Confirm your password" /></td>
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
					<a id="fb" title="facebook_page" target="_blank	" href="https://www.facebook.com/online_futsal"><img src="images/bottom/socialMedia/fb.png" alt="facebook" /></a>
					<a id="tw" title="twitter_handler" target="_blank" href="https://www.twitter.com/online_futsal"><img src="images/bottom/socialMedia/twitter.jpg" alt="twitter" /></a>
				</span>
				<div class="copyright" align="middle">
					<p>&copy 2006-2019<a href="http://www.gofootsal.com"> GoFutsal.com</a>. All Rights Reserved</p>
					<p>Kantipur Mall, Lalitpur</p>
				</div>
			</div>
		</div>	

		<!-- <script type="text/javascript">
			function abc() {
				document.registerForm.method="post";
				document.registerForm.action="index.php?mode=register";
				document.registerForm.submit();
			}
		</script> -->
		
		<noscript>
      		You need to enable JavaScript to run this app.
		</noscript>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="js/jquery.min.js" crossorigin></script>
		<!-- <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script> -->
		<script type="text/javascript" src="js/lightbox.min.js"></script>
  	
	  	<script type="text/javascript" src="js/home.js"></script>
	
	</body>
</html>