<?php
    include '../config.php';
    if(isset($_SESSION['admin_Id'])) {
      
      $id = $_SESSION['admin_Id'];
      $users = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$id'");
      $row = mysqli_fetch_array($users);
      $u_type = $row['user_type'];

      $printed_by = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

      // RECORD TIME LOGGED IN TO BE USED IN AUTO LOGOUT - CODE CAN BE FOUND ON FOOTER.PHP
      $_SESSION['last_active'] = time();

      // GET ACTIVE YEAR FOR EVALUATION
      $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
      $activeId = mysqli_fetch_array($active);

      $years = '';
      if(mysqli_num_rows($active) > 0) {
        // Split the academic year into two years
        $years = explode('-', $activeId['year']);
      }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BPC Faculty Evaluation System</title>
  <!---FAVICON ICON FOR WEBSITE--->
  <link rel="shortcut icon"  href="../images/bpc.ico">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Font Awesome -->
  <script src="../plugins/fontawesome-free/js/font-awesome-ni-erwin.js" crossorigin="anonymous"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <!-- <link rel="stylesheet" href="css/tempudsdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> -->
  <!-- iCheck -->
  <!-- <link rel="stylesheet" href="css/icheck-bootstrap/icheck-bootstrap.min.css"> -->
  <!-- JQVMap -->
  <!-- <link rel="stylesheet" href="css/jqvmap/jqvmap.min.css"> -->
  <!-- overlayScrollbars -->
  <!-- <link rel="stylesheet" href="css/overlayScrollbars/css/OverlayScrollbars.min.css"> -->
  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="css/daterangepicker/daterangepicker.css"> -->
  <!-- summernote -->
  <!-- <link rel="stylesheet" href="css/summernote/summernote-bs4.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Roboto', sans-serif;
  }
  .modal-content{
    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -moz-box-shadow: 0 5px 15px rgba(0,0,0,0);
    -o-box-shadow: 0 5px 15px rgba(0,0,0,0);
    box-shadow: 0 5px 15px rgba(0,0,0,0);
  }
</style>
</head>
<!-- LIGHT MODE -->
<!-- <body class="hold-transition sidebar-mini layout-fixed"> -->
<!-- DARK MODE -->
<!-- <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">  -->
<body class="hold-transition sidebar-mini  layout-fixed layout-navbar-fixed"> 
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../images/bpc.ico" alt="BMSLogo" height="105" width="105">
  </div>  -->

  <!-- Navbar -->
  <!-- LIGHT MODE -->
  <!-- <nav class="main-header navbar navbar-expand navbar-white navbar-light"> -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="contact-us.php" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <ul class="navbar-nav ml-auto">

       <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <!-- <img src="../images-users/<?php echo $row['image']; ?>" alt="User Image" class="mr-3 img-circle" height="50" width="50"> -->
          <img src="../images-users/<?php echo $row['image']; ?>" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?php echo ' '.$row['firstname'].' '.$row['lastname'].' '; ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="../images-users/<?php echo $row['image']; ?>" class="img-circle elevation-2" alt="User Image">
            <p>
              <?php echo ' '.$row['firstname'].' '.$row['lastname'].' '; ?>
              <small><?php echo $row['user_type']; ?></small>
            </p>
          </li>
          <!-- Menu Body -->
          <li class="user-body">
            <div class="row">
              <div class="col-12 text-center">
                <small>Member since <?php echo date("F d, Y", strtotime($row['date_registered'])); ?></small>
              </div>
              <!-- <div class="col-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Friends</a>
              </div> -->
            </div>
            <!-- /.row -->
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
            <a href="#" class="btn btn-default btn-flat float-right" onclick="logout()">Sign out</a>
          </li>
        </ul>
      </li>

      <!-- FULL SCREEN -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- END FULL SCREEN -->
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="../images/bpc.ico" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ADMIN</span>
      <br>
      <span style="font-size: 12px !important"class="text-sm ml-5 font-weight-light mt-2">&nbsp;&nbsp;Faculty Evaluation System</span>
      <br>
      <span class="badge badge-success text-xs ml-5 font-weight-light mt-2"><?php if(mysqli_num_rows($active) > 0) { echo $activeId['year'].': '.$activeId['semester']; } else { echo 'Evaluation: OFF'; } ?></span>
    </a>



    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-5">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          
       
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>"><i class="fa-solid fa-gauge"></i><p>&nbsp;&nbsp; Dashboard</p></a>
          </li>

          <li class="nav-header text-secondary" style="margin-bottom: -14px;">SYSTEM USERS</li>
          <!-- <li class="nav-item">
           <a href="admin.php" class="nav-link"><i class="fa-solid fa-user-secret"></i><p>&nbsp;&nbsp; Administrators</p></a>
          </li> -->
          <!-- <li class="nav-item">
           <a href="dean.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['dean.php', 'dean_mgmt.php', 'dean_view.php']) ? 'active' : '') ?>"><i class="fa-solid fa-chalkboard-user"></i><p>&nbsp; Dean</p></a>
          </li>-->
          
          <!--SUPERIOR-->
          <li class="nav-item">
           <a href="superior.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['superior.php', 'superior_mgmt.php', 'superior_view.php']) ? 'active' : '') ?>"><i class="fa-solid fa-user-tie"></i><p>&nbsp; Superior</p></a>
          </li>

          <!--FACULTY-->
          <li class="nav-item">
           <a href="faculty.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['faculty.php', 'faculty_mgmt.php', 'faculty_view.php']) ? 'active' : '') ?>"><i class="fa-solid fa-chalkboard-user"></i><p>&nbsp; Faculty</p></a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link 
              <?= (in_array(basename($_SERVER['PHP_SELF']), ['users.php', 'users_verified.php', 'users_denied.php', 'users_view.php', 'users_print.php', 'users_verified_print.php', 'users_denied_print.php']) ? 'active' : '') ?> "><i class="fa-solid fa-users-gear"></i><p>&nbsp;&nbsp;Student<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview"
              <?= (in_array(basename($_SERVER['PHP_SELF']), ['users.php', 'users_verified.php', 'users_denied.php', 'users_view.php', 'users_print.php', 'users_verified_print.php', 'users_denied_print.php']) ? 'style="display: block;"' : '') ?>
            >
              <li class="nav-item">
                <a href="users.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['users.php', 'users_print.php']) ? 'active' : '') ?>"><i class="fa-solid fa-users"></i><p>&nbsp;&nbsp; Unverified students</p></a>
              </li>
              <li class="nav-item">
                <a href="users_verified.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['users_verified.php', 'users_verified_print.php']) ? 'active' : '') ?>"><i class="fa-solid fa-users"></i><p>&nbsp;&nbsp; Verified students</p></a>
              </li>
              <li class="nav-item">
                <a href="users_denied.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['users_denied.php', 'users_denied_print.php']) ? 'active' : '') ?>"><i class="fa-solid fa-users"></i><p>&nbsp;&nbsp; Denied students</p></a>
              </li>
            </ul>
          </li>



         <!--  <li class="nav-item">
           <a href="users.php" class="nav-link <?php // echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active' : ''; ?>"><i class="fa-solid fa-users"></i><p>&nbsp; Student</p></a>
          </li>
 -->
          <!--<li class="nav-header text-secondary" style="margin-bottom: -14px;">SECTION</li>-->
          <li class="nav-item">
           <a href="section.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['section.php', 'section_mgmt.php']) ? 'active' : '') ?>"><i class="fa-solid fa-puzzle-piece"></i><p>&nbsp; Section</p></a>
          </li>

          <li class="nav-header text-secondary" style="margin-bottom: -14px;">MANAGE EVALUATION</li>
          <li class="nav-item">
           <a href="subject.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['subject.php', 'subject_mgmt.php']) ? 'active' : '') ?>"><i class="fa-solid fa-newspaper"></i><p>&nbsp; Evaluation </p></a>
          </li>
          <li class="nav-item">
           <a href="academic.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['academic.php', 'academic_mgmt.php']) ? 'active' : '') ?>"><i class="fa-solid fa-calendar-days"></i><p>&nbsp; Academic Year</p></a>
          </li>
 
          <!--<li class="nav-header text-secondary" style="margin-bottom: -14px;">CRITERIA FOR EVALUATION</li>
          <li class="nav-item">
           <a href="evaluate_print.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'evaluate_print.php') ? 'active' : ''; ?>"><i class="fa-solid fa-file"></i><p>&nbsp; Criteria</p></a>
          </li>-->

          <?php 
              if($row['user_type'] == 'Dean'){ 
              $evaluate = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.evaluated_by=users.user_Id WHERE evaluation.evaluated_by='$id' AND evaluation_status=1 AND evaluation.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1)");
          ?>
          <li class="nav-item">
            <?php if(mysqli_num_rows($evaluate) > 0) { ?>
              <a data-toggle="modal" data-target="#doneEvaluation" class="nav-link"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;Evaluate</p></a>
            <?php } else { ?>
              <a href="process.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['process.php', 'evaluate_dean.php']) ? 'active' : '') ?>"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;Evaluate</p></a>
            <?php } ?>
            
          </li>
          <?php } ?>


          <li class="nav-header text-secondary" style="margin-bottom: -14px;">EVALUATION HISTORY</li>
          <!--EVALUATION RESULTS (STUDENT)-->
          <li class="nav-item">
            <a href="evaluate_student.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluate_student.php', 'evaluate_views_student.php', 'evaluate_history_prints.php']) ? 'active' : '') ?>"><i class="fa-solid fa-check-to-slot"></i><p style="font-size: 14px;"> Evaluation Results (Student)</p></a>
          </li>

           <!--EVALUATION RESULTS (SUPERIOR)-->
          <li class="nav-item">
            <a href="evaluate_superior.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluate_superior.php', 'evaluate_views_superior.php', 'evaluate_history_prints.php']) ? 'active' : '') ?>"><i class="fa-solid fa-check-to-slot"></i><p style="font-size: 14px;"> Evaluation Results (Superior)</p></a>
          </li>

          <!--EVALUATION COMMENT (STUDENT)-->
          <li class="nav-item">
            <a href="evaluate_student_comment.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluate_student_comment.php', 'evaluate_views_student_comment.php']) ? 'active' : '') ?>"><i class="fa-solid fa-check-to-slot"></i><p style="font-size: 13.2px;"> Evaluation Comment (Student)</p></a>
          </li>


          <!--EVALUATION OVERALL-->
          <li class="nav-item">
            <a href="evaluate_overall.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluate_overall.php']) ? 'active' : '') ?>"><i class="fa-solid fa-check-to-slot"></i><p style="font-size: 14px;"> Evaluation Overall</p></a>
          </li>

          <!--EVALUATION HISTORY-->
          <!--<li class="nav-item">
            <a href="evaluate_history.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluate_history.php', 'evaluate_view.php', 'evaluate_history_print.php']) ? 'active' : '') ?>"><i class="fa-solid fa-check-to-slot"></i><p> Evaluation Overall</p></a>
          </li>-->


          <!--<li class="nav-header text-secondary" style="margin-bottom: -14px;">EVALUATORS</li>
          <li class="nav-item">
            <a href="#" class="nav-link 
              <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluator_dean.php', 'evaluator_faculty.php', 'evaluator_students.php']) ? 'active' : '') ?> "><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp;Evaluators<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview"
              <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluator_dean.php', 'evaluator_faculty.php', 'evaluator_students.php']) ? 'style="display: block;"' : '') ?>>
              <li class="nav-item">
                <a href="evaluator_dean.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluator_dean.php']) ? 'active' : '') ?>"><i class="fa-solid fa-check-to-slot"></i><p> Dean</p></a>
              </li>
              <li class="nav-item">
                <a href="evaluator_faculty.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluator_faculty.php']) ? 'active' : '') ?>"><i class="fa-solid fa-check-to-slot"></i><p> Faculty</p></a>
              </li>
              <li class="nav-item">
                <a href="evaluator_students.php" class="nav-link <?= (in_array(basename($_SERVER['PHP_SELF']), ['evaluator_students.php']) ? 'active' : '') ?>"><i class="fa-solid fa-check-to-slot"></i><p> Student</p></a>
              </li>
            </ul>
          </li>-->

          
          

          



          <!-- <li class="nav-header text-secondary" style="margin-bottom: -14px;">DATABASE</li>
          <li class="nav-item">
            <a href="#" class="nav-link"><i class="fa-solid fa-window-restore"></i><p>&nbsp;&nbsp;&nbsp; Back-up and Restore<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="backup.php" class="nav-link"><i class="fa-solid fa-users"></i><p>&nbsp; Back-up database</p></a>
              </li>
              <li class="nav-item">
                <a href="restore.php" class="nav-link"><i class="fa-solid fa-puzzle-piece"></i><p>&nbsp;&nbsp; Restore database</p></a>
              </li>
            </ul>
          </li> -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>



  <script>

    function logout() {
        swal({
          title: 'Are you sure you want to logout?',
          text: "You won't be able to revert this!",
          icon: "warning",
          buttons: true,
          // dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
          //   swal("Poof! Your imaginary file has been deleted!", {
          //   icon: "success",
          // }); 
            window.location = "../logout.php";
            
          } else {
            // swal("Poof! Your imaginary file has been deleted!", {
            //       icon: "info",
            //     }); 
          }
        });
    }
</script>

<script src="../sweetalert2.min.js"></script>
<?php include '../sweetalert_messages.php'; ?>

<?php
// ------------------------------CLOSING THE SESSION OF THE LOGGED IN USER WITH else statement----------//
    } else {
     header('Location: ../index.php');
    }
?>
