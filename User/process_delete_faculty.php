<?php 
	include '../config.php';


	// Retrieve the values sent via AJAX
	$evaluatedBy = $_POST['evaluated_by'];
	$userId = $_POST['user_Id'];
	$acadId = $_POST['acad_Id'];

	// Prepare the SQL statement to delete the record
	$stmt = $conn->prepare('DELETE FROM evaluation WHERE evaluated_by = ? AND user_Id = ? AND acad_Id = ?');
	$stmt->bind_param('sss', $evaluatedBy, $userId, $acadId);
	$stmt->execute();

	// Close the database connection
	$conn->close();

	// Return a response to the AJAX request
	$response = array('success' => true);
	echo json_encode($response);

?>




