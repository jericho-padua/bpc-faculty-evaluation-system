<?php 
	include '../config.php';


    // Retrieve the input values from the AJAX request
	$evaluatedBy = $_POST['evaluated_by'];
	$userId = $_POST['user_Id'];
	$acadId = $_POST['acad_Id'];


	// Update the evaluation_status
	$sql = "UPDATE evaluation SET evaluation_status = 1 WHERE evaluated_by = ? AND user_Id = ? AND acad_Id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("iii", $evaluatedBy, $userId, $acadId);

	if ($stmt->execute()) {
	  echo "Evaluation status updated successfully";
	} else {
	  echo "Error updating evaluation status: " . $stmt->error;
	}

	$stmt->close();
	$conn->close();




?>
