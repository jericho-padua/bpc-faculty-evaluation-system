<?php 
	include '../config.php';

		
	// UPDATE ADMIN - ADMIN_MGMT.PHP
	if(isset($_POST['update_admin'])) {

		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
		$user_type		  = mysqli_real_escape_string($conn, $_POST['user_type']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		$age              = mysqli_real_escape_string($conn, $_POST['age']);
		$birthplace       = mysqli_real_escape_string($conn, $_POST['birthplace']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$civilstatus      = mysqli_real_escape_string($conn, $_POST['civilstatus']);
		$occupation       = mysqli_real_escape_string($conn, $_POST['occupation']);
		$religion		  = mysqli_real_escape_string($conn, $_POST['religion']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$contact		  = mysqli_real_escape_string($conn, $_POST['contact']);
		$house_no         = mysqli_real_escape_string($conn, $_POST['house_no']);
		$street_name      = mysqli_real_escape_string($conn, $_POST['street_name']);
		$purok            = mysqli_real_escape_string($conn, $_POST['purok']);
		$zone             = mysqli_real_escape_string($conn, $_POST['zone']);
		$barangay         = mysqli_real_escape_string($conn, $_POST['barangay']);
		$municipality     = mysqli_real_escape_string($conn, $_POST['municipality']);
		$province         = mysqli_real_escape_string($conn, $_POST['province']);
		$region           = mysqli_real_escape_string($conn, $_POST['region']);
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id'");
		$row = mysqli_fetch_array($get_email);
		$existing_email = $row['email'];

		if(empty($file)) {
			if($existing_email == $email) {

				$update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', user_type='$user_type' WHERE user_Id='$user_Id' ");

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
				$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				if(mysqli_num_rows($check) > 0) {
				   $_SESSION['message'] = "Email already exists!";
			       $_SESSION['text'] = "Please try again.";
			       $_SESSION['status'] = "error";
				   header("Location: admin_mgmt.php?page=".$user_Id);
				} else {
					  $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', user_type='$user_type' WHERE user_Id='$user_Id' ");

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
				}
			}

		} else {

			if($existing_email == $email) {

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

					 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', user_type='$user_type', image='$file' WHERE user_Id='$user_Id' ");

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

				

			} else {
				$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				if(mysqli_num_rows($check) > 0) {
				   $_SESSION['message'] = "Email already exists!";
			       $_SESSION['text'] = "Please try again.";
			       $_SESSION['status'] = "error";
				   header("Location: admin_mgmt.php?page=".$user_Id);
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

							 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', user_type='$user_type', image='$file' WHERE user_Id='$user_Id' ");

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

		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		$age              = mysqli_real_escape_string($conn, $_POST['age']);
		$birthplace       = mysqli_real_escape_string($conn, $_POST['birthplace']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$civilstatus      = mysqli_real_escape_string($conn, $_POST['civilstatus']);
		$occupation       = mysqli_real_escape_string($conn, $_POST['occupation']);
		$religion		  = mysqli_real_escape_string($conn, $_POST['religion']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$contact		  = mysqli_real_escape_string($conn, $_POST['contact']);
		$house_no         = mysqli_real_escape_string($conn, $_POST['house_no']);
		$street_name      = mysqli_real_escape_string($conn, $_POST['street_name']);
		$purok            = mysqli_real_escape_string($conn, $_POST['purok']);
		$zone             = mysqli_real_escape_string($conn, $_POST['zone']);
		$barangay         = mysqli_real_escape_string($conn, $_POST['barangay']);
		$municipality     = mysqli_real_escape_string($conn, $_POST['municipality']);
		$province         = mysqli_real_escape_string($conn, $_POST['province']);
		$region           = mysqli_real_escape_string($conn, $_POST['region']);
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id'");
		$row = mysqli_fetch_array($get_email);
		$existing_email = $row['email'];

		if(empty($file)) {
			if($existing_email == $email) {

				$update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region' WHERE user_Id='$user_Id' ");

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
				$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				if(mysqli_num_rows($check) > 0) {
				   $_SESSION['message'] = "Email already exists!";
			       $_SESSION['text'] = "Please try again.";
			       $_SESSION['status'] = "error";
				   header("Location: users_mgmt.php?page=".$user_Id);
				} else {
					  $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region' WHERE user_Id='$user_Id' ");

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
				}
			}

		} else {

			if($existing_email == $email) {

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

					 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', image='$file' WHERE user_Id='$user_Id' ");

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

				

			} else {
				$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				if(mysqli_num_rows($check) > 0) {
				   $_SESSION['message'] = "Email already exists!";
			       $_SESSION['text'] = "Please try again.";
			       $_SESSION['status'] = "error";
				   header("Location: users_mgmt.php?page=".$user_Id);
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

							 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', image='$file' WHERE user_Id='$user_Id' ");

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





    // UPDATE FACULTY - FACULTY_MGMT.PHP
	if(isset($_POST['update_faculty'])) {

		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		$age              = mysqli_real_escape_string($conn, $_POST['age']);
		$birthplace       = mysqli_real_escape_string($conn, $_POST['birthplace']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$civilstatus      = mysqli_real_escape_string($conn, $_POST['civilstatus']);
		$occupation       = mysqli_real_escape_string($conn, $_POST['occupation']);
		$religion		  = mysqli_real_escape_string($conn, $_POST['religion']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$contact		  = mysqli_real_escape_string($conn, $_POST['contact']);
		$house_no         = mysqli_real_escape_string($conn, $_POST['house_no']);
		$street_name      = mysqli_real_escape_string($conn, $_POST['street_name']);
		$purok            = mysqli_real_escape_string($conn, $_POST['purok']);
		$zone             = mysqli_real_escape_string($conn, $_POST['zone']);
		$barangay         = mysqli_real_escape_string($conn, $_POST['barangay']);
		$municipality     = mysqli_real_escape_string($conn, $_POST['municipality']);
		$province         = mysqli_real_escape_string($conn, $_POST['province']);
		$region           = mysqli_real_escape_string($conn, $_POST['region']);
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id'");
		$row = mysqli_fetch_array($get_email);
		$existing_email = $row['email'];

		if(empty($file)) {
			if($existing_email == $email) {

				$update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region' WHERE user_Id='$user_Id' ");

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
				$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				if(mysqli_num_rows($check) > 0) {
				   $_SESSION['message'] = "Email already exists!";
			       $_SESSION['text'] = "Please try again.";
			       $_SESSION['status'] = "error";
				   header("Location: faculty_mgmt.php?page=".$user_Id);
				} else {
					  $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region' WHERE user_Id='$user_Id' ");

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
				}
			}

		} else {

			if($existing_email == $email) {

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

					 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', image='$file' WHERE user_Id='$user_Id' ");

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

				

			} else {
				$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				if(mysqli_num_rows($check) > 0) {
				   $_SESSION['message'] = "Email already exists!";
			       $_SESSION['text'] = "Please try again.";
			       $_SESSION['status'] = "error";
				   header("Location: faculty_mgmt.php?page=".$user_Id);
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

							 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', image='$file' WHERE user_Id='$user_Id' ");

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





     // UPDATE SUPERVISORS - SUPERVISORS_MGMT.PHP
	if(isset($_POST['update_supervisors'])) {

		$user_Id		  = mysqli_real_escape_string($conn, $_POST['user_Id']);
		$firstname        = mysqli_real_escape_string($conn, $_POST['firstname']);
		$middlename       = mysqli_real_escape_string($conn, $_POST['middlename']);
		$lastname         = mysqli_real_escape_string($conn, $_POST['lastname']);
		$suffix           = mysqli_real_escape_string($conn, $_POST['suffix']);
		$dob              = mysqli_real_escape_string($conn, $_POST['dob']);
		$age              = mysqli_real_escape_string($conn, $_POST['age']);
		$birthplace       = mysqli_real_escape_string($conn, $_POST['birthplace']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$civilstatus      = mysqli_real_escape_string($conn, $_POST['civilstatus']);
		$occupation       = mysqli_real_escape_string($conn, $_POST['occupation']);
		$religion		  = mysqli_real_escape_string($conn, $_POST['religion']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$contact		  = mysqli_real_escape_string($conn, $_POST['contact']);
		$house_no         = mysqli_real_escape_string($conn, $_POST['house_no']);
		$street_name      = mysqli_real_escape_string($conn, $_POST['street_name']);
		$purok            = mysqli_real_escape_string($conn, $_POST['purok']);
		$zone             = mysqli_real_escape_string($conn, $_POST['zone']);
		$barangay         = mysqli_real_escape_string($conn, $_POST['barangay']);
		$municipality     = mysqli_real_escape_string($conn, $_POST['municipality']);
		$province         = mysqli_real_escape_string($conn, $_POST['province']);
		$region           = mysqli_real_escape_string($conn, $_POST['region']);
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id'");
		$row = mysqli_fetch_array($get_email);
		$existing_email = $row['email'];

		if(empty($file)) {
			if($existing_email == $email) {

				$update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region' WHERE user_Id='$user_Id' ");

              	  if($update) {
		          	$_SESSION['message'] = "Record has been updated!";
		            $_SESSION['text'] = "Saved successfully!";
			        $_SESSION['status'] = "success";
					header("Location: supervisors_mgmt.php?page=".$user_Id);
		          } else {
		            $_SESSION['message'] = "Something went wrong while updating the information.";
		            $_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: supervisors_mgmt.php?page=".$user_Id);
		          }

			} else {
				$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				if(mysqli_num_rows($check) > 0) {
				   $_SESSION['message'] = "Email already exists!";
			       $_SESSION['text'] = "Please try again.";
			       $_SESSION['status'] = "error";
				   header("Location: supervisors_mgmt.php?page=".$user_Id);
				} else {
					  $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region' WHERE user_Id='$user_Id' ");

	              	  if($update) {
			          	$_SESSION['message'] = "Record has been updated!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: supervisors_mgmt.php?page=".$user_Id);
			          } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: supervisors_mgmt.php?page=".$user_Id);
			          }
				}
			}

		} else {

			if($existing_email == $email) {

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
					header("Location: supervisors_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				} 

				// Check file size // 500KB max size
				elseif ($_FILES["fileToUpload"]["size"] > 500000) {
				  	$_SESSION['message']  = "File must be up to 500KB in size.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: supervisors_mgmt.php?page=".$user_Id);
					$uploadOk = 0;
				}

				// Allow certain file formats
				elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: supervisors_mgmt.php?page=".$user_Id);
				    $uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				elseif ($uploadOk == 0) {
				    $_SESSION['message'] = "Your file was not uploaded.";
				    $_SESSION['text'] = "Please try again.";
				    $_SESSION['status'] = "error";
					header("Location: supervisors_mgmt.php?page=".$user_Id);

				// if everything is ok, try to upload file
				} else {

					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

					 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', image='$file' WHERE user_Id='$user_Id' ");

	              	  if($update) {
			          	$_SESSION['message'] = "Record has been updated!";
			            $_SESSION['text'] = "Saved successfully!";
				        $_SESSION['status'] = "success";
						header("Location: supervisors_mgmt.php?page=".$user_Id);
			          } else {
			            $_SESSION['message'] = "Something went wrong while updating the information.";
			            $_SESSION['text'] = "Please try again.";
				        $_SESSION['status'] = "error";
						header("Location: supervisors_mgmt.php?page=".$user_Id);
			          }
						
					} else {
						$_SESSION['message'] = "There was an error uploading your profile picture.";
					    $_SESSION['text'] = "Please try again.";
					    $_SESSION['status'] = "error";
						header("Location: supervisors_mgmt.php?page=".$user_Id);
					}
				}

				

			} else {
				$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
				if(mysqli_num_rows($check) > 0) {
				   $_SESSION['message'] = "Email already exists!";
			       $_SESSION['text'] = "Please try again.";
			       $_SESSION['status'] = "error";
				   header("Location: supervisors_mgmt.php?page=".$user_Id);
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
							header("Location: supervisors_mgmt.php?page=".$user_Id);
							$uploadOk = 0;
						} 

						// Check file size // 500KB max size
						elseif ($_FILES["fileToUpload"]["size"] > 500000) {
						  	$_SESSION['message']  = "File must be up to 500KB in size.";
						    $_SESSION['text'] = "Please try again.";
						    $_SESSION['status'] = "error";
							header("Location: supervisors_mgmt.php?page=".$user_Id);
							$uploadOk = 0;
						}

						// Allow certain file formats
						elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
						    $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
						    $_SESSION['text'] = "Please try again.";
						    $_SESSION['status'] = "error";
							header("Location: supervisors_mgmt.php?page=".$user_Id);
						    $uploadOk = 0;
						}

						// Check if $uploadOk is set to 0 by an error
						elseif ($uploadOk == 0) {
						    $_SESSION['message'] = "Your file was not uploaded.";
						    $_SESSION['text'] = "Please try again.";
						    $_SESSION['status'] = "error";
							header("Location: supervisors_mgmt.php?page=".$user_Id);

						// if everything is ok, try to upload file
						} else {

							if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

							 $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', image='$file' WHERE user_Id='$user_Id' ");

			              	  if($update) {
					          	$_SESSION['message'] = "Record has been updated!";
					            $_SESSION['text'] = "Saved successfully!";
						        $_SESSION['status'] = "success";
								header("Location: supervisors_mgmt.php?page=".$user_Id);
					          } else {
					            $_SESSION['message'] = "Something went wrong while updating the information.";
					            $_SESSION['text'] = "Please try again.";
						        $_SESSION['status'] = "error";
								header("Location: supervisors_mgmt.php?page=".$user_Id);
					          }
								
							} else {
								$_SESSION['message'] = "There was an error uploading your profile picture.";
							    $_SESSION['text'] = "Please try again.";
							    $_SESSION['status'] = "error";
								header("Location: supervisors_mgmt.php?page=".$user_Id);
							}
						}
				}
			}
		}
	}





	// CHANGE SUPERVISORS PASSWORD - SUPERVISORS_DELETE.PHP
	if(isset($_POST['password_supervisors'])) {

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
				header("Location: supervisors.php");
    		} else {
    			$update_password = mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_Id='$user_Id' ");
    			if($update_password) {
        			$_SESSION['message'] = "Password has been changed.";
	           	    $_SESSION['text'] = "Updated successfully!";
			        $_SESSION['status'] = "success";
					header("Location: supervisors.php");
                } else {
          			$_SESSION['message'] = "Something went wrong while changing the password.";
            		$_SESSION['text'] = "Please try again.";
			        $_SESSION['status'] = "error";
					header("Location: supervisors.php");
                }
    		}
    	} else {
			$_SESSION['message']  = "Old password is incorrect.";
            $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: supervisors.php");
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
		$age              = mysqli_real_escape_string($conn, $_POST['age']);
		$birthplace       = mysqli_real_escape_string($conn, $_POST['birthplace']);
		$gender           = mysqli_real_escape_string($conn, $_POST['gender']);
		$civilstatus      = mysqli_real_escape_string($conn, $_POST['civilstatus']);
		$occupation       = mysqli_real_escape_string($conn, $_POST['occupation']);
		$religion		  = mysqli_real_escape_string($conn, $_POST['religion']);
		$email		      = mysqli_real_escape_string($conn, $_POST['email']);
		$contact		  = mysqli_real_escape_string($conn, $_POST['contact']);
		$house_no         = mysqli_real_escape_string($conn, $_POST['house_no']);
		$street_name      = mysqli_real_escape_string($conn, $_POST['street_name']);
		$purok            = mysqli_real_escape_string($conn, $_POST['purok']);
		$zone             = mysqli_real_escape_string($conn, $_POST['zone']);
		$barangay         = mysqli_real_escape_string($conn, $_POST['barangay']);
		$municipality     = mysqli_real_escape_string($conn, $_POST['municipality']);
		$province         = mysqli_real_escape_string($conn, $_POST['province']);
		$region           = mysqli_real_escape_string($conn, $_POST['region']);
		$file             = basename($_FILES["fileToUpload"]["name"]);

		$get_email = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id'");
		$row = mysqli_fetch_array($get_email);
		$existing_email = $row['email'];

		$check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_Id !='$user_Id' ");
		if(mysqli_num_rows($check) > 0) {
		   $_SESSION['message'] = "Email already exists!";
	       $_SESSION['text'] = "Please try again.";
	       $_SESSION['status'] = "error";
		   header("Location: profile.php");
		} else {

				if(empty($file)) {
					  $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region' WHERE user_Id='$user_Id' ");

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
				     
				              $update = mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', suffix='$suffix', dob='$dob', age='$age', email='$email', contact='$contact', birthplace='$birthplace', gender='$gender', civilstatus='$civilstatus', occupation='$occupation', religion='$religion', house_no='$house_no', street_name='$street_name', purok='$purok', zone='$zone', barangay='$barangay', municipality='$municipality', province='$province', region='$region', image='$file' WHERE user_Id='$user_Id' ");

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












?>
