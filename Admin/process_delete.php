<?php 
	include '../config.php';
	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/Exception.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/PHPMailer.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/SMTP.php';

	function msg_success($page) {
		$_SESSION['message'] = "Record has been deleted!";
        $_SESSION['text']    = "Deleted successfully!";
        $_SESSION['status']  = "success";
		header("Location: $page");
		exit();
	}


	function msg_failed($page) {
	    $_SESSION['message'] = "Something went wrong while deleting the record";
        $_SESSION['text'] = "Please try again.";
        $_SESSION['status'] = "error";
		header("Location: $page");
		exit();
	}


	// DELETE ADMIN - ADMIN_DELETE.PHP
	if(isset($_POST['delete_admin'])) {
		$user_Id = $_POST['user_Id'];

		$delete = mysqli_query($conn, "DELETE FROM users WHERE user_Id='$user_Id'");
		if($delete) {
			msg_success("academic_mgmt.php?page=create");
		} else {
			msg_failed("admin.php");
        }
	}


	// DELETE USER - USERS_DELETE.PHP
	if(isset($_POST['delete_user'])) {
		$user_Id = $_POST['user_Id'];
		$sql = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id' ");
		$row = mysqli_fetch_array($sql);
		$email = $row['email'];
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];


		$delete = mysqli_query($conn, "UPDATE users SET student_status=2 WHERE user_Id='$user_Id'");
		if($delete) {

		  $subject = 'Account denied';
	      $message = '<p>Good day sir/maam '.$name.', this is to inform you that your account has been denied. Thank you!</p>
	      <p><b>NOTE:</b> This is a system generated email. Please do not reply.</p> ';

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

	        $_SESSION['message'] = "Student account has been denied";
	       	    $_SESSION['text'] = "Verified successfully!";
		        $_SESSION['status'] = "success";
				header("Location: users.php");

		  } catch (Exception $e) { 
		  	$_SESSION['message'] = "Email not sent.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: users.php");
		  }
			
		} else {
			msg_failed("users.php");
        }
	}
	


	// DELETE FACULTY - FACULTY_DELETE.PHP
	if(isset($_POST['delete_faculty'])) {
		$user_Id = $_POST['user_Id'];

		$delete = mysqli_query($conn, "UPDATE users SET is_deleted=1 WHERE user_Id='$user_Id'");
		if($delete) {
			msg_success("faculty.php");
		} else {
			msg_failed("faculty.php");
        }
	}

// DELETE SUPERIOR - SUPERIOR_DELETE.PHP
	if(isset($_POST['delete_superior'])) {
		$user_Id = $_POST['user_Id'];

		$delete = mysqli_query($conn, "UPDATE users SET is_deleted=1 WHERE user_Id='$user_Id'");
		if($delete) {
			msg_success("superior.php");
		} else {
			msg_failed("superior.php");
        }
	}



	// DELETE SUPERVISOR - SUPERVISOR_DELETE.PHP
	if(isset($_POST['delete_supervisor'])) {
		$user_Id = $_POST['user_Id'];

		$delete = mysqli_query($conn, "DELETE FROM users WHERE user_Id='$user_Id'");
		if($delete) {
			msg_success("supervisor.php");
		} else {
			msg_failed("supervisor.php");
        }
	}




	// DELETE SUPERVISORS - SUPERVISORS_DELETE.PHP
	if(isset($_POST['delete_academic_year'])) {
		$acad_Id = $_POST['acad_Id'];

		$delete = mysqli_query($conn, "DELETE FROM academic_year WHERE acad_Id='$acad_Id'");
		if($delete) {
			msg_success("academic.php");
		} else {
			msg_failed("academic.php");
        }
	}



	// DELETE SUBJECT - SUBJECT_DELETE.PHP
	if(isset($_POST['delete_subject'])) {
		$sub_Id = $_POST['sub_Id'];

		$delete = mysqli_query($conn, "DELETE FROM subject WHERE sub_Id='$sub_Id'");
		if($delete) {
		   msg_success("subject.php");
        } else {
		   msg_failed("subject.php");
        }
	}



	// DELETE SeCTION - SeCTION_DELETE.PHP
	if(isset($_POST['delete_section'])) {
		$section_Id = $_POST['section_Id'];

		$delete = mysqli_query($conn, "DELETE FROM section WHERE section_Id='$section_Id'");
		if($delete) {
		   msg_success("section.php");
        } else {
		   msg_failed("section.php");
        }
	}

	


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




