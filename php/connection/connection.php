<?php
	define("DB_HOST", "");
	define("DB_USER", "");
	define("DB_PASSWORD", "");
	define("DB_DATABASE", "");

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    
    if ($conn) {
		//
	} else {
		 echo "Connection is impossible.". "<br />";
		 echo mysqli_connect_error($conn);
		 die();
	}
?>