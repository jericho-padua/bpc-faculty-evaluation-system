<?php
    include '../config.php';
    if(isset($_SESSION['user_Id'])) {
      
      $id = $_SESSION['user_Id'];
      $users = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$id'");
      $row = mysqli_fetch_array($users);
      $logged_in = $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'];

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
  <link rel="shortcut icon" href="../images/bpc.ico">
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
    <img class="animation__shake" src="../images/bpc.ico" alt="logo" height="105" width="105">
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
        <a href="profile.php" class="nav-link">Home</a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="contact-us.php" class="nav-link">Contact</a>
      </li> -->
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

       <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <!-- <img src="../images-users/<?php echo $row['image']; ?>" alt="User Image" class="mr-3 img-circle" height="50" width="50"> -->
          <?php if($row['user_type'] != 'Student'): ?>
            <img src="../images-users/<?php echo $row['image']; ?>" class="user-image img-circle elevation-2" alt="User Image">
          <?php endif; ?>
          <span class="d-none d-md-inline"><?php echo ' '.$row['firstname'].' '.$row['lastname'].' '; ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <?php if($row['user_type'] == 'Student'): ?>
            <li class="user-headers p-3 bg-primary">
              <p class="text-center">
                <?php echo ' '.$row['firstname'].' '.$row['lastname'].' '; ?>
                <br><small><?php echo $row['user_type']; ?></small>
              </p>
            </li>
          <?php else: ?>
          <li class="user-header bg-primary">
            <img src="../images-users/<?php echo $row['image']; ?>" class="img-circle elevation-2" alt="User Image">
            <p>
              <?php echo ' '.$row['firstname'].' '.$row['lastname'].' '; ?>
              <small><?php echo $row['user_type']; ?></small>
            </p>
          </li>
          <?php endif; ?>

          
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
    <a href="#" class="brand-link">
      <img src="../images/bpc.ico" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">USERS</span>
      <br>
      <span style="font-size: 12px !important" class="text-sm ml-5 font-weight-light mt-2">&nbsp;&nbsp;Faculty Evaluation System</span>
      <br>
      <span class="badge badge-success text-xs ml-5 font-weight-light mt-2"><?php if(mysqli_num_rows($active) > 0) { echo $activeId['year'].': '.$activeId['semester']; } else { echo 'Evaluation: OFF'; } ?></span>
    </a>



    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-4 pb-2 pt-3 mb-3 d-flex">
        <div class="image">
          <?php //if($row['image'] == ""): ?>
          <img src="../dist/img/avatar.png" alt="User Avatar" class="img-size-50 img-circle">
          <?php //else: ?>
          <img src="../images-users/<?php //echo $row['image']; ?>" alt="User Image" style="height: 34px; width: 34px; border-radius: 50%;">
          <?php //endif; ?>
        </div>
        <div class="info">
          <a href="profile.php" class="d-block"><?php //echo ' '.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'].' '; ?></a>
        </div>
      </div> -->
      

      <!-- SidebarSearch Form -->
      <!--   <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-5">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          
       
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>"><i class="fa-solid fa-gauge"></i><p>&nbsp;&nbsp; Dashboard</p></a>
          </li>


          <?php if($row['user_type'] == 'Student') { ?>



              <!--EVALUATION TEACHERS (COMMENTS)-->
              <li class="nav-item">
                <a href="process_comments.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'process_comments.php') ? 'active' : ''; ?>"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Evaluate Faculty (Comments) </p></a>
              </li>

              <!--EVALUATION TEACHERS-->
              <li class="nav-item">
                <a href="process.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'process.php') ? 'active' : ''; ?>"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Evaluate Faculty </p></a>
              </li>

              
              
              <li class="nav-item">
              <?php 
                $evaluate2 = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.evaluated_by=users.user_Id WHERE evaluation.evaluated_by='$id' AND evaluation_status=1 AND acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1) AND user_type='Student'"); 
                if(mysqli_num_rows($evaluate2) > 0) { ?>
                  <a href="evaluate_history.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'evaluate_history.php') ? 'active' : ''; ?>"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Evaluation History</p></a>
              <?php } else { ?>
                  <a type="button" data-toggle="modal" data-target="#evaluation" class="nav-link"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Evaluation History</p></a>
              <?php } ?>
              </li>

          <?php 
              } else { 
                $evaluate = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.evaluated_by=users.user_Id WHERE evaluation.evaluated_by='$id' AND evaluation_status=1 AND acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1) AND user_type='Faculty'");
          ?>

              
              <?php if(mysqli_num_rows($evaluate) > 0) { ?>
                <li class="nav-item">
                  <a type="button" data-toggle="modal" data-target="#doneEvaluation" class="nav-link"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Evaluate</p></a>
                </li>
                <li class="nav-item">
                  <a href="evaluate_history.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'evaluate_history.php') ? 'active' : ''; ?>"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Evaluation History</p></a>
                </li>
              <?php } else { ?>
                <li class="nav-item">
                  <a href="process.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'process.php') ? 'active' : ''; ?>"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Evaluate Faculty</p></a>
                </li>
                <!--<li class="nav-item">
                  <a type="button" data-toggle="modal" data-target="#Evaluation" class="nav-link"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Evaluation history</p></a>
                </li>-->
              <?php } ?>



          <?php } ?>





          <?php if($row['user_type'] == 'Faculty'): ?>


          <li class="nav-item">
            <a href="evaluated_by.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'evaluated_by.php') ? 'active' : ''; ?>"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Faculty Summary (Students)</p></a>
          </li>

          <li class="nav-item">
            <a href="evaluated_bys.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'evaluated_bys.php') ? 'active' : ''; ?>"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Faculty Summary (Superior)</p></a>
          </li>

          <li class="nav-item">
            <a href="evaluated_byss.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'evaluated_byss.php') ? 'active' : ''; ?>"><i class="fa-solid fa-check-to-slot"></i><p>&nbsp;&nbsp; Faculty Overall</p></a>
          </li>
          <?php endif; ?>



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
            localStorage.removeItem("storedData");
            
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
