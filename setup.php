<?php
	// Initialize connection to DB
	include_once('connection.php');

	// Check if table exist
	$query = "SELECT id FROM `" . $tablename . "`";
	$result = mysqli_query($conn, $query);
	if(empty($result)) {
		// Create table
		$sql = "CREATE TABLE " . $tablename . " (id INT(11) AUTO_INCREMENT PRIMARY KEY,recorded_time INT(11) UNIQUE,temp INT(11),rain INT(11),pop INT(11))";
		if (!mysqli_query($conn, $sql)) {
	    	die("Error creating table\nError: " . mysqli_error($conn));
		}
	}

	echo "Good to go!\n"
?>