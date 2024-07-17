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

	//EVALUATION TEACHERS
	if(isset($_POST['evaluation'])) {
		$section_Id = mysqli_real_escape_string($conn, $_POST['section_Id']);
		$subject_Id = mysqli_real_escape_string($conn, $_POST['subject_Id']);
		$user_Id    = mysqli_real_escape_string($conn, $_POST['user_Id']);

		header("Location: evaluate.php?section_Id=".$section_Id."&&subject_Id=".$subject_Id."&&user_Id=".$user_Id." ");
	}

	//EVALUATION TEACHERS
	if(isset($_POST['evaluation_faculty'])) {
		$evaluated_by = mysqli_real_escape_string($conn, $_POST['evaluated_by']);
		$user_Id      = mysqli_real_escape_string($conn, $_POST['user_Id']);

		header("Location: evaluate_by_faculty.php?evaluated_by=".$evaluated_by."&&user_Id=".$user_Id." ");
	}

		//EVALUATION TEACHERS (STUDENT COMMENTS)
	if(isset($_POST['evaluation_comment'])) {
		$section_Id = mysqli_real_escape_string($conn, $_POST['section_Id']);
		$subject_Id = mysqli_real_escape_string($conn, $_POST['subject_Id']);
		$user_Id    = mysqli_real_escape_string($conn, $_POST['user_Id']);

		header("Location: evaluate_comments.php?section_Id=".$section_Id."&&subject_Id=".$subject_Id."&&user_Id=".$user_Id." ");

	}


if (isset($_POST['com'])) {
    $evaluated_by = mysqli_real_escape_string($conn, $_POST['evaluated_by']);
    $section_Id = mysqli_real_escape_string($conn, $_POST['section_Id']);
    $subject_Id = mysqli_real_escape_string($conn, $_POST['subject_Id']);
    $user_Id = mysqli_real_escape_string($conn, $_POST['user_Id']);
    $acad_Id = mysqli_real_escape_string($conn, $_POST['acad_Id']);
    $com = mysqli_real_escape_string($conn, $_POST['com']);

    // Check if the comment already exists for this evaluation
    $checkQuery = "SELECT * FROM comment 
                   WHERE evaluated_by='$evaluated_by' 
                   AND user_Id='$user_Id' 
                   AND section_Id='$section_Id' 
                   AND subject_Id='$subject_Id'
                   AND acad_Id='$acad_Id'
                   AND com='$com'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "Comment already exists for this evaluation";
    } else {
        // Insert new comment
        $insertQuery = "INSERT INTO comment (evaluated_by, section_Id, subject_Id, user_Id, acad_Id, com) 
                        VALUES ('$evaluated_by', '$section_Id', '$subject_Id', '$user_Id', '$acad_Id', '$com')";
        if (mysqli_query($conn, $insertQuery)) {
            echo "Comment saved successfully!";
        } else {
            echo "Error inserting comment: " . mysqli_error($conn);
        }
    }
}



	// Retrieve the values sent via AJAX
	$evaluated_by = $_POST['evaluated_by'];
	$sectionId = $_POST['section_Id'];
	$subjectId = $_POST['subject_Id'];
	$userId = $_POST['user_Id'];
	$acad_Id = $_POST['acad_Id'];
	$inputName = $_POST['input_name'];
	$inputValue = $_POST['input_value'];
	//$com = $_POST['com'];

	// Prepare the SQL statement to check if a record exists for the user, section, and subject
	$stmt = $conn->prepare('SELECT * FROM evaluation WHERE evaluated_by = ? AND user_Id = ? AND section_Id = ? AND subject_Id = ? AND acad_Id = ?');
	$stmt->bind_param('sssss', $evaluated_by, $userId, $sectionId, $subjectId, $acad_Id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
	    // Update the existing record
	    $updateStmt = $conn->prepare('UPDATE evaluation SET ' . $inputName . ' = ? WHERE evaluated_by = ? AND user_Id = ? AND section_Id = ? AND subject_Id = ? AND acad_Id = ?');
	    $updateStmt->bind_param('isssss', $inputValue, $evaluated_by, $userId, $sectionId, $subjectId, $acad_Id);
	    $updateStmt->execute();

	    // Calculate and update the total values (A_Total, B_Total, C_Total, D_Total) and grand_total
	    $calculateTotalStmt = $conn->prepare('UPDATE evaluation SET 
	    	A_Total = A1 + A2 + A3 + A4 + A5, 
	    	B_Total = B1 + B2 + B3 + B4 + B5, 
	    	C_Total = C1 + C2 + C3 + C4 + C5, 
	    	D_Total = D1 + D2 + D3 + D4 + D5, 
	    	grand_total = A_Total + B_Total + C_Total + D_Total, 
	    	date_evaluated = NOW() 
	    	WHERE evaluated_by = ? 
	    	AND user_Id = ? 
	    	AND section_Id = ? 
	    	AND subject_Id = ? 
	    	AND acad_Id = ?');

	    $calculateTotalStmt->bind_param('sssss', $evaluated_by, $userId, $sectionId, $subjectId, $acad_Id);
	    $calculateTotalStmt->execute();
	} else {
	    // Insert a new record
	    $insertStmt = $conn->prepare('INSERT INTO evaluation (evaluated_by, acad_Id, user_Id, section_Id, subject_Id, ' . $inputName . ', A_Total, B_Total, grand_total, date_evaluated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)');
	    $insertStmt->bind_param('ssssisids', $evaluated_by, $acad_Id, $userId, $sectionId, $subjectId, $inputValue, $inputValue, $inputValue, $inputValue);
	    $insertStmt->execute();
	}

	// Close the database connection
	$conn->close();

	// Return a response to the AJAX request
	$response = array('success' => true);
	echo json_encode($response);







	// CONTACT EMAIL MESSAGING - CONTACT-US.PHP
	if(isset($_POST['sendEmail'])) {

		$name    = mysqli_real_escape_string($conn, $_POST['name']);
		$email	 = mysqli_real_escape_string($conn, $_POST['email']);
		$subject = mysqli_real_escape_string($conn, $_POST['subject']);
		$msg     = mysqli_real_escape_string($conn, $_POST['message']);

	    $message = '<h3>'.$subject.'</h3>
					<p>
						Good day!<br>
						'.$msg.'
					</p>
					<p>
						Name of Sender: '.$name.'<br>
						Email: '.$email.'
					</p>
					<p><b>Note:</b> This is a system generated email please do not reply.</p>';
					//Load composer's autoloader

			    $mail = new PHPMailer(true);                            
			    try {
			        //Server settings
        	        $mail->isSMTP();                                     
        	        $mail->Host = 'smtp.gmail.com';                      
        	        $mail->SMTPAuth = true;                             
        	        $mail->Username = 'ma20011120@bpc.edu.ph';     
        	        $mail->Password = 'ywhp tosl spqt fylw';              
        	        $mail->SMTPOptions = array(
        	        'ssl' => array(
        	        'verify_peer' => false,
        	        'verify_peer_name' => false,
        	        'allow_self_signed' => true
        	        )
        	        );                         
        	        $mail->SMTPSecure = 'ssl';                           
        	        $mail->Port = 465;                                   
        
        	        //Send Email
        	        $mail->setFrom('ma20011120@bpc.edu.ph', 'BPC Faculty Evaluation System');
    	            
        
        	        //Recipients
        	        $mail->addAddress($email);              
        	        $mail->addReplyTo('ma20011120@bpc.edu.ph');
        
        	        //Content
        	        $mail->isHTML(true);                                  
        	        $mail->Subject = $subject;
        	        $mail->Body    = $message;
        
        	        $mail->send();
					$_SESSION['success'] = "Email sent successfully!";
					header("Location: contact-us.php");

			    } catch (Exception $e) {
			    	$_SESSION['success'] = "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;
					header("Location: contact-us.php");
			    }
    }
	

?>



