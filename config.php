<?php 
session_start();
	// DATABASE CONFIGURATION ON LIVE SERVER
	// $conn = mysqli_connect("localhost","facultye_faculty_evaluation","@Saving09509972084","facultye_faculty_evaluation");
	$conn = mysqli_connect("localhost","root","","faculty_evaluation");
	if(!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	date_default_timezone_set('Asia/Manila');

	// get current date and time
    $date_today = date('Y-m-d');

    // get yesterday's date
	$yesterday_date = date('Y-m-d', strtotime('-1 day'));

?>