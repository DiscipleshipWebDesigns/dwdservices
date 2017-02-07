<?php
	//create a database connection
	$dbhost = "127.0.0.1";
	$dbuser = "root";
	$dbpass = "Odie8987";
	$dbname = "jlmsold";
	$db = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);
	if (mysqli_connect_errno()) {
		die("database connection failed:". 
			mysqli_connect_error() .
			"(" . mysqli_connect_errno().")");
	}

?>