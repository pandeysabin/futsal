<?php

	require 'core.inc.php';
    // require '..connection/connection.php';
    
	if (loggedin()){
		echo 'You\'re successfully logged in . <a href="logout/logout.php">Logout</a>';
	}
	else {
		header ('location:login/loginForm.php');
	}

?>  