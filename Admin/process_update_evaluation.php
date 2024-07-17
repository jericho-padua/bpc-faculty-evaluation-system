<?php
include '../config.php';

// Retrieve the input values from the AJAX request
$Id = $_POST['Id'];
$edited_by = $_POST['edited_by'];
$evaluated_by = $_POST['evaluated_by'];
$user_Id = $_POST['user_Id'];
$acad_Id = $_POST['acad_Id'];
$choices = $_POST['choices']; // Updated to handle choices array

// Debug statement
file_put_contents('debug.txt', print_r($choices, true));

// Process choices array and update the database
foreach ($choices as $choice) {
    $inputName = $choice['input_name'];
    $inputValue = $choice['input_value'];

    $updateStmt = $conn->prepare("UPDATE evaluation SET $inputName = ? WHERE Id = ?");
    $updateStmt->bind_param('ii', $inputValue, $Id);
    $updateStmt->execute();
}

// Debug statement
file_put_contents('debug.txt', 'Script executed successfully', FILE_APPEND);

// Calculate and update the total values (A_Total, B_Total, C_Total, D_Total) and grand_total
$calculateTotalStmt = $conn->prepare('UPDATE evaluation SET 
	A_Total = A1 + A2 + A3 + A4 + A5, 
	B_Total = B1 + B2 + B3 + B4 + B5, 
	C_Total = C1 + C2 + C3 + C4 + C5, 
	D_Total = D1 + D2 + D3 + D4 + D5, 
	grand_total = A_Total + B_Total + C_Total + D_Total, 
	date_evaluated = NOW() 
	WHERE Id = ?');

$calculateTotalStmt->bind_param('i', $Id);
$calculateTotalStmt->execute();

// Close the database connection
$conn->close();

// Return a response to the AJAX request
$response = array('success' => true);
echo json_encode($response);





// WORKING FOR UPDATING USING THE PROCESS SAVE IN ONCLICK FOR INPUT ELEMENTS
// Retrieve the input values from the AJAX request
// $Id = $_POST['Id'];
// $edited_by = $_POST['edited_by'];
// $evaluated_by = $_POST['evaluated_by'];
// $user_Id = $_POST['user_Id'];
// $acad_Id = $_POST['acad_Id'];
// $inputName = $_POST['input_name'];
// $inputValue = $_POST['input_value'];



// // Prepare the SQL statement to check if a record exists for the user, section, and subject
// $stmt = $conn->prepare('SELECT * FROM evaluation WHERE Id = ?');
// $stmt->bind_param('i', $Id);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     // Update the existing record
//     $updateStmt = $conn->prepare('UPDATE evaluation SET ' . $inputName . ' = ? WHERE Id = ?');
//     $updateStmt->bind_param('si', $inputValue, $Id);
//     $updateStmt->execute();

//     // Calculate and update the total values (A_Total, B_Total, C_Total, D_Total) and grand_total
//     $calculateTotalStmt = $conn->prepare('UPDATE evaluation SET 
// 	    	A_Total = A1 + A2 + A3 + A4 + A5, 
// 	    	B_Total = B1 + B2 + B3 + B4 + B5, 
// 	    	C_Total = C1 + C2 + C3 + C4 + C5, 
// 	    	D_Total = D1 + D2 + D3 + D4 + D5, 
// 	    	grand_total = A_Total + B_Total + C_Total + D_Total, 
// 	    	date_evaluated = NOW() 
// 	    	WHERE Id = ?');

//     $calculateTotalStmt->bind_param('i', $Id);
//     $calculateTotalStmt->execute();
// } else {
//     // Insert a new record
//     $insertStmt = $conn->prepare('INSERT INTO evaluation (evaluated_by, acad_Id, user_Id,' . $inputName . ', A_Total, B_Total, grand_total, date_evaluated) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)');
//     $insertStmt->bind_param('ssisids', $evaluated_by, $acad_Id, $user_Id, $inputValue, $inputValue, $inputValue, $inputValue);
//     $insertStmt->execute();
// }

// // Close the database connection
// $conn->close();

// // Return a response to the AJAX request
// $response = array('success' => true);
// echo json_encode($response);
