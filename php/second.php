<?php

	require 'core.inc.php';
    // require '..connection/connection.php';
    
	if (loggedin()) {
		$firstname = getuserfield('first_name');
		$lastname = getuserfield('last_name');  
		echo 'You\'re successfully logged in, '. $firstname .'. <a href="logout/logout.php">Logout</a><br />';
	}
	else {
		header ('location:login/loginForm.php');
	}

?>     