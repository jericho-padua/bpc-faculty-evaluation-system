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

		
	// UPDATE ADMIN - ADMIN_MGMT.PHP
	if(isset($_POST['update_admin'])) {

		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		$age              = mysqli_real_escape_string($conn, $_POST['age']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_Id !='$user_Id'");
		if(mysqli_num_rows($get_email) > 0) {
		   $_SESSION['message'] = "Email already exists!";
	       $_SESSION['text'] = "Please try again.";
	       $_SESSION['status'] = "error";
		   header("Location: admin_mgmt.php?page=".$user_Id);
		} else {

			if(empty($file)) {
				$update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', gender='$gender' WHERE user_Id='$user_Id' ");

              	  if($update) {
		          	$_SESSION['message'] = "Record has been updated!";
		            $_SESSION['text'] = "Saved successfully!";
			        $_SESSION['status'] = "success";
					header("Location: admin_mgmt.php?page=".$user_Id);
		          } else {
		            $_SESSION['message'] = "Something went wrong while updating the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: admin_mgmt.php?page=".$user_Id);
		          }
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
					header("Location: admin_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				} 

				// Check file size // 500KB max size
				elseif ($_FILES["fileToUpload"]["size"] > 500000) {
				  	$_SESSION['message']  = "File must be up to 500KB in size.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: admin_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				}

				// Allow certain file formats
				elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: admin_mgmt.php?page=".$user_Id);
				    $uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				elseif ($uploadOk == 0) {
				    $_SESSION['message'] = "Your file was not uploaded.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: admin_mgmt.php?page=".$user_Id);

				// if everything is ok, try to upload file
				} else {

					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

					 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', gender='$gender', image='$file' WHERE user_Id='$user_Id' ");

	              	  if($update) {
			          	$_SESSION['message'] = "Record has been updated!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: admin_mgmt.php?page=".$user_Id);
			          } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: admin_mgmt.php?page=".$user_Id);
			          }
						
					} else {
						$_SESSION['message'] = "There was an error uploading your profile picture.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: admin_mgmt.php?page=".$user_Id);
					}
				}
			}
		}
		
	}





	// CHANGE ADMIN PASSWORD - ADMIN_DELETE.PHP
	if(isset($_POST['password_admin'])) {

    	$user_Id     = $_POST['user_Id'];
    	$OldPassword = md5($_POST['OldPassword']);
    	$password    = md5($_POST['password']);
    	$cpassword   = md5($_POST['cpassword']);

    	$check_old_password = mysqli_query($conn, "SELECT * FROM users WHERE password='$OldPassword' AND user_Id='$user_Id'");

    	// CHECK IF THERE IS MATCHED PASSWORD IN THE DATABASE COMPARED TO THE ENTERED OLD PASSWORD
    	if(mysqli_num_rows($check_old_password) === 1 ) {
			// COMPARE BOTH NEW AND CONFIRM PASSWORD
    		if($password != $cpassword) {
				$_SESSION['message']  = "Password did not matched. Please try again";
            	$_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: admin.php");
    		} else {
    			$update_password = mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_Id='$user_Id' ");
    			if($update_password) {
        			$_SESSION['message'] = "Password has been changed.";
	           	    $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: admin.php");
                } else {
          			$_SESSION['message'] = "Something went wrong while changing the password.";
            		$_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: admin.php");
                }
    		}
    	} else {
			$_SESSION['message']  = "Old password is incorrect.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: admin.php");
    	}
    }





    // UPDATE USER - USERS_MGMT.PHP
	if(isset($_POST['update_user'])) {
		$stud_type        = mysqli_real_escape_string($conn, $_POST['stud_type']);
		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
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
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_Id !='$user_Id'");
		if(mysqli_num_rows($get_email) > 0) {
		   $_SESSION['message'] = "Email already exists!";
	       $_SESSION['text'] = "Please try again.";
	       $_SESSION['status'] = "error";
		   header("Location: users_mgmt.php?page=".$user_Id);
		} else {
			$get_email = mysqli_query($conn, "SELECT * FROM users WHERE student_ID='$student_ID' AND user_Id !='$user_Id'");
			if(mysqli_num_rows($get_email) > 0) {
			   $_SESSION['message'] = "Student ID already exists!";
		       $_SESSION['text'] = "Please try again.";
		       $_SESSION['status'] = "error";
			   header("Location: users_mgmt.php?page=".$user_Id);
			} else {

				if(empty($file)) {
					$update = mysqli_query($conn, "UPDATE users SET stud_type='$stud_type', student_ID='$student_ID', year_section='$year_section', department='$department', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender' WHERE user_Id='$user_Id' ");

	              	  if($update) {
			          	$_SESSION['message'] = "Record has been updated!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: users_mgmt.php?page=".$user_Id);
			          } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: users_mgmt.php?page=".$user_Id);
			          }
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
						header("Location: users_mgmt.php?page=".$user_Id);
						$uploadOk = 0;
					} 

					// Check file size // 500KB max size
					elseif ($_FILES["fileToUpload"]["size"] > 500000) {
					  	$_SESSION['message']  = "File must be up to 500KB in size.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: users_mgmt.php?page=".$user_Id);
						$uploadOk = 0;
					}

					// Allow certain file formats
					elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: users_mgmt.php?page=".$user_Id);
					    $uploadOk = 0;
					}

					// Check if $uploadOk is set to 0 by an error
					elseif ($uploadOk == 0) {
					    $_SESSION['message'] = "Your file was not uploaded.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: users_mgmt.php?page=".$user_Id);

					// if everything is ok, try to upload file
					} else {

						if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

						 $update = mysqli_query($conn, "UPDATE users SET stud_type='$stud_type', student_ID='$student_ID', year_section='$year_section', department='$department', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender', ID_verification='$file' WHERE user_Id='$user_Id' ");

		              	  if($update) {
				          	$_SESSION['message'] = "Record has been updated!";
				            $_SESSION['text'] = "Saved successfully!";
					        $_SESSION['status'] = "success";
							header("Location: users_mgmt.php?page=".$user_Id);
				          } else {
				            $_SESSION['message'] = "Something went wrong while updating the information.";
				            $_SESSION['text'] = "Please try again.";
					        $_SESSION['status'] = "error";
							header("Location: users_mgmt.php?page=".$user_Id);
				          }
							
						} else {
							$_SESSION['message'] = "There was an error uploading your profile picture.";
						    $_SESSION['text'] = "Please try again.";
						    $_SESSION['status'] = "error";
							header("Location: users_mgmt.php?page=".$user_Id);
						}
					}
				}
			}
		}

	}





	// CHANGE USERS PASSWORD - USERS_DELETE.PHP
	if(isset($_POST['password_user'])) {

    	$user_Id     = $_POST['user_Id'];
    	$OldPassword = md5($_POST['OldPassword']);
    	$password    = md5($_POST['password']);
    	$cpassword   = md5($_POST['cpassword']);

    	$check_old_password = mysqli_query($conn, "SELECT * FROM users WHERE password='$OldPassword' AND user_Id='$user_Id'");

    	// CHECK IF THERE IS MATCHED PASSWORD IN THE DATABASE COMPARED TO THE ENTERED OLD PASSWORD
    	if(mysqli_num_rows($check_old_password) === 1 ) {
			// COMPARE BOTH NEW AND CONFIRM PASSWORD
    		if($password != $cpassword) {
				$_SESSION['message']  = "Password did not matched. Please try again";
            	$_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: users.php");
    		} else {
    			$update_password = mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_Id='$user_Id' ");
    			if($update_password) {
        			$_SESSION['message'] = "Password has been changed.";
	           	    $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: users.php");
                } else {
          			$_SESSION['message'] = "Something went wrong while changing the password.";
            		$_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: users.php");
                }
    		}
    	} else {
			$_SESSION['message']  = "Old password is incorrect.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: users.php");
    	}
    }



    


	
	// VERIFY STUDENT - STUDENT_DELETE.PHP
	if(isset($_POST['verify_user'])) {
		$user_Id = $_POST['user_Id'];
		$sql = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id' ");
		$row = mysqli_fetch_array($sql);
		$email = $row['email'];
		$name = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];


		$update = mysqli_query($conn, "UPDATE users SET student_status=1 WHERE user_Id='$user_Id' ");
		if($update) {

		  $subject = 'Account Verified';
	      $message = '<p>Good day sir/maam '.$name.', this is to inform you that your account has been verified. Thank you!</p>
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

	        	$_SESSION['message'] = "Student account has been verified";
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
  			$_SESSION['message'] = "Something went wrong while changing the password.";
    		$_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: users.php");
        }
	}


    // UPDATE SUPERIOR - SUPERIOR_MGMT.PHP
	if(isset($_POST['update_superior'])) {

		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
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
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_Id !='$user_Id'");
		if(mysqli_num_rows($get_email) > 0) {
		   $_SESSION['message'] = "Email already exists!";
	       $_SESSION['text'] = "Please try again.";
	       $_SESSION['status'] = "error";
		   header("Location: superior_mgmt.php?page=".$user_Id);
		} else {

			if(empty($file)) {
				$update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender' WHERE user_Id='$user_Id' ");

              	  if($update) {
		          	$_SESSION['message'] = "Record has been updated!";
		            $_SESSION['text'] = "Saved successfully!";
			        $_SESSION['status'] = "success";
					header("Location: superior.php");
		          } else {
		            $_SESSION['message'] = "Something went wrong while updating the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: superior_mgmt.php?page=".$user_Id);
		          }
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
					header("Location: superior_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				} 

				// Check file size // 500KB max size
				elseif ($_FILES["fileToUpload"]["size"] > 500000) {
				  	$_SESSION['message']  = "File must be up to 500KB in size.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: superior_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				}

				// Allow certain file formats
				elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: superior_mgmt.php?page=".$user_Id);
				    $uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				elseif ($uploadOk == 0) {
				    $_SESSION['message'] = "Your file was not uploaded.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: superior_mgmt.php?page=".$user_Id);

				// if everything is ok, try to upload file
				} else {

					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

					 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender', image='$file' WHERE user_Id='$user_Id' ");

	              	  if($update) {
			          	$_SESSION['message'] = "Record has been updated!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: superior_mgmt.php?page=".$user_Id);
			          } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: superior_mgmt.php?page=".$user_Id);
			          }
						
					} else {
						$_SESSION['message'] = "There was an error uploading your profile picture.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: superior_mgmt.php?page=".$user_Id);
					}
				}
			}
		}
	}


	// CHANGE SUPERIOR PASSWORD - SUPERIOR_DELETE.PHP
	if(isset($_POST['password_superior'])) {

    	$user_Id     = $_POST['user_Id'];
    	$OldPassword = md5($_POST['OldPassword']);
    	$password    = md5($_POST['password']);
    	$cpassword   = md5($_POST['cpassword']);

    	$check_old_password = mysqli_query($conn, "SELECT * FROM users WHERE password='$OldPassword' AND user_Id='$user_Id'");

    	// CHECK IF THERE IS MATCHED PASSWORD IN THE DATABASE COMPARED TO THE ENTERED OLD PASSWORD
    	if(mysqli_num_rows($check_old_password) === 1 ) {
			// COMPARE BOTH NEW AND CONFIRM PASSWORD
    		if($password != $cpassword) {
				$_SESSION['message']  = "Password did not matched. Please try again";
            	$_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: superior.php");
    		} else {
    			$update_password = mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_Id='$user_Id' ");
    			if($update_password) {
        			$_SESSION['message'] = "Password has been changed.";
	           	    $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: superior.php");
                } else {
          			$_SESSION['message'] = "Something went wrong while changing the password.";
            		$_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: superior.php");
                }
    		}
    	} else {
			$_SESSION['message']  = "Old password is incorrect.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: superior.php");
    	}
    }


    // UPDATE FACULTY - FACULTY_MGMT.PHP
	if(isset($_POST['update_faculty'])) {

		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
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
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_Id !='$user_Id'");
		if(mysqli_num_rows($get_email) > 0) {
		   $_SESSION['message'] = "Email already exists!";
	       $_SESSION['text'] = "Please try again.";
	       $_SESSION['status'] = "error";
		   header("Location: faculty_mgmt.php?page=".$user_Id);
		} else {

			if(empty($file)) {
				$update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender' WHERE user_Id='$user_Id' ");

              	  if($update) {
		          	$_SESSION['message'] = "Record has been updated!";
		            $_SESSION['text'] = "Saved successfully!";
			        $_SESSION['status'] = "success";
					header("Location: faculty.php");
		          } else {
		            $_SESSION['message'] = "Something went wrong while updating the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: faculty_mgmt.php?page=".$user_Id);
		          }
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
					header("Location: faculty_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				} 

				// Check file size // 500KB max size
				elseif ($_FILES["fileToUpload"]["size"] > 500000) {
				  	$_SESSION['message']  = "File must be up to 500KB in size.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: faculty_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				}

				// Allow certain file formats
				elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: faculty_mgmt.php?page=".$user_Id);
				    $uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				elseif ($uploadOk == 0) {
				    $_SESSION['message'] = "Your file was not uploaded.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: faculty_mgmt.php?page=".$user_Id);

				// if everything is ok, try to upload file
				} else {

					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

					 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender', image='$file' WHERE user_Id='$user_Id' ");

	              	  if($update) {
			          	$_SESSION['message'] = "Record has been updated!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: faculty_mgmt.php?page=".$user_Id);
			          } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: faculty_mgmt.php?page=".$user_Id);
			          }
						
					} else {
						$_SESSION['message'] = "There was an error uploading your profile picture.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: faculty_mgmt.php?page=".$user_Id);
					}
				}
			}
		}
	}





	// CHANGE FACULTY PASSWORD - FACULTY_DELETE.PHP
	if(isset($_POST['password_faculty'])) {

    	$user_Id     = $_POST['user_Id'];
    	$OldPassword = md5($_POST['OldPassword']);
    	$password    = md5($_POST['password']);
    	$cpassword   = md5($_POST['cpassword']);

    	$check_old_password = mysqli_query($conn, "SELECT * FROM users WHERE password='$OldPassword' AND user_Id='$user_Id'");

    	// CHECK IF THERE IS MATCHED PASSWORD IN THE DATABASE COMPARED TO THE ENTERED OLD PASSWORD
    	if(mysqli_num_rows($check_old_password) === 1 ) {
			// COMPARE BOTH NEW AND CONFIRM PASSWORD
    		if($password != $cpassword) {
				$_SESSION['message']  = "Password did not matched. Please try again";
            	$_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: faculty.php");
    		} else {
    			$update_password = mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_Id='$user_Id' ");
    			if($update_password) {
        			$_SESSION['message'] = "Password has been changed.";
	           	    $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: faculty.php");
                } else {
          			$_SESSION['message'] = "Something went wrong while changing the password.";
            		$_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: faculty.php");
                }
    		}
    	} else {
			$_SESSION['message']  = "Old password is incorrect.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: faculty.php");
    	}
    }





     // UPDATE SUPERVISOR - SUPERVISOR_MGMT.PHP
	if(isset($_POST['update_dean'])) {

		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		// $age              = mysqli_real_escape_string($conn, $_POST['age']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_Id !='$user_Id'");
		if(mysqli_num_rows($get_email) > 0) {
		   $_SESSION['message'] = "Email already exists!";
	       $_SESSION['text'] = "Please try again.";
	       $_SESSION['status'] = "error";
		   header("Location: dean_mgmt.php?page=".$user_Id);
		} else {

			if(empty($file)) {
				$update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender' WHERE user_Id='$user_Id' ");

              	  if($update) {
		          	$_SESSION['message'] = "Record has been updated!";
		            $_SESSION['text'] = "Saved successfully!";
			        $_SESSION['status'] = "success";
					header("Location: dean_mgmt.php?page=".$user_Id);
		          } else {
		            $_SESSION['message'] = "Something went wrong while updating the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: dean_mgmt.php?page=".$user_Id);
		          }
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
					header("Location: dean_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				} 

				// Check file size // 500KB max size
				elseif ($_FILES["fileToUpload"]["size"] > 500000) {
				  	$_SESSION['message']  = "File must be up to 500KB in size.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: dean_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				}

				// Allow certain file formats
				elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: dean_mgmt.php?page=".$user_Id);
				    $uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				elseif ($uploadOk == 0) {
				    $_SESSION['message'] = "Your file was not uploaded.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: dean_mgmt.php?page=".$user_Id);

				// if everything is ok, try to upload file
				} else {

					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

					 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender', image='$file' WHERE user_Id='$user_Id' ");

	              	  if($update) {
			          	$_SESSION['message'] = "Record has been updated!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: dean_mgmt.php?page=".$user_Id);
			          } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: dean_mgmt.php?page=".$user_Id);
			          }
						
					} else {
						$_SESSION['message'] = "There was an error uploading your profile picture.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: dean_mgmt.php?page=".$user_Id);
					}
				}
			}
		}
	}





	// CHANGE SUPERVISOR PASSWORD - SUPERVISOR_DELETE.PHP
	if(isset($_POST['password_supervisor'])) {

    	$user_Id     = $_POST['user_Id'];
    	$OldPassword = md5($_POST['OldPassword']);
    	$password    = md5($_POST['password']);
    	$cpassword   = md5($_POST['cpassword']);

    	$check_old_password = mysqli_query($conn, "SELECT * FROM users WHERE password='$OldPassword' AND user_Id='$user_Id'");

    	// CHECK IF THERE IS MATCHED PASSWORD IN THE DATABASE COMPARED TO THE ENTERED OLD PASSWORD
    	if(mysqli_num_rows($check_old_password) === 1 ) {
			// COMPARE BOTH NEW AND CONFIRM PASSWORD
    		if($password != $cpassword) {
				$_SESSION['message']  = "Password did not matched. Please try again";
            	$_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: supervisor.php");
    		} else {
    			$update_password = mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_Id='$user_Id' ");
    			if($update_password) {
        			$_SESSION['message'] = "Password has been changed.";
	           	    $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: supervisor.php");
                } else {
          			$_SESSION['message'] = "Something went wrong while changing the password.";
            		$_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: supervisor.php");
                }
    		}
    	} else {
			$_SESSION['message']  = "Old password is incorrect.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: supervisor.php");
    	}
    }






	// UPDATE ADMIN INFO - PROFILE.PHP
	if(isset($_POST['update_profile_info'])) {

		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		// $age              = mysqli_real_escape_string($conn, $_POST['age']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_Id !='$user_Id' ");
		if(mysqli_num_rows($check) > 0) {
		   $_SESSION['message'] = "Email already exists!";
	       $_SESSION['text'] = "Please try again.";
	       $_SESSION['status'] = "error";
		   header("Location: profile.php");
		} else {

				if(empty($file)) {
					  $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender' WHERE user_Id='$user_Id' ");

			      	  if($update) {
			          	$_SESSION['message'] = "Record has been updated!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: profile.php");
			          } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: profile.php");
			          }
				} else {

					// Check if image file is a actual image or fake image
				    $target_dir = "../images-users/";
				    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				    $uploadOk = 1;
				    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
					if($check == false) {
					    $_SESSION['message']  = "Selected file is not an image.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: profile.php");
				    	$uploadOk = 0;
				    } 

					// Check file size // 500KB max size
					elseif ($_FILES["fileToUpload"]["size"] > 500000) {
					  	$_SESSION['message']  = "File must be up to 500KB in size.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: profile.php");
				    	$uploadOk = 0;
					}

				    // Allow certain file formats
				    elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
					    $_SESSION['message']  = "Only JPG, JPEG, PNG & GIF files are allowed.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: profile.php");
				    	$uploadOk = 0;
				    }

				    // Check if $uploadOk is set to 0 by an error
				    elseif ($uploadOk == 0) {
					    $_SESSION['message']  = "Your file was not uploaded.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: profile.php");

				    // if everything is ok, try to upload file
				    } else {

				        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				     
				              $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender', image='$file' WHERE user_Id='$user_Id' ");

					      	  if($update) {
					          	$_SESSION['message'] = "Record has been updated!";
					            $_SESSION['text'] = "Saved successfully!";
						        $_SESSION['status'] = "success";
								header("Location: profile.php");
					          } else {
					            $_SESSION['message'] = "Something went wrong while updating the information.";
					            $_SESSION['text'] = "Please try again.";
						        $_SESSION['status'] = "error";
								header("Location: profile.php");
					          }
				        } else {
				            $_SESSION['message'] = "There was an error uploading your file.";
				            $_SESSION['text'] = "Please try again.";
					        $_SESSION['status'] = "error";
							header("Location: profile.php");
				        }

					}

				}
			  
		}

	}



	// CHANGE ADMIN PASSWORD - PROFILE.PHP
	if(isset($_POST['update_password_admin'])) {

    	$user_Id    = $_POST['user_Id'];
    	$OldPassword = md5($_POST['OldPassword']);
    	$password    = md5($_POST['password']);
    	$cpassword   = md5($_POST['cpassword']);

    	$check_old_password = mysqli_query($conn, "SELECT * FROM users WHERE password='$OldPassword' AND user_Id='$user_Id'");

    	// CHECK IF THERE IS MATCHED PASSWORD IN THE DATABASE COMPARED TO THE ENTERED OLD PASSWORD
    	if(mysqli_num_rows($check_old_password) === 1 ) {
			// COMPARE BOTH NEW AND CONFIRM PASSWORD
    		if($password != $cpassword) {
				$_SESSION['message']  = "Password does not matched. Please try again";
            	$_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: profile.php");
    		} else {
    			$update_password = mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_Id='$user_Id' ");
    			if($update_password) {
                	$_SESSION['message'] = "Password has been changed.";
		            $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: profile.php");
                } else {
                    $_SESSION['message'] = "Something went wrong while changing the password.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: profile.php");
                }
    		}
    	} else {
			$_SESSION['message']  = "Old password is incorrect.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: profile.php");
    	}

    }







    // UPDATE ACADEMIC YEAR - ACADEMIC_MGMT.PHP
	if(isset($_POST['update_academic_year'])) {
		$acad_Id  = mysqli_real_escape_string($conn, $_POST['acad_Id']);
		$year1    = mysqli_real_escape_string($conn, $_POST['year1']);
		$year2    = mysqli_real_escape_string($conn, $_POST['year2']);
		$semester = mysqli_real_escape_string($conn, $_POST['semester']);
		$status   = mysqli_real_escape_string($conn, $_POST['status']);

		$acad     = $year1.'-'.$year2;

		$fetch = mysqli_query($conn, "SELECT * FROM academic_year WHERE year='$acad' AND semester='$semester' AND acad_Id != '$acad_Id' ");
		if(mysqli_num_rows($fetch) > 0) {
			$_SESSION['message'] = "Academic Year already exists.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: academic_mgmt.php?page=".$acad_Id);
		} else {

			$fetch = mysqli_query($conn, "SELECT * FROM academic_year WHERE status=1 AND acad_Id != '$acad_Id' ");
			if(mysqli_num_rows($fetch) > 0) {
				$_SESSION['message'] = "There is already an On-going evalution.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: academic_mgmt.php?page=".$acad_Id);
			} else {
				$save = mysqli_query($conn, "UPDATE academic_year SET year='$acad', semester='$semester', status='$status' WHERE acad_Id='$acad_Id' ");

	          	  if($save) {
		          	$_SESSION['message'] = "Record has been updated!";
		            $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: academic_mgmt.php?page=".$acad_Id);
		          } else {
		            $_SESSION['message'] = "Something went wrong while updating the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: academic_mgmt.php?page=".$acad_Id);
		          }
			}
		}
	}





	// UPDATE SUBJECT - SUBJECT_MGMT.PHP
	if(isset($_POST['update_subject'])) {
		$sub_Id        = mysqli_real_escape_string($conn, $_POST['sub_Id']);
		$name          = mysqli_real_escape_string($conn, $_POST['name']);
		$code          = mysqli_real_escape_string($conn, strtoupper($_POST['code']));
		$units         = mysqli_real_escape_string($conn, $_POST['units']);
		$instructor_Id = mysqli_real_escape_string($conn, $_POST['instructor_Id']);
		$section_Id    = mysqli_real_escape_string($conn, $_POST['section_Id']);

		$fetch = mysqli_query($conn, "SELECT * FROM subject WHERE name='$name' AND code='$code' AND units='$units' AND section_Id='$section_Id' AND instructor_Id='$instructor_Id' AND sub_Id!='$sub_Id' AND acad_Id='$acad_Id'");
		if(mysqli_num_rows($fetch) > 0) {
			$_SESSION['message'] = "Subject name already exists.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: subject_mgmt.php?page=".$sub_Id);
		} else {
			$fetch = mysqli_query($conn, "SELECT * FROM subject WHERE name='$name' AND section_Id='$section_Id' AND sub_Id !='$sub_Id' AND acad_Id='$acad_Id'");
			if(mysqli_num_rows($fetch) > 0) {
				$_SESSION['message'] = "Duplication of subject in the same section.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: subject_mgmt.php?page=".$sub_Id);
			} else {
				// $fetch = mysqli_query($conn, "SELECT * FROM subject WHERE code='$code' AND sub_Id!='$sub_Id' ");
				// if(mysqli_num_rows($fetch) > 0) {
				// 	$_SESSION['message'] = "Subject code already exists.";
		        //     $_SESSION['text'] = "Please try again.";
			    //     $_SESSION['status'] = "error";
				// 	header("Location: subject_mgmt.php?page=".$sub_Id);
				// } else {
					$save = mysqli_query($conn, "UPDATE subject SET name='$name', code='$code', units='$units', instructor_Id='$instructor_Id', section_Id='$section_Id' WHERE sub_Id='$sub_Id' ");

		          	  if($save) {
			          	$_SESSION['message'] = "Record has been updated!";
			            $_SESSION['text'] = "Updated successfully!";
				        $_SESSION['status'] = "success";
						header("Location: subject_mgmt.php?page=".$sub_Id);
			          } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: subject_mgmt.php?page=".$sub_Id);
			          }
				// }
			}
		}
	}






	// UPDATE SECTION - SECTION_MGMT.PHP
	if(isset($_POST['update_section'])) {
		$section_Id = mysqli_real_escape_string($conn, $_POST['section_Id']);
		$yr_level   = mysqli_real_escape_string($conn, $_POST['yr_level']);
		$section    = mysqli_real_escape_string($conn, $_POST['section']);
		$department   = mysqli_real_escape_string($conn, $_POST['department']);

		$fetch = mysqli_query($conn, "SELECT * FROM section WHERE yr_level='$yr_level' AND section='$section' AND department='$department' AND section_Id != '$section_Id' ");
		if(mysqli_num_rows($fetch) > 0) {
			$_SESSION['message'] = " ".$yr_level." with section, ".$section." and department, ".$department." already exists.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: section_mgmt.php?page=".$section_Id);
		} else {
			$update = mysqli_query($conn, "UPDATE section SET yr_level='$yr_level', section='$section', department='$department' WHERE section_Id = '$section_Id' ");

          	  if($update) {
	          	$_SESSION['message'] = "Record has been updated!";
	            $_SESSION['text'] = "Updated successfully!";
		        $_SESSION['status'] = "success";
				header("Location: section_mgmt.php?page=".$section_Id);
	          } else {
	            $_SESSION['message'] = "Something went wrong while updating the information.";
	            $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: section_mgmt.php?page=".$section_Id);
	          }
		}
	}
    

	// SET SUPERIOR TO ACTIVE
	if(isset($_POST['active_superior'])) {
		$user_Id = $_POST['user_Id'];
		$update = mysqli_query($conn, "UPDATE users SET superior_status=0 WHERE user_Id='$user_Id'");
		 if($update) {
          	$_SESSION['message'] = "Record has been updated!";
            $_SESSION['text'] = "Updated successfully!";
	        $_SESSION['status'] = "success";
			header("Location: superior.php");
          } else {
            $_SESSION['message'] = "Something went wrong while updating the information.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: superior.php");
          }
	}


	// SET FACULTY TO INACTIVE
	if(isset($_POST['inactive_superior'])) {
		$user_Id = $_POST['user_Id'];
		$update = mysqli_query($conn, "UPDATE users SET superior_status=1 WHERE user_Id='$user_Id'");
		 if($update) {
          	$_SESSION['message'] = "Record has been updated!";
            $_SESSION['text'] = "Updated successfully!";
	        $_SESSION['status'] = "success";
			header("Location: superior.php");
          } else {
            $_SESSION['message'] = "Something went wrong while updating the information.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: superior.php");
          }
	}    
   

	// SET FACULTY TO ACTIVE
	if(isset($_POST['active_faculty'])) {
		$user_Id = $_POST['user_Id'];
		$update = mysqli_query($conn, "UPDATE users SET faculty_status=0 WHERE user_Id='$user_Id'");
		 if($update) {
          	$_SESSION['message'] = "Record has been updated!";
            $_SESSION['text'] = "Updated successfully!";
	        $_SESSION['status'] = "success";
			header("Location: faculty.php");
          } else {
            $_SESSION['message'] = "Something went wrong while updating the information.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: faculty.php");
          }
	}


	// SET FACULTY TO INACTIVE
	if(isset($_POST['inactive_faculty'])) {
		$user_Id = $_POST['user_Id'];
		$update = mysqli_query($conn, "UPDATE users SET faculty_status=1 WHERE user_Id='$user_Id'");
		 if($update) {
          	$_SESSION['message'] = "Record has been updated!";
            $_SESSION['text'] = "Updated successfully!";
	        $_SESSION['status'] = "success";
			header("Location: faculty.php");
          } else {
            $_SESSION['message'] = "Something went wrong while updating the information.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: faculty.php");
          }
	}
	
	// SET DEAN TO ACTIVE
	if(isset($_POST['active_dean'])) {
		$user_Id = $_POST['user_Id'];
		$update = mysqli_query($conn, "UPDATE users SET faculty_status=0 WHERE user_Id='$user_Id'");
		 if($update) {
          	$_SESSION['message'] = "Record has been updated!";
            $_SESSION['text'] = "Updated successfully!";
	        $_SESSION['status'] = "success";
			header("Location: dean.php");
          } else {
            $_SESSION['message'] = "Something went wrong while updating the information.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: dean.php");
          }
	}


	// SET DEAN TO INACTIVE
	if(isset($_POST['inactive_dean'])) {
		$user_Id = $_POST['user_Id'];
		$update = mysqli_query($conn, "UPDATE users SET faculty_status=1 WHERE user_Id='$user_Id'");
		 if($update) {
          	$_SESSION['message'] = "Record has been updated!";
            $_SESSION['text'] = "Updated successfully!";
	        $_SESSION['status'] = "success";
			header("Location: dean.php");
          } else {
            $_SESSION['message'] = "Something went wrong while updating the information.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: dean.php");
          }
	}



	// Retrieve the input values from the AJAX request
	$evaluatedBy = $_POST['evaluated_by'];
	$userId = $_POST['user_Id'];
	$acadId = $_POST['acad_Id'];
	//$com = $_POST['com'];



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
