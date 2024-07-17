<?php 


	include '../config.php';


	// FETCH SUBJECTS UNDER SPECIFIC YEAR AND SECTION - PROCESS.PHP
	if (isset($_POST['section_Id'])) {
	  $section_Id = $_POST['section_Id'];

	  // GET DEPARTMENT FROM THE SELECTED SECTION
	  $get_sec = mysqli_query($conn, "SELECT * FROM section WHERE section_Id='$section_Id'");
	  $sec_name = mysqli_fetch_array($get_sec);
	  $name = $sec_name['department'];

	  // GET SUBJECTS UNDER THE SELECTED SECTION
	  $subjects = mysqli_query($conn, "SELECT * FROM subject WHERE section_Id = '$section_Id'");

	  if (mysqli_num_rows($subjects) > 0) {
	    while ($row = mysqli_fetch_array($subjects)) {
	      echo '<option value="'.$row['sub_Id'].'">'.$row['name'].'</option>';
	    }
	  } else {
	    echo '<option value="" selected>No subject found</option>';
	  }
	  
	  // Include department value in the response
	  echo '<input type="hidden" id="sec_department" value="'.$name.'" readonly>';
	}


	


	// FETCH USERS WITH USERTYPE OF FACULTY - PROCESS.PHP
	if (isset($_POST['subject_Id'])) {
	    $subject_Id = $_POST['subject_Id'];
	    $evaluated_by = $_POST['evaluated_by']; // Retrieve the evaluated_by parameter

	    // Check if the user is already evaluated by the signed-in user
	    $isEvaluated = mysqli_query($conn, "SELECT * FROM evaluation WHERE evaluated_by='$evaluated_by' AND evaluation_status=1 AND user_Id IN (SELECT instructor_Id FROM subject WHERE sub_Id='$subject_Id')");
	    if (mysqli_num_rows($isEvaluated) > 0) {
	        echo '<option value="" selected disabled>You have already evaluated the instructor assigned to this subject.</option>';
	    } else {
	        // GET ALL RECORDS FROM SUBJECT TABLE WITH SUBJECT NAME EQUAL TO THE SUBJECT ID IN THE POST METHOD
	        $instructors = mysqli_query($conn, "SELECT * FROM users JOIN subject ON users.user_Id=subject.instructor_Id WHERE subject.sub_Id='$subject_Id'  AND users.faculty_status=0 AND users.is_deleted=0 ");

	        if (mysqli_num_rows($instructors) > 0) {
	            // echo '<option value="" selected>Select instructor</option>';
	            while ($row = mysqli_fetch_array($instructors)) {
	                echo '<option value="'.$row['user_Id'].'" selected>'.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'].'</option>';
	            }
	        } else {
	            echo '<option value="" selected>No instructor found</option>';
	        }
	    }
	}


	

?>	




