<?php
include '../config.php';

if (isset($_POST['action']) && $_POST['action'] == 'admit_all') {
    $sql = "UPDATE users SET student_status = 1 WHERE user_type = 'Student' AND student_status = 0";
    
    if (mysqli_query($conn, $sql)) {
        echo "All unverified students have been admitted.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
