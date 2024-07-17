<?php 
include '../config.php';
	

	
	// IMPORT CSV FILES
	if(isset($_POST['importSubmit'])){
	    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream',
	    'text/csv','application/excel','application/vnd.msexcel','text/plain');

	    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes )){

	        if(is_uploaded_file($_FILES['file']['tmp_name'])){
	            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
	            fgetcsv($csvFile);
	            while(($line =fgetcsv($csvFile) ) !== FALSE) {
	                $student_ID = $line[0];
	                $department = $line[1];
	                $firstname = $line[2];
	                $gender = $line[3];
	                $student_status = $line[4];
	                //$department = $line[5];

	                $prevQuery = "SELECT user_Id FROM users WHERE student_ID = '".$line[1]."'";
	                $prevResult = $conn->query($prevQuery);

	                if($prevResult->num_rows > 0 ) {
	                    $conn->query("UPDATE users SET student_ID = '$student_ID', department = '$department', firstname = '$firstname', gender = '$gender', student_status = '$student_status'");
	                } else {
	                	// GET ACTIVE YEAR FOR EVALUATION
				        $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
				        $row = mysqli_fetch_array($active);
				        //$acad_Id = $row['acad_Id'];

	                    $conn->query("INSERT INTO users(student_ID, department, firstname, gender, student_status, date_registered)
	                    VALUES ('$student_ID', '$department', '$firstname', '$gender', '$student_status', NOW() )");
	                   
	                }
	            }

	            fclose($csvFile);
	            $_SESSION['message'] = "CSV File successfully imported.";
		        $_SESSION['text'] = "Import successfully.";
		        $_SESSION['status'] = "success";
				header("Location: users_verified.php");
	        } else {
	            $_SESSION['message'] = "CSV File failed to import.";
		        $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: users_verified.php");
	        }
	    }else{
	        $_SESSION['message'] = "Invalid CSV File.";
	        $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: users_verified.php");
	    }
	}

?>