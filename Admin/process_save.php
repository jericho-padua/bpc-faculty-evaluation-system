<?php 
	include '../config.php';
	// include('../phpqrcode/qrlib.php');
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/Exception.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/PHPMailer.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/src/SMTP.php';


	// SAVE ADMIN - ADMIN_MGMT.PHP
	if(isset($_POST['create_admin'])) {
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		$age              = mysqli_real_escape_string($conn, $_POST['age']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$password         = md5($_POST['password']);
		$user_type        = 'Admin';
		$file             = basename($_FILES["fileToUpload"]["name"]);
		$date_registered  = date('Y-m-d');

		$check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
		if(mysqli_num_rows($check_email)>0) {
		      $_SESSION['message'] = "Email already exists!";
		      $_SESSION['text'] = "Please try again.";
		      $_SESSION['status'] = "error";
			  header("Location: admin_mgmt.php?page=create");
		} else {

			// Check if image file is a actual image or fake image
		    $target_dir = "../images-users/";
		    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		    $uploadOk = 1;
		    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check == false) {
			    $_SESSION['message']  = "File is not an image.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: admin_mgmt.php?page=create");
		    	$uploadOk = 0;
		    } 

			// Check file size // 500KB max size
			elseif ($_FILES["fileToUpload"]["size"] > 500000) {
			  	$_SESSION['message']  = "File must be up to 500KB in size.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: admin_mgmt.php?page=create");
		    	$uploadOk = 0;
			}

		    // Allow certain file formats
		    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: admin_mgmt.php?page=create");
			    $uploadOk = 0;
		    }

		    // Check if $uploadOk is set to 0 by an error
		    elseif ($uploadOk == 0) {
			    $_SESSION['message'] = "Your file was not uploaded.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: admin_mgmt.php?page=create");

		    // if everything is ok, try to upload file
		    } else {

	        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        		$save = mysqli_query($conn, "INSERT INTO users (firstname, middlename, lastname, suffix, dob, age, email, gender, image, password, user_type, date_registered) VALUES ('$firstname', '$middlename', '$lastname', '$suffix', '$dob', '$age', '$email', '$gender', '$file', '$password', '$user_type', '$date_registered')");

              	  if($save) {
		          	$_SESSION['message'] = "Record has been saved!";
		            $_SESSION['text'] = "Saved successfully!";
			        $_SESSION['status'] = "success";
					header("Location: admin_mgmt.php?page=create");
		          } else {
		            $_SESSION['message'] = "Something went wrong while saving the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: admin_mgmt.php?page=create");
		          }
	       			
	        } else {
	        	$_SESSION['message'] = "There was an error uploading your profile picture.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: admin_mgmt.php?page=create");
	        }
		  }
		}
	}




	// SAVE USERS - USERS_MGMT.PHP
	if(isset($_POST['create_user'])) {

		$stud_type        = mysqli_real_escape_string($conn, $_POST['stud_type']);
		$student_ID       = mysqli_real_escape_string($conn, $_POST['student_ID']);
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
			  header("Location: users_mgmt.php?page=create");
		} else {

			$check_ID = mysqli_query($conn, "SELECT * FROM users WHERE student_ID='$student_ID' ");
			if(mysqli_num_rows($check_ID) > 0) {
				  $_SESSION['message'] = "Student ID already exists!";
			      $_SESSION['text'] = "Please try again.";
			      $_SESSION['status'] = "error";
				  header("Location: users_mgmt.php?page=create");
			} else {
				// Check if image file is a actual image or fake image
			    $target_dir = "../images-ID-verification/";
			    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			    $uploadOk = 1;
			    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


			    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check == false) {
				    $_SESSION['message']  = "File is not an image.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: users_mgmt.php?page=create");
			    	$uploadOk = 0;
			    } 

				// Check file size // 500KB max size
				elseif ($_FILES["fileToUpload"]["size"] > 500000) {
				  	$_SESSION['message']  = "File must be up to 500KB in size.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: users_mgmt.php?page=create");
			    	$uploadOk = 0;
				}

			    // Allow certain file formats
			    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: users_mgmt.php?page=create");
				    $uploadOk = 0;
			    }

			    // Check if $uploadOk is set to 0 by an error
			    elseif ($uploadOk == 0) {
				    $_SESSION['message'] = "Your file was not uploaded.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: users_mgmt.php?page=create");

			    // if everything is ok, try to upload file
			    } else {

		        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

	        		$save = mysqli_query($conn, "INSERT INTO users (stud_type, student_ID, year_section, department, firstname, middlename, lastname, suffix, dob, email, gender, ID_verification, password, date_registered) VALUES ('$stud_type', '$student_ID', '$year_section', '$department', '$firstname', '$middlename', '$lastname', '$suffix', '$dob', '$email', '$gender', '$file', '$password', '$date_registered')");

	              	  if($save) {
			          	$_SESSION['message'] = "Record has been saved!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: users_mgmt.php?page=create");
			          } else {
			            $_SESSION['message'] = "Something went wrong while saving the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: users_mgmt.php?page=create");
			          }
		       			
		        } else {
		        	$_SESSION['message'] = "There was an error uploading your profile picture.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: users_mgmt.php?page=create");
		        }
			  }
			}
		}
	}


	// SAVE SUPERIOR - SUPERIOR_MGMT.PHP
	if(isset($_POST['create_superior'])) {
		//$department       = mysqli_real_escape_string($conn, $_POST['department']);
		//$acad_rank        = mysqli_real_escape_string($conn, $_POST['acad_rank']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		// $age              = mysqli_real_escape_string($conn, $_POST['age']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$password         = md5($_POST['password']);
		$user_type        = 'Superior';
		$file             = basename($_FILES["fileToUpload"]["name"]);
		$date_registered  = date('Y-m-d');

		$check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
		if(mysqli_num_rows($check_email)>0) {
		      $_SESSION['message'] = "Email already exists!";
		      $_SESSION['text'] = "Please try again.";
		      $_SESSION['status'] = "error";
			  header("Location: superior_mgmt.php?page=create");
		} else {

			// Check if image file is a actual image or fake image
		    $target_dir = "../images-users/";
		    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		    $uploadOk = 1;
		    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check == false) {
			    $_SESSION['message']  = "File is not an image.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: superior_mgmt.php?page=create");
		    	$uploadOk = 0;
		    } 

			// Check file size // 500KB max size
			elseif ($_FILES["fileToUpload"]["size"] > 500000) {
			  	$_SESSION['message']  = "File must be up to 500KB in size.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: superior_mgmt.php?page=create");
		    	$uploadOk = 0;
			}

		    // Allow certain file formats
		    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: superior_mgmt.php?page=create");
			    $uploadOk = 0;
		    }

		    // Check if $uploadOk is set to 0 by an error
		    elseif ($uploadOk == 0) {
			    $_SESSION['message'] = "Your file was not uploaded.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: superior_mgmt.php?page=create");

		    // if everything is ok, try to upload file
		    } else {

	        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        		$save = mysqli_query($conn, "INSERT INTO users (firstname, middlename, lastname, suffix, dob, email, gender, image, password, user_type, student_status, date_registered) VALUES ('$firstname', '$middlename', '$lastname', '$suffix', '$dob', '$email', '$gender', '$file', '$password', '$user_type', 1, '$date_registered')");

              	  if($save) {
              	  	  $name = $firstname.' '.$middlename.' '.$lastname.' '.$suffix;
          	  		  $subject = 'Account registered';
				      $message = '<p>Good day sir/maam '.$name.', this is to inform you that you have been registered as '.$user_type.'. Thank you!</p>
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

				        	$_SESSION['message'] = "Record has been saved!";
				            $_SESSION['text'] = "Saved successfully!";
					        $_SESSION['status'] = "success";
							header("Location: superior_mgmt.php?page=create");

					  } catch (Exception $e) { 
					  	$_SESSION['message'] = "Email not sent.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: superior_mgmt.php?page=create");
					  }
		          	


		          } else {
		            $_SESSION['message'] = "Something went wrong while saving the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: superior_mgmt.php?page=create");
		          }
	       			
	        } else {
	        	$_SESSION['message'] = "There was an error uploading your profile picture.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: superior_mgmt.php?page=create");
	        }
		  }
		}
	}




	// SAVE FACULTY - FACULTY_MGMT.PHP
	if(isset($_POST['create_faculty'])) {
		//$department       = mysqli_real_escape_string($conn, $_POST['department']);
		//$acad_rank        = mysqli_real_escape_string($conn, $_POST['acad_rank']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		// $age              = mysqli_real_escape_string($conn, $_POST['age']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$password         = md5($_POST['password']);
		$user_type        = 'Faculty';
		$file             = basename($_FILES["fileToUpload"]["name"]);
		$date_registered  = date('Y-m-d');

		$check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
		if(mysqli_num_rows($check_email)>0) {
		      $_SESSION['message'] = "Email already exists!";
		      $_SESSION['text'] = "Please try again.";
		      $_SESSION['status'] = "error";
			  header("Location: faculty_mgmt.php?page=create");
		} else {

			// Check if image file is a actual image or fake image
		    $target_dir = "../images-users/";
		    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		    $uploadOk = 1;
		    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check == false) {
			    $_SESSION['message']  = "File is not an image.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: faculty_mgmt.php?page=create");
		    	$uploadOk = 0;
		    } 

			// Check file size // 500KB max size
			elseif ($_FILES["fileToUpload"]["size"] > 500000) {
			  	$_SESSION['message']  = "File must be up to 500KB in size.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: faculty_mgmt.php?page=create");
		    	$uploadOk = 0;
			}

		    // Allow certain file formats
		    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: faculty_mgmt.php?page=create");
			    $uploadOk = 0;
		    }

		    // Check if $uploadOk is set to 0 by an error
		    elseif ($uploadOk == 0) {
			    $_SESSION['message'] = "Your file was not uploaded.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: faculty_mgmt.php?page=create");

		    // if everything is ok, try to upload file
		    } else {

	        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        		$save = mysqli_query($conn, "INSERT INTO users (firstname, middlename, lastname, suffix, dob, email, gender, image, password, user_type, student_status, date_registered) VALUES ('$firstname', '$middlename', '$lastname', '$suffix', '$dob', '$email', '$gender', '$file', '$password', '$user_type', 1, '$date_registered')");

              	  if($save) {
              	  	  $name = $firstname.' '.$middlename.' '.$lastname.' '.$suffix;
          	  		  $subject = 'Account registered';
				      $message = '<p>Good day sir/maam '.$name.', this is to inform you that you have been registered as '.$user_type.'. Thank you!</p>
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

				        	$_SESSION['message'] = "Record has been saved!";
				            $_SESSION['text'] = "Saved successfully!";
					        $_SESSION['status'] = "success";
							header("Location: faculty_mgmt.php?page=create");

					  } catch (Exception $e) { 
					  	$_SESSION['message'] = "Email not sent.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: faculty_mgmt.php?page=create");
					  }
		          	


		          } else {
		            $_SESSION['message'] = "Something went wrong while saving the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: faculty_mgmt.php?page=create");
		          }
	       			
	        } else {
	        	$_SESSION['message'] = "There was an error uploading your profile picture.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: faculty_mgmt.php?page=create");
	        }
		  }
		}
	}






	// SAVE SUPERVISOR - SUPERVISOR_MGMT.PHP
	if(isset($_POST['create_dean'])) {
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		// $age              = mysqli_real_escape_string($conn, $_POST['age']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$password         = md5($_POST['password']);
		$user_type        = 'Dean';
		$file             = basename($_FILES["fileToUpload"]["name"]);
		$date_registered  = date('Y-m-d');

		$check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
		if(mysqli_num_rows($check_email)>0) {
		      $_SESSION['message'] = "Email already exists!";
		      $_SESSION['text'] = "Please try again.";
		      $_SESSION['status'] = "error";
			  header("Location: dean_mgmt.php?page=create");
		} else {

			// Check if image file is a actual image or fake image
		    $target_dir = "../images-users/";
		    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		    $uploadOk = 1;
		    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check == false) {
			    $_SESSION['message']  = "File is not an image.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: dean_mgmt.php?page=create");
		    	$uploadOk = 0;
		    } 

			// Check file size // 500KB max size
			elseif ($_FILES["fileToUpload"]["size"] > 500000) {
			  	$_SESSION['message']  = "File must be up to 500KB in size.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: dean_mgmt.php?page=create");
		    	$uploadOk = 0;
			}

		    // Allow certain file formats
		    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: dean_mgmt.php?page=create");
			    $uploadOk = 0;
		    }

		    // Check if $uploadOk is set to 0 by an error
		    elseif ($uploadOk == 0) {
			    $_SESSION['message'] = "Your file was not uploaded.";
			    $_SESSION['text'] = "Please try again.";
			    $_SESSION['status'] = "error";
				header("Location: dean_mgmt.php?page=create");

		    // if everything is ok, try to upload file
		    } else {

	        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        		$save = mysqli_query($conn, "INSERT INTO users (firstname, middlename, lastname, suffix, dob, email, gender, image, password, user_type, student_status, date_registered) VALUES ('$firstname', '$middlename', '$lastname', '$suffix', '$dob', '$email', '$gender', '$file', '$password', '$user_type', 1, '$date_registered')");

              	  if($save) {

              	  		  $name = $firstname.' '.$middlename.' '.$lastname.' '.$suffix;
	          	  		  $subject = 'Account registered';
					      $message = '<p>Good day sir/maam '.$name.', this is to inform you that you have been registered as '.$user_type.'. Thank you!</p>
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
                	        $mail->addAddress('$email');              
                	        $mail->addReplyTo('ma20011120@bpc.edu.ph');
                
                	        //Content
                	        $mail->isHTML(true);                                  
                	        $mail->Subject = $subject;
                	        $mail->Body    = $message;
                
                	        $mail->send();

					        	$_SESSION['message'] = "Record has been saved!";
					            $_SESSION['text'] = "Saved successfully!";
						        $_SESSION['status'] = "success";
								header("Location: dean_mgmt.php?page=create");

						  } catch (Exception $e) { 
						  	$_SESSION['message'] = "Email not sent.";
						    $_SESSION['text'] = "Please try again.";
						    $_SESSION['status'] = "error";
							header("Location: dean_mgmt.php?page=create");
						  }

		          	
		          } else {
		            $_SESSION['message'] = "Something went wrong while saving the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: dean_mgmt.php?page=create");
		          }
	       			
	        } else {
	        	$_SESSION['message'] = "There was an error uploading your profile picture.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: dean_mgmt.php?page=create");
	        }
		  }
		}
	}






	// SAVE ACADEMIC YEAR - ACADEMIC_MGMT.PHP
	if(isset($_POST['create_academic_year'])) {
		$year1    = mysqli_real_escape_string($conn, $_POST['year1']);
		$year2    = mysqli_real_escape_string($conn, $_POST['year2']);
		$semester = mysqli_real_escape_string($conn, $_POST['semester']);

		$acad     = $year1.'-'.$year2;
		$date_created  = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM academic_year WHERE year='$acad' AND semester='$semester'");
		if(mysqli_num_rows($fetch) > 0) {
			$_SESSION['message'] = "Academic Year with semester, ".$semester." already exists.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: academic_mgmt.php?page=create");
		} else {
			$save = mysqli_query($conn, "INSERT INTO academic_year (year, semester, date_created) VALUES ('$acad', '$semester', '$date_created')");

          	  if($save) {
	          	$_SESSION['message'] = "Record has been saved!";
	            $_SESSION['text'] = "Saved successfully!";
		        $_SESSION['status'] = "success";
				header("Location: academic_mgmt.php?page=create");
	          } else {
	            $_SESSION['message'] = "Something went wrong while saving the information.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: academic_mgmt.php?page=create");
	          }
		}
	}

	// SAVE SUBJECT - SUBJECT_MGMT.PHP
	if(isset($_POST['create_subject'])) {
		$name          = mysqli_real_escape_string($conn, $_POST['name']);
		$code          = mysqli_real_escape_string($conn, strtoupper($_POST['code']));
		$units         = mysqli_real_escape_string($conn, $_POST['units']);
		$instructor_Id = mysqli_real_escape_string($conn, $_POST['instructor_Id']);
		$section_Id    = mysqli_real_escape_string($conn, $_POST['section_Id']);
		$date_created  = date('Y-m-d');

		// GET ACTIVE YEAR FOR EVALUATION
        $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
        if(mysqli_num_rows($active) > 0) {
    	    $row = mysqli_fetch_array($active);
        	$acad_Id = $row['acad_Id'];
       
			$fetch = mysqli_query($conn, "SELECT * FROM subject WHERE name='$name' AND code='$code' AND units='$units' AND section_Id='$section_Id' AND instructor_Id='$instructor_Id' AND acad_Id='$acad_Id' ");
			if(mysqli_num_rows($fetch) > 0) {
				$_SESSION['message'] = "Record already exists.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: subject_mgmt.php?page=create");
			} else {
			$fetch = mysqli_query($conn, "SELECT * FROM subject WHERE name='$name' AND section_Id='$section_Id' AND acad_Id='$acad_Id'");
				if(mysqli_num_rows($fetch) > 0) {
					$_SESSION['message'] = "Duplication of subject in the same section.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: subject_mgmt.php?page=create");
			} else {
    			$fetch = mysqli_query($conn, "SELECT * FROM subject WHERE code='$code' AND section_Id='$section_Id' AND acad_Id='$acad_Id'");
    
    			if(mysqli_num_rows($fetch) > 0) {
        			$_SESSION['message'] = "Subject code for this section already exists.";
        			$_SESSION['text'] = "Please try again with a different subject code or section.";
        			$_SESSION['status'] = "error";
        			header("Location: subject_mgmt.php?page=create");					 } else {
						$save = mysqli_query($conn, "INSERT INTO subject (name, code, units, instructor_Id, section_Id, acad_Id, date_created) VALUES ('$name', '$code', '$units', '$instructor_Id', '$section_Id', '$acad_Id', '$date_created')");

			          	  if($save) {
				          	$_SESSION['message'] = "Record has been saved!";
				            $_SESSION['text'] = "Saved successfully!";
					        $_SESSION['status'] = "success";
							header("Location: subject_mgmt.php?page=create");
				          } else {
				            $_SESSION['message'] = "Something went wrong while saving the information.";
				            $_SESSION['text'] = "Please try again.";
					        $_SESSION['status'] = "error";
							header("Location: subject_mgmt.php?page=create");
				          }
					 }
				}
			}

	 	} else {
	 		$_SESSION['message'] = "You should have set academic year active first.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: subject_mgmt.php?page=create");
        }
	}










	// SAVE SECTION - SECTION_MGMT.PHP
	if(isset($_POST['create_section'])) {
		$yr_level     = mysqli_real_escape_string($conn, $_POST['yr_level']);
		$section      = mysqli_real_escape_string($conn, $_POST['section']);
		$department   = mysqli_real_escape_string($conn, $_POST['department']);
		$date_created = date('Y-m-d');

		$fetch = mysqli_query($conn, "SELECT * FROM section WHERE yr_level='$yr_level' AND section='$section' AND department='$department' ");
		if(mysqli_num_rows($fetch) > 0) {
			$_SESSION['message'] = " ".$yr_level." with section, ".$section." and department, ".$department." already exists.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: section_mgmt.php?page=create");
		} else {
			$save = mysqli_query($conn, "INSERT INTO section (yr_level, section, department, date_created) VALUES ('$yr_level', '$section', '$department', '$date_created')");

          	  if($save) {
	          	$_SESSION['message'] = "Record has been saved!";
	            $_SESSION['text'] = "Saved successfully!";
		        $_SESSION['status'] = "success";
				header("Location: section_mgmt.php?page=create");
	          } else {
	            $_SESSION['message'] = "Something went wrong while saving the information.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: section_mgmt.php?page=create");
	          }
		}
	}








// 	if(isset($_POST['evaluation_dean'])) {
// 		$evaluated_by = mysqli_real_escape_string($conn, $_POST['evaluated_by']);
// 		$user_Id    = mysqli_real_escape_string($conn, $_POST['user_Id']);

// 		header("Location: evaluate_dean.php?evaluated_by=".$evaluated_by."&&user_Id=".$user_Id." ");
// 	}
	
	if (isset($_POST['evaluation_dean'])) {
    	$evaluated_by = mysqli_real_escape_string($conn, $_POST['evaluated_by']);
    	$user_Id    = mysqli_real_escape_string($conn, $_POST['user_Id']);
    
    	header("Location: evaluate_dean.php?evaluated_by=" . $evaluated_by . "&&user_Id=" . $user_Id . " ");
    }

	// Retrieve the values sent via AJAX
	$evaluated_by = $_POST['evaluated_by'];
	$userId = $_POST['user_Id'];
	$acad_Id = $_POST['acad_Id'];
	$inputName = $_POST['input_name'];
	$inputValue = $_POST['input_value'];

	// Prepare the SQL statement to check if a record exists for the user, section, and subject
	$stmt = $conn->prepare('SELECT * FROM evaluation WHERE evaluated_by = ? AND user_Id = ? AND acad_Id = ?');
	$stmt->bind_param('sss', $evaluated_by, $userId, $acad_Id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
	    // Update the existing record
	    $updateStmt = $conn->prepare('UPDATE evaluation SET ' . $inputName . ' = ? WHERE evaluated_by = ? AND user_Id = ? AND acad_Id = ?');
	    $updateStmt->bind_param('isss', $inputValue, $evaluated_by, $userId, $acad_Id);
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
	    	AND acad_Id = ?');

	    $calculateTotalStmt->bind_param('sss', $evaluated_by, $userId, $acad_Id);
	    $calculateTotalStmt->execute();
	} else {
	    // Insert a new record
	    $insertStmt = $conn->prepare('INSERT INTO evaluation (evaluated_by, acad_Id, user_Id,' . $inputName . ', A_Total, B_Total, grand_total, date_evaluated, com) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)');
	    $insertStmt->bind_param('ssisids', $evaluated_by, $acad_Id, $userId, $inputValue, $inputValue, $inputValue, $inputValue);
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



