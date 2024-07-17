<?php 
	include '../config.php';



	// UPDATE ADMIN INFO - PROFILE.PHP
	if(isset($_POST['update_profile_info'])) {

		$stud_type        = mysqli_real_escape_string($conn, $_POST['stud_type']);
		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
		$student_ID       = mysqli_real_escape_string($conn, $_POST['student_ID']);
		$year_section     = mysqli_real_escape_string($conn, $_POST['year_section']);
		$department       = mysqli_real_escape_string($conn, $_POST['department']);
		$acad_rank        = mysqli_real_escape_string($conn, $_POST['acad_rank']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		// $age              = mysqli_real_escape_string($conn, $_POST['age']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$file             = basename($_FILES["fileToUpload"]["name"]);

		// SET THE DEPARTMENT AND ACADEMIC RANK INTO EMPTY IF THE USER IS FACULTY
		$get_type = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id' ");
		$row = mysqli_fetch_array($get_type);
		$u_type = $row['user_type'];

		$fac_department = $department;
		$fac_acad_rank = $acad_rank;
		if($u_type == 'Faculty') {
			$fac_department = "";
			$fac_acad_rank = "";
		} else {
			$fac_department = $department;
			$fac_acad_rank = $acad_rank;
		}


		$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_Id !='$user_Id' ");
		if(mysqli_num_rows($check) > 0) {
		   $_SESSION['message'] = "Email already exists!";
	       $_SESSION['text'] = "Please try again.";
	       $_SESSION['status'] = "error";
		   header("Location: profile.php");
		} else {

				if(empty($file)) {
					  $update = mysqli_query($conn, "UPDATE users SET stud_type='$stud_type', student_ID='$student_ID', year_section='$year_section', department='$fac_department', acad_rank='$fac_acad_rank', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender' WHERE user_Id='$user_Id' ");

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
				     
				              $update = mysqli_query($conn, "UPDATE users SET stud_type='$stud_type', student_ID='$student_ID', year_section='$year_section', department='$fac_department', acad_rank='$fac_acad_rank', firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', email='$email', gender='$gender', image='$file' WHERE user_Id='$user_Id' ");

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





    // Retrieve the input values from the AJAX request
	$evaluatedBy = $_POST['evaluated_by'];
	$sectionId = $_POST['section_Id'];
	$subjectId = $_POST['subject_Id'];
	$userId = $_POST['user_Id'];
	$acadId = $_POST['acad_Id'];


	// Update the evaluation_status
	$sql = "UPDATE evaluation SET evaluation_status = 1 WHERE evaluated_by = ? AND section_Id = ? AND subject_Id = ? AND user_Id = ? AND acad_Id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("iiiii", $evaluatedBy, $sectionId, $subjectId, $userId, $acadId);

	if ($stmt->execute()) {
	  echo "Evaluation status updated successfully";
	} else {
	  echo "Error updating evaluation status: " . $stmt->error;
	}

	$stmt->close();
	$conn->close();




?>
