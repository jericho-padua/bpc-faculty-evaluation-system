<?php
include '../config.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $section_Id = mysqli_real_escape_string($conn, $_POST['section_Id']);
    $subject_Id = mysqli_real_escape_string($conn, $_POST['subject_Id']);
    $user_Id = mysqli_real_escape_string($conn, $_POST['user_Id']);

    $query = "SELECT com 
              FROM comment 
              WHERE section_Id='$section_Id' AND subject_Id='$subject_Id' AND user_Id='$user_Id'";
  
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['com'];
    } else {
        echo ""; // Return empty string if no comment found
    }
}
?>
