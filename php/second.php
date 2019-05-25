<?php

	require 'Session.inc.php';
    // require '..connection/DatabaseConnection.php';
    
	if (loggedin()) {
		$firstname = getuserfield('first_name');
		$lastname = getuserfield('last_name');  
		echo 'You\'re successfully logged in, '. $firstname .'. <a href="logout/logout.php">Logout</a><br />';
	}
	else {
		header ('location:login/loginForm.php');
	}

?>     