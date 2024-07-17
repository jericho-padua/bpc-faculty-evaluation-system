<title>BPC Faculty Evaluation System | Dashboard</title>
<?php include 'navbar.php'; ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="profile.php">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row d-flex justify-content-center">

          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <?php
                  $users = mysqli_query($conn, "SELECT * FROM evaluation_superior WHERE evaluated_by='$id' AND evaluation_status=0 AND acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1)");
                  $row_users = mysqli_num_rows($users);
                ?>
                <h3><?php echo $row_users; ?></h3>

                <p>Evaluated Faculty</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-check"></i>
              </div>
              <?php 
                $evaluate = mysqli_query($conn, "SELECT * FROM evaluation WHERE evaluated_by='$id' AND acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1)");
                if(mysqli_num_rows($evaluate) > 0) {
              ?>
                <a href="evaluate_history.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              <?php } else { ?>
                <a type="button" data-toggle="modal" data-target="#evaluation" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              <?php } ?>
              
            </div>
          </div>
          

        </div>
      </div>
    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include 'footer.php'; ?>
