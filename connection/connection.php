
<?php

	define("DB_HOST", "127.0.0.1");
	define("DB_USER", "root");
	define("DB_PASSWORD", "");
	define("DB_DATABASE", "php_futsal");

    $conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    
    if($conn) {
		//
	}
	else {
		 echo "Connection is impossible.". "<br />";
		 echo mysqli_connect_error($conn);
	}
?>