<?php 
	include '../config.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../vendor/PHPMailer/src/Exception.php';
    require '../vendor/PHPMailer/src/PHPMailer.php';
    require '../vendor/PHPMailer/src/SMTP.php';
    // require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/Exception.php';
    // require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/PHPMailer.php';
    // require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/SMTP.php';
	date_default_timezone_set('Asia/Manila');

	// Retrieve the values sent via AJAX
	$evaluated_by = $_POST['evaluated_by'];
	$userId = $_POST['user_Id'];
	$acad_Id = $_POST['acad_Id'];
	$inputName = $_POST['input_name'];
	$inputValue = $_POST['input_value'];

	// Prepare the SQL statement to check if a record exists for the user, section, and subject
	$stmt = $conn->prepare('SELECT * FROM evaluation_superior WHERE evaluated_by = ? AND user_Id = ? AND acad_Id = ?');
	$stmt->bind_param('sss', $evaluated_by, $userId, $acad_Id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
	    // Update the existing record
	    $updateStmt = $conn->prepare('UPDATE evaluation_superior SET ' . $inputName . ' = ? WHERE evaluated_by = ? AND user_Id = ? AND acad_Id = ?');
	    $updateStmt->bind_param('isss', $inputValue, $evaluated_by, $userId, $acad_Id);
	    $updateStmt->execute();

	    // Calculate and update the total values (A_Total, B_Total, C_Total, D_Total) and grand_total
	    $calculateTotalStmt = $conn->prepare('UPDATE evaluation_superior SET 
	    	A_Total = A1 + A2 + A3 + A4 + A5 + A6 + A7 + A8 + A9, 
	    	B_Total = B10 + B11 + B12 + B13 + B14 + B15 + B16 + B17, 
	    	grand_total = A_Total + B_Total, 
	    	date_evaluated = NOW() 
	    	WHERE evaluated_by = ? 
	    	AND user_Id = ? 
	    	AND acad_Id = ?');

	    $calculateTotalStmt->bind_param('sss', $evaluated_by, $userId, $acad_Id);
	    $calculateTotalStmt->execute();
	} else {
	    // Insert a new record
	    $insertStmt = $conn->prepare('INSERT INTO evaluation_superior (evaluated_by, acad_Id, user_Id,' . $inputName . ', A_Total, B_Total, grand_total, date_evaluated) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)');
	    $insertStmt->bind_param('ssisids', $evaluated_by, $acad_Id, $userId, $inputValue, $inputValue, $inputValue, $inputValue);
	    $insertStmt->execute();
	}

	// Close the database connection
	$conn->close();

	// Return a response to the AJAX request
	$response = array('success' => true);
	echo json_encode($response);





	

?>



