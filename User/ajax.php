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
	// FETCH USERS WITH USERTYPE OF FACULTY - PROCESS.PHP (EVALUATE TEACHERS)
	if (isset($_POST['subject_Id'])) {
    $subject_Id = $_POST['subject_Id'];
    $evaluated_by = $_POST['evaluated_by']; // Retrieve the evaluated_by parameter

    // Retrieve the instructor for the selected subject
    $instructorQuery = mysqli_query($conn, "SELECT instructor_Id FROM subject WHERE sub_Id='$subject_Id'");
    $instructorRow = mysqli_fetch_assoc($instructorQuery);
    $instructor_Id = $instructorRow['instructor_Id'];

    // Check if the user has already evaluated the instructor of the selected subject
    $isEvaluated = mysqli_query($conn, "SELECT * FROM evaluation 
        WHERE evaluated_by='$evaluated_by' 
        AND user_Id='$instructor_Id' 
        AND subject_Id='$subject_Id'
        AND evaluation_status=1 
        AND acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1)");

    if (mysqli_num_rows($isEvaluated) > 0) {
        echo '<option value="" selected disabled>You have already evaluated the instructor assigned to this subject.</option>';
    } else {
        // Get all records from SUBJECT table with subject name equal to the subject ID in the POST method
        $instructors = mysqli_query($conn, "SELECT * FROM users JOIN subject ON users.user_Id=subject.instructor_Id WHERE subject.sub_Id='$subject_Id' AND users.faculty_status=0 AND users.is_deleted=0");

        if (mysqli_num_rows($instructors) > 0) {
            while ($row = mysqli_fetch_array($instructors)) {
                echo '<option value="'.$row['user_Id'].'" selected>'.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'].'</option>';
            }
        } else {
            echo '<option value="" selected>No instructor found</option>';
        }
    }
}

?>	