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
	                $image = $line[0];
	                $firstname = $line[1];
	                $gender = $line[2];
	                $email = $line[3];
	                $superior_status = $line[4];
	                $user_type = $line[5];

	                $prevQuery = "SELECT user_Id FROM users WHERE image = '".$line[1]."'";
	                $prevResult = $conn->query($prevQuery);

	                if($prevResult->num_rows > 0 ) {
	                    $conn->query("UPDATE users SET image = '$image', firstname = '$firstname', gender = '$gender', email = '$email', superior_status = '$superior_status', user_type = '$user_type'");
	                } else {
	                	// GET ACTIVE YEAR FOR EVALUATION
				        $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
				        $row = mysqli_fetch_array($active);
				        //$acad_Id = $row['acad_Id'];

	                    $conn->query("INSERT INTO users(image, firstname, gender, email, superior_status, user_type, date_registered)
	                    VALUES ('$image', '$firstname', '$gender', '$email', '$superior_status', '$user_type', NOW() )");
	                   
	                }
	            }

	            fclose($csvFile);
	            $_SESSION['message'] = "CSV File successfully imported.";
		        $_SESSION['text'] = "Import successfully.";
		        $_SESSION['status'] = "success";
				header("Location: superior.php");
	        } else {
	            $_SESSION['message'] = "CSV File failed to import.";
		        $_SESSION['text'] = "Please try again.";
		        $_SESSION['status'] = "error";
				header("Location: superior.php");
	        }
	    }else{
	        $_SESSION['message'] = "Invalid CSV File.";
	        $_SESSION['text'] = "Please try again.";
	        $_SESSION['status'] = "error";
			header("Location: superior.php");
	    }
	}

?>