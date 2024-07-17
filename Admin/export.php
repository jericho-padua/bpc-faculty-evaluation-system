<?php 
	include '../config.php';
	include("XLSXLibrary.php");


	// SAVE ADMIN - ADMIN_MGMT.PHP
	if (isset($_POST['export_evaluation'])) {
      $year = mysqli_real_escape_string($conn, $_POST['year']);

      $visitor = [ ['No.', 'Instructor name', 'Section', 'Subject', 'Total Score', 'Ratings', 'Evaluation Date'] ];
 
 	    $id = 0;
      $sql = "SELECT *, subject.name, section.section, section.yr_level, AVG(evaluation.grand_total) AS avg_grand_total
            FROM evaluation 
            LEFT JOIN users ON evaluation.evaluated_by = users.user_Id 
            LEFT JOIN subject ON evaluation.subject_Id = subject.sub_Id 
            LEFT JOIN section ON evaluation.section_Id = section.section_Id
            LEFT JOIN academic_year ON evaluation.acad_Id = academic_year.acad_Id
            WHERE evaluation.evaluation_status = 1
            AND YEAR(evaluation.date_evaluated) = '$year'
            GROUP BY evaluation.user_Id, evaluation.subject_Id
            ORDER BY avg_grand_total DESC
            ";

  	  // $sql = "SELECT *, subject.name, section.section, section.yr_level, AVG(evaluation.grand_total) AS avg_grand_total
      //                   FROM evaluation
      //                   JOIN users ON evaluation.user_Id = users.user_Id
      //                   JOIN subject ON evaluation.subject_Id = subject.sub_Id
      //                   JOIN section ON evaluation.section_Id = section.section_Id
      //                   WHERE evaluation.evaluation_status = 1
      //                   AND YEAR(evaluation.date_evaluated) = '$year'
      //                   GROUP BY evaluation.user_Id, evaluation.subject_Id ";
      $res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($res) > 0) {
        foreach ($res as $row) {
          
          // EVALUATOR TYPE
          $section_Id = '';
          $subject_Id = '';
          if($row['section_Id'] == 0 AND $row['subject_Id'] == 0) {
            $section_Id = 'Evaluated by: '.$row['user_type'];
            $subject_Id = 'Evaluated by: '.$row['user_type'];
          } else {
            $section_Id = $row['yr_level'].' - '.$row['section'];
            $subject_Id = $row['name'];
          }
          $id++;
          $avg_grand_total = $row['avg_grand_total'];
          $evaluatedInstructorUserId = $row['user_Id'];
          $evaluatedInstructorQuery = mysqli_query($conn, "SELECT CONCAT(firstname, ' ', middlename, ' ', lastname, ' ', suffix) AS evaluatedInstructor FROM users WHERE user_Id = '$evaluatedInstructorUserId'");
          $evaluatedInstructorRow = mysqli_fetch_array($evaluatedInstructorQuery);

            $ratings = "";
	        if ($avg_grand_total >= 75 && $avg_grand_total <= 80) {
	            $ratings = "Outstanding";
	        } elseif ($avg_grand_total >= 70 && $avg_grand_total < 75) {
	            $ratings = "Very Satisfactory";
	        } elseif ($avg_grand_total >= 65 && $avg_grand_total < 70) {
	            $ratings = "Satisfactory";
	        } elseif ($avg_grand_total >= 60 && $avg_grand_total < 65) {
	            $ratings = "Moderately Satisfactory";
	        } elseif ($avg_grand_total >= 55 && $avg_grand_total < 60) {
	            $ratings = "Fair";
	        } elseif ($avg_grand_total < 55) {
	            $ratings = "Poor";
	        }

          $name = $evaluatedInstructorRow['evaluatedInstructor'];
          $visitor = array_merge($visitor, array(array($id, $name, $section_Id, $subject_Id, $row['avg_grand_total'].'/80', $ratings, date("F d, Y", strtotime($row['date_evaluated'])))));
        }
      } else {
        $_SESSION['message'] = "No record found in the database.";
        $_SESSION['text'] = "Please try again.";
        $_SESSION['status'] = "error";
        header("Location: evaluate_history.php");
      }

      $xlsx = SimpleXLSXGen::fromArray($visitor);
      $xlsx->downloadAs('Faculty Evaluation records.xlsx'); // This will download the file to your local system

      // $xlsx->saveAs('resident.xlsx'); // This will save the file to your server

      echo "<pre>";

      print_r($visitor);

      header('Location: evaluate_history.php');

	}








  // EXPORT STUDENT EVALUATORS
  if (isset($_POST['export_student_evaluators'])) {
      $year = mysqli_real_escape_string($conn, $_POST['year']);

      $visitor = [ ['No.', 'Evaluators', 'Instructor name', 'Section', 'Subject', 'Total Score', 'Ratings', 'Evaluation Date'] ];
 
    $id = 0;
      $sql = "SELECT *, subject.name, section.section, section.yr_level, AVG(evaluation.grand_total) AS avg_grand_total
                        FROM evaluation
                        JOIN users ON evaluation.evaluated_by = users.user_Id
                        JOIN subject ON evaluation.subject_Id = subject.sub_Id
                        JOIN section ON evaluation.section_Id = section.section_Id
                        WHERE users.user_type='Student' AND evaluation.evaluation_status = 1
                        AND YEAR(evaluation.date_evaluated) = '$year'
                        GROUP BY evaluation.evaluated_by, evaluation.subject_Id 
                        ORDER BY avg_grand_total DESC";
      $res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($res) > 0) {
        foreach ($res as $row) {
          $id++;
          $eval_by = $row['evaluated_by'];
          $get_evaluator = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$eval_by'");
          $row2 = mysqli_fetch_array($get_evaluator);
          $student_eval_name = $row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix'];

          $evaluatedInstructorUserId = $row['user_Id'];
          $evaluatedInstructorQuery = mysqli_query($conn, "SELECT CONCAT(firstname, ' ', middlename, ' ', lastname, ' ', suffix) AS evaluatedInstructor FROM users WHERE user_Id = '$evaluatedInstructorUserId'");
          $evaluatedInstructorRow = mysqli_fetch_array($evaluatedInstructorQuery);

            $avg_grand_total = $row['avg_grand_total'];
            $ratings = "";
          if ($avg_grand_total >= 75 && $avg_grand_total <= 80) {
              $ratings = "Outstanding";
          } elseif ($avg_grand_total >= 70 && $avg_grand_total < 75) {
              $ratings = "Very Satisfactory";
          } elseif ($avg_grand_total >= 65 && $avg_grand_total < 70) {
              $ratings = "Satisfactory";
          } elseif ($avg_grand_total >= 60 && $avg_grand_total < 65) {
              $ratings = "Moderately Satisfactory";
          } elseif ($avg_grand_total >= 55 && $avg_grand_total < 60) {
              $ratings = "Fair";
          } elseif ($avg_grand_total < 55) {
              $ratings = "Poor";
          }

          $name = $evaluatedInstructorRow['evaluatedInstructor'];
          $visitor = array_merge($visitor, array(array($id, $student_eval_name, $name, $row['yr_level'].' - '.$row['section'], $row['name'], $row['avg_grand_total'].'/80', $ratings, date("F d, Y", strtotime($row['date_evaluated'])))));
        }
      } else {
        $_SESSION['message'] = "No record found in the database.";
        $_SESSION['text'] = "Please try again.";
        $_SESSION['status'] = "error";
        header("Location: evaluator_students.php");
      }

      $xlsx = SimpleXLSXGen::fromArray($visitor);
      $xlsx->downloadAs('Student Evaluation For Faculties.xlsx'); // This will download the file to your local system

      // $xlsx->saveAs('resident.xlsx'); // This will save the file to your server

      echo "<pre>";

      print_r($visitor);

      header('Location: evaluator_students.php');

  }








  // EXPORT DEAN EVALUATORS
  if (isset($_POST['export_dean_evaluators'])) {
      $year = mysqli_real_escape_string($conn, $_POST['year']);

      $visitor = [ ['No.', 'Evaluators', 'Instructor name', 'Total Score', 'Ratings', 'Evaluation Date'] ];
 
      $id = 0;
      $sql = "SELECT *, AVG(grand_total) AS avg_grand_total
                        FROM evaluation
                        JOIN users ON evaluation.evaluated_by = users.user_Id
                        WHERE users.user_type='Dean' AND evaluation.evaluation_status = 1
                        AND YEAR(evaluation.date_evaluated) = '$year'
                        GROUP BY evaluation.evaluated_by
                        ORDER BY avg_grand_total DESC";
      $res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($res) > 0) {
        foreach ($res as $row) {
          $id++;
          $eval_by = $row['evaluated_by'];
          $get_evaluator = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$eval_by'");
          $row2 = mysqli_fetch_array($get_evaluator);
          $student_eval_name = $row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix'];

          $evaluatedInstructorUserId = $row['user_Id'];
          $evaluatedInstructorQuery = mysqli_query($conn, "SELECT CONCAT(firstname, ' ', middlename, ' ', lastname, ' ', suffix) AS evaluatedInstructor FROM users WHERE user_Id = '$evaluatedInstructorUserId'");
          $evaluatedInstructorRow = mysqli_fetch_array($evaluatedInstructorQuery);

            $avg_grand_total = $row['avg_grand_total'];
            $ratings = "";
          if ($avg_grand_total >= 75 && $avg_grand_total <= 80) {
              $ratings = "Outstanding";
          } elseif ($avg_grand_total >= 70 && $avg_grand_total < 75) {
              $ratings = "Very Satisfactory";
          } elseif ($avg_grand_total >= 65 && $avg_grand_total < 70) {
              $ratings = "Satisfactory";
          } elseif ($avg_grand_total >= 60 && $avg_grand_total < 65) {
              $ratings = "Moderately Satisfactory";
          } elseif ($avg_grand_total >= 55 && $avg_grand_total < 60) {
              $ratings = "Fair";
          } elseif ($avg_grand_total < 55) {
              $ratings = "Poor";
          }

          $name = $evaluatedInstructorRow['evaluatedInstructor'];
          $visitor = array_merge($visitor, array(array($id, $student_eval_name, $name, $row['avg_grand_total'].'/80', $ratings, date("F d, Y", strtotime($row['date_evaluated'])))));
        }
      } else {
        $_SESSION['message'] = "No record found in the database.";
        $_SESSION['text'] = "Please try again.";
        $_SESSION['status'] = "error";
        header("Location: evaluator_dean.php");
      }

      $xlsx = SimpleXLSXGen::fromArray($visitor);
      $xlsx->downloadAs('Dean Evaluators.xlsx'); // This will download the file to your local system

      // $xlsx->saveAs('resident.xlsx'); // This will save the file to your server

      echo "<pre>";

      print_r($visitor);

      header('Location: evaluator_dean.php');

  }









  // EXPORT DEAN EVALUATORS
  if (isset($_POST['export_faculty_evaluators'])) {
      $year = mysqli_real_escape_string($conn, $_POST['year']);

      $visitor = [ ['No.', 'Evaluators', 'Instructor name', 'Total Score', 'Ratings', 'Evaluation Date'] ];
 
      $id = 0;
      $sql = "SELECT *, AVG(grand_total) AS avg_grand_total
                        FROM evaluation
                        JOIN users ON evaluation.evaluated_by = users.user_Id
                        WHERE users.user_type='Faculty' AND evaluation.evaluation_status = 1
                        AND YEAR(evaluation.date_evaluated) = '$year'
                        GROUP BY evaluation.evaluated_by
                        ORDER BY avg_grand_total DESC";
      $res = mysqli_query($conn, $sql);
      if (mysqli_num_rows($res) > 0) {
        foreach ($res as $row) {
          $id++;
          $eval_by = $row['evaluated_by'];
          $get_evaluator = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$eval_by'");
          $row2 = mysqli_fetch_array($get_evaluator);
          $student_eval_name = $row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix'];

          $evaluatedInstructorUserId = $row['user_Id'];
          $evaluatedInstructorQuery = mysqli_query($conn, "SELECT CONCAT(firstname, ' ', middlename, ' ', lastname, ' ', suffix) AS evaluatedInstructor FROM users WHERE user_Id = '$evaluatedInstructorUserId'");
          $evaluatedInstructorRow = mysqli_fetch_array($evaluatedInstructorQuery);

            $avg_grand_total = $row['avg_grand_total'];
            $ratings = "";
          if ($avg_grand_total >= 75 && $avg_grand_total <= 80) {
              $ratings = "Outstanding";
          } elseif ($avg_grand_total >= 70 && $avg_grand_total < 75) {
              $ratings = "Very Satisfactory";
          } elseif ($avg_grand_total >= 65 && $avg_grand_total < 70) {
              $ratings = "Satisfactory";
          } elseif ($avg_grand_total >= 60 && $avg_grand_total < 65) {
              $ratings = "Moderately Satisfactory";
          } elseif ($avg_grand_total >= 55 && $avg_grand_total < 60) {
              $ratings = "Fair";
          } elseif ($avg_grand_total < 55) {
              $ratings = "Poor";
          }

          $name = $evaluatedInstructorRow['evaluatedInstructor'];
          $visitor = array_merge($visitor, array(array($id, $student_eval_name, $name, $row['avg_grand_total'].'/80', $ratings, date("F d, Y", strtotime($row['date_evaluated'])))));
        }
      } else {
        $_SESSION['message'] = "No record found in the database.";
        $_SESSION['text'] = "Please try again.";
        $_SESSION['status'] = "error";
        header("Location: evaluator_dean.php");
      }

      $xlsx = SimpleXLSXGen::fromArray($visitor);
      $xlsx->downloadAs('Faculty Evaluators.xlsx'); // This will download the file to your local system

      // $xlsx->saveAs('resident.xlsx'); // This will save the file to your server

      echo "<pre>";

      print_r($visitor);

      header('Location: evaluator_faculty.php');

  }




	
?>



