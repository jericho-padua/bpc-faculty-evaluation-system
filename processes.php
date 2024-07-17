<?php 

	include 'config.php';

	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/PHPMailer/src/Exception.php';
    require 'vendor/PHPMailer/src/PHPMailer.php';
    require 'vendor/PHPMailer/src/SMTP.php';
    // require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/Exception.php';
    // require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/PHPMailer.php';
    // require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/SMTP.php';


	// USERS LOGIN - LOGIN.PHP
	if(isset($_POST['login'])) {
		$email       = $_POST['email'];
		$password    = md5($_POST['password']);

		// Check if the user has attempted to log in before
		if (!isset($_SESSION['login_attempts'])) {
		    $_SESSION['login_attempts'] = 0;
		}

		// Check if the user has reached the maximum number of login attempts
		if ($_SESSION['login_attempts'] > 3) {
		    // Check if the user has been blocked for 30 minutes
		    if (time() - $_SESSION['last_login_attempt'] <= 0) {
		        // User is still blocked, display an error message and exit
		        $_SESSION['message'] = "You have been blocked for 10 minutes due to multiple failed login attempts.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: index.php");
		        exit();
		    } else {
		        // Block has expired, reset the login attempts counter
		        $_SESSION['login_attempts'] = 0;
		    }
		}


		$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
		if(mysqli_num_rows($check)===1) {
			$row = mysqli_fetch_array($check);
			$user_type = $row['user_type'];
			$student_status = $row['student_status'];
			$status = $row['faculty_status'];
			
			if($user_type == 'Admin' || $user_type == 'Dean') {
			    if($status == 1) {
			        $_SESSION['login_attempts'] = 0;
    	    		$_SESSION['last_login_attempt'] = time();
    				$_SESSION['admin_Id'] = $row['user_Id'];
    				header("Location: Admin/dashboard.php");
	            } else {
    			    $_SESSION['login_attempts']++;
    			    $_SESSION['last_login_attempt'] = time();
    				$_SESSION['message'] = "Only verified accounts can login.";
    			    $_SESSION['text'] = "Please try again.";
    			    $_SESSION['status'] = "error";
    				header("Location: index.php");
			    }
				
			} elseif($user_type == 'Faculty') {
    			if($status == 0) {
        			$_SESSION['login_attempts'] = 0;
        			$_SESSION['last_login_attempt'] = time();
        			$_SESSION['user_Id'] = $row['user_Id'];
        			header("Location: User/dashboard.php");
    			} else {
        			$_SESSION['login_attempts']++;
        			$_SESSION['last_login_attempt'] = time();
        			$_SESSION['message'] = "Only verified accounts can login.";
        			$_SESSION['text'] = "Please try again.";
        			$_SESSION['status'] = "error";
        			header("Location: index.php");
    			}
			}
				elseif($user_type == 'Superior') {
    			if($status == 1) {
        			$_SESSION['login_attempts'] = 0;
        			$_SESSION['last_login_attempt'] = time();
        			$_SESSION['user_Id'] = $row['user_Id'];
        			header("Location: User/dashboard_superior.php");
    		} else {
        			$_SESSION['login_attempts']++;
       			 	$_SESSION['last_login_attempt'] = time();
        			$_SESSION['message'] = "Only verified accounts can login.";
        			$_SESSION['text'] = "Please try again.";
        			$_SESSION['status'] = "error";
        			header("Location: index.php");
    				}
			} else {
				if($student_status == 1) {
					$_SESSION['login_attempts'] = 0;
		    		$_SESSION['last_login_attempt'] = time();
					$_SESSION['user_Id'] = $row['user_Id'];
					header("Location: User/dashboard.php");
				} else {
					$_SESSION['login_attempts']++;
				    $_SESSION['last_login_attempt'] = time();
					$_SESSION['message'] = "Only verified accounts can login.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: index.php");
				}
			}
		
		} else {
		    $_SESSION['login_attempts']++;
		    $_SESSION['last_login_attempt'] = time();
			$_SESSION['message'] = "Incorrect password.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: index.php");
		}
	}




	// SAVE USERS - REGISTER.PHP
	if(isset($_POST['create_user'])) {

		$stud_type        = mysqli_real_escape_string($conn, $_POST['stud_type']);
		$student_ID       = "MA-" . mysqli_real_escape_string($conn, $_POST['student_ID']);
		$year_section     = mysqli_real_escape_string($conn, $_POST['year_section']);
		$department       = mysqli_real_escape_string($conn, $_POST['department']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		// $age              = mysqli_real_escape_string($conn, $_POST['age']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$password         = md5($_POST['password']);
		$file             = basename($_FILES["fileToUpload"]["name"]);
		$date_registered  = date('Y-m-d');

		$check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
		if(mysqli_num_rows($check_email)>0) {
		      $_SESSION['message'] = "Email already exists!";
		      $_SESSION['text'] = "Please try again.";
		      $_SESSION['status'] = "error";
			  header("Location: register.php");
		} else {

			$check_ID = mysqli_query($conn, "SELECT * FROM users WHERE student_ID='$student_ID' ");
			if(mysqli_num_rows($check_ID) > 0) {
				  $_SESSION['message'] = "Student ID already exists!";
			      $_SESSION['text'] = "Please try again.";
			      $_SESSION['status'] = "error";
				  header("Location: register.php");
			} else {
				// Check if image file is a actual image or fake image
			    $target_dir = "images-ID-verification/";
			    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			    $uploadOk = 1;
			    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


			    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check == false) {
				    $_SESSION['message']  = "File is not an image.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: register.php");
			    	$uploadOk = 0;
			    } 

				// Check file size // 500KB max size
				elseif ($_FILES["fileToUpload"]["size"] > 500000) {
				  	$_SESSION['message']  = "File must be up to 500KB in size.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: register.php");
			    	$uploadOk = 0;
				}

			    // Allow certain file formats
			    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: register.php");
				    $uploadOk = 0;
			    }

			    // Check if $uploadOk is set to 0 by an error
			    elseif ($uploadOk == 0) {
				    $_SESSION['message'] = "Your file was not uploaded.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: register.php");

			    // if everything is ok, try to upload file
			    } else {

		        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

	        		$save = mysqli_query($conn, "INSERT INTO users (stud_type, student_ID, year_section, department, firstname, middlename, lastname, suffix, dob, email, gender, ID_verification, password, date_registered) VALUES ('$stud_type', '$student_ID', '$year_section', '$department', '$firstname', '$middlename', '$lastname', '$suffix', '$dob', '$email', '$gender', '$file', '$password', '$date_registered')");

	              	  if($save) {
			          	$_SESSION['message'] = "Registration successful!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: login.php");
			          } else {
			            $_SESSION['message'] = "Something went wrong while saving the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: register.php");
			          }
		       			
		        } else {
		        	$_SESSION['message'] = "There was an error uploading your profile picture.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: register.php");
		        }
			  }
			}
		}
	}




	// SEARCH EMAIL - FORGOT-PASSWORD.PHP
	if(isset($_POST['search'])) {
	      $email = mysqli_real_escape_string($conn, $_POST['email']);
	      $fetch = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
	      if(mysqli_num_rows($fetch) > 0) {
	      	$row = mysqli_fetch_array($fetch);
	      	$user_Id = $row['user_Id'];
	      	header("Location: sendcode.php?user_Id=".$user_Id);
	      } else {
	      		$_SESSION['message'] = "Email does not exists in the database.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: forgot-password.php");
	      }
	}




	// SEND CODE - SENDCODE.PHP
	if(isset($_POST['sendcode'])) {

	    $email   = $_POST['email'];
	    $user_Id = $_POST['user_Id'];
	    $key     = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

	    $insert_code = mysqli_query($conn, "UPDATE users SET verification_code='$key' WHERE email='$email' AND user_Id='$user_Id'");
	    if($insert_code) {

	      $subject = 'Verification Code';
	      $message = '<p>Good day sir/maam '.$email.', your verification code is <b>'.$key.'</b>. Please do not share this code to other people. Thank you!</p>
	      <p>You can change your password by just clicking it <a href="http://localhost/evals/changepassword.php?user_Id='.$user_Id.'">here!</a></p> 
	      <p><b>NOTE:</b> This is a system generated email. Please do not reply.</p> ';

	      $mail = new PHPMailer(true);                            
	      try {
	        // Server settings
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

	        // Send Email
	        $mail->setFrom('ma20011120@bpc.edu.ph', 'BPC Faculty Evaluation System');

	        //Recipients
	        $mail->addAddress($email);              
	        $mail->addReplyTo('ma20011120@bpc.edu.ph');

	        //Content
	        $mail->isHTML(true);                                  
	        $mail->Subject = $subject;
	        $mail->Body    = $message;

	        $mail->send();

	        	$_SESSION['message'] = "Verification code has been sent to your email.";
			    $_SESSION['text'] = "Code has been sent";
			    $_SESSION['status'] = "success";
				header("Location: verifycode.php?user_Id=".$user_Id."&&email=".$email);

		  } catch (Exception $e) { 
		  	$_SESSION['message'] = "Email not sent.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: sendcode.php?user_Id=".$user_Id);
		  } 
		} else {
			$_SESSION['message'] = "Something went wrong while generating verification code through email.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: sendcode.php?user_Id=".$user_Id);
		} 
	}




	// VERIFY CODE - VERIFYCODE.PHP
	if(isset($_POST['verify_code'])) {
	    $user_Id = $_POST['user_Id'];
	    $email   = $_POST['email'];
	    $code    = mysqli_real_escape_string($conn, $_POST['code']);
	    $fetch = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND verification_code='$code' AND user_Id='$user_Id'");
	    if(mysqli_num_rows($fetch) > 0) {
			header("Location: changepassword.php?user_Id=".$user_Id);
		} else {
			$_SESSION['message'] = "Verification code is incorrect.";
		    $_SESSION['text'] = "Please try again.";
		    $_SESSION['status'] = "error";
			header("Location: verifycode.php?user_Id=".$user_Id."&&email=".$email);
		}
	}




	// CHANGE PASSWORD - CHANGEPASSWORD.PHP
	if(isset($_POST['changepassword'])) {
		$user_Id   = $_POST['user_Id'];
		$cpassword = md5($_POST['cpassword']);

		$update = mysqli_query($conn, "UPDATE users SET password='$cpassword' WHERE user_Id='$user_Id' ");
		if($update) {
			$_SESSION['message'] = "Password has been changed.";
		    $_SESSION['text'] = "Please login to your account";
		    $_SESSION['status'] = "success";
			header("Location: index.php");
		} else {
			$_SESSION['message'] = "Something went wrong while updating your password.";
		    $_SESSION['text'] = "Please try again";
		    $_SESSION['status'] = "error";
			header("Location: changepassword.php?user_Id=".$user_Id);
		}
	}



	// LOAD AUTOMATICALLY THE DEPARTMENT UPON SELECTING A YR LEVEL AND SECTION - REGISTER.PHP
	if (isset($_POST['section_id'])) {
	  $sectionId = $_POST['section_id'];

	  // Query to get the department based on the selected section
	  $query = "SELECT department FROM section WHERE section_Id = $sectionId";
	  $result = mysqli_query($conn, $query);

	  if ($result) {
	    $row = mysqli_fetch_assoc($result);
	    $department = $row['department'];

	    // Return the department as an option
	    echo '<option value="' . $department . '">' . $department . '</option>';
	  } else {
	    // Handle the case where no department is found
	    echo '<option value="">No department found</option>';
	  }
	}



?>
