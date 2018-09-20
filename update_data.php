<?php
	include_once('connection.php');

	// Clear table of ALL data
	$sql = "DELETE FROM ". $tablename;
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		$error = "Error deleting values from table\nDetailed Error: " . mysqli_error($conn);
    	save_log($error);
    	die($error);
	}
	save_log("Successfully cleared table");

	// Populate table with new data...
	$contents = file_get_contents("http://api.wunderground.com/api/78f3302b1b234107/hourly10day/q/31.12,77.22.json");
	$jsonIterator = new RecursiveArrayIterator(json_decode($contents, TRUE), RecursiveIteratorIterator::LEAVES_ONLY);

	foreach ($jsonIterator['hourly_forecast'] as $key => $val) {
		// Date and Time
		$d = $val['FCTTIME'];
		$date_str = mktime((int)$d['hour_padded'],(int)$d['min'],00,(int)$d['mon_padded'],(int)$d['mday_padded'],(int)$d['year']);
		$date = strtotime(date("Y-m-d h:i:s", $date_str));
		// Temperature, Rain chance and POP
		$temp = (int)$val['temp']['metric'];
		$rain = ((int)$val['qpf']['english'])*25.4;
		$pop  = (int)$val['pop'];

		$sql = "INSERT INTO `" . $tablename . "` (`recorded_time`, `temp`, `rain`, `pop`) VALUES( '$date','$temp', '$rain', '$pop')";
		if (mysqli_query($conn, $sql) === TRUE) {
		    echo("New record created successfully\n");
		} else { 
			$error = "Warning: " . mysqli_error($conn);
	    	save_log($error);
		}
	}
	mysqli_close($conn);
	save_log("Successfully made a new table of data");


	// Log activities
	function save_log($event){
		$file    = realpath(dirname(__FILE__)) . "/logs/log.txt";
		// Make log if dosen't exist
		if (!file_exists($file)) {
			touch($file);
		}	
		$current = file_get_contents($file);
		$txt     = date("Y-m-d h:i:sa") . " - " . $event . "\n";
		@file_put_contents($file, $current . $txt);
		// Also output to console
		echo $txt;
	}
?>
