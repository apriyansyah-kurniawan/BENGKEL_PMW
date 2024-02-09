<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "bengkel";

	// Create a connection
	$conn = mysqli_connect($servername, $username, $password, $database);

	if($conn) {
		echo "";
	}
	else {
		die("Error". mysqli_connect_error());
	}
?>