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
	                $name = $line[0];
	                $code = $line[1];
	                $units = $line[2];
	                $instructor_Id = $line[3];
	                $section_Id = $line[4];
	                $department = $line[5];

	                $prevQuery = "SELECT sub_Id FROM subject WHERE name = '".$line[1]."'";
	                $prevResult = $conn->query($prevQuery);

	                if($prevResult->num_rows > 0 ) {
	                    $conn->query("UPDATE subject SET name = '$name', code = '$code', units = '$units', instructor_Id = '$instructor_Id', section_Id = '$section_Id', department='$department'");
	                } else {
	                	// GET ACTIVE YEAR FOR EVALUATION
				        $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
				        $row = mysqli_fetch_array($active);
				        $acad_Id = $row['acad_Id'];

	                    $conn->query("INSERT INTO subject(name, code, units, instructor_Id, section_Id, acad_Id, department, date_created)
	                    VALUES ('$name', '$code', '$units', '$instructor_Id', '$section_Id', '$acad_Id', '$department', NOW() )");
	                   
	                }
	            }

	            fclose($csvFile);
	            $_SESSION['message'] = "CSV File successfully imported.";
		        $_SESSION['text'] = "Import successfully.";
		        $_SESSION['status'] = "success";
				header("Location: subject.php");
	        } else {
	            $_SESSION['message'] = "CSV File failed to import.";
		        $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: subject.php");
	        }
	    }else{
	        $_SESSION['message'] = "Invalid CSV File.";
	        $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: subject.php");
	    }
	}

?>