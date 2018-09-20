<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather_db";
$tablename = "weather_info";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed - check DB creds in connection.php are valid\nError: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
$result = mysqli_query($conn, $sql);

// Connect to DB
mysqli_select_db($conn, $dbname)
?>