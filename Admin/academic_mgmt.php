<title>BPC Faculty Evaluation System | Academic Year info</title>
<?php 
    include 'navbar.php'; 
    if(isset($_GET['page'])) {
      $page = $_GET['page'];
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">



<?php if($page === 'create') { ?>

    <!-- CREATION -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>New Academic Year</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Academic Year info</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row d-flex justify-content-center">
          <div class="col-md-6">
            <form action="process_save.php" method="POST" enctype="multipart/form-data">
              <div class="card">
                <div class="card-body">
                
                <div class="form-group">
                  <div class="row">
                    <div class="col-6">
                      <span class="text-dark"><b>Academic Starting Year</b></span>
                      <input type="number" class="form-control" placeholder="Ex: 2022" name="year1" maxlength="4" max="9999" oninput="validateYear(this)" required>
                    </div>
                    <div class="col-6">
                      <span class="text-dark"><b>Academic Ending Year</b></span>
                      <input type="number" class="form-control" placeholder="Ex: 2023" name="year2" maxlength="4" max="9999" required readonly>
                    </div>
                  </div>                
                </div>

                <div class="form-group">
                  <span class="text-dark"><b>Semester</b></span>
                  <select class="form-control" name="semester" required>
                    <option selected disabled value="">Select semester</option>
                    <option value="1st Semester">1st Semester</option>
                    <option value="2nd Semester">2nd Semester</option>
                    <!--<option value="Mid-Year">Mid-Year</option>-->
                  </select>
                </div>

                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a href="academic.php" class="btn bg-secondary"><i class="fa-solid fa-backward"></i> Back to list</a>
                    <button type="submit" class="btn bg-primary" name="create_academic_year" id="create_admin"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  <!-- END CREATION -->



<?php } else { 
  $acad_Id = $page;
  $fetch = mysqli_query($conn, "SELECT * FROM academic_year WHERE acad_Id='$acad_Id'");
  $row = mysqli_fetch_array($fetch);
  $year = $row['year'];

  // Split the year value into two parts
  $yearParts = explode('-', $year);
  $year1 = $yearParts[0];
  $year2 = $yearParts[1];
?>

  <!-- UPDATE -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3>Update Administrator</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Administrator info</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row d-flex justify-content-center">
        <div class="col-md-6">
          <form action="process_update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" class="form-control" name="acad_Id" required value="<?php echo $acad_Id; ?>">
            <div class="card">
              <div class="card-body">

                  <div class="form-group">
                    <div class="row">
                      <div class="col-6">
                        <span class="text-dark"><b>Academic Starting Year</b></span>
                        <input type="number" class="form-control" placeholder="Ex: 2022" name="year1" maxlength="4" max="9999" oninput="validateYear(this)" required value="<?php echo $year1; ?>">
                      </div>
                      <div class="col-6">
                        <span class="text-dark"><b>Academic Ending Year</b></span>
                        <input type="number" class="form-control" placeholder="Ex: 2023" name="year2" maxlength="4" max="9999" required readonly value="<?php echo $year2; ?>">
                      </div>
                    </div>                
                  </div>

                  <div class="form-group">
                    <span class="text-dark"><b>Semester</b></span>
                    <select class="form-control" name="semester" required>
                      <option selected disabled value="">Select semester</option>
                      <option value="1st Semester" <?php if($row['semester'] == '1st Semester') { echo 'selected'; } ?>>1st Semester</option>
                      <option value="2nd Semester" <?php if($row['semester'] == '2nd Semester') { echo 'selected'; } ?>>2nd Semester</option>
                      <!--<option value="Mid-Year"     <?php //if($row['semester'] == 'Mid-Year') { echo 'selected'; } ?>>Mid-Year</option>-->
                    </select>
                  </div>

                  

                  <div class="form-group">
                    <span class="text-dark"><b>Status</b></span>
                    <select class="form-control" name="status" required>
                      <option selected disabled value="">Select status</option>
                      <option value="0" <?php if($row['status'] == 0) { echo 'selected'; } ?>>Off</option>
                      <option value="1" <?php if($row['status'] == 1) { echo 'selected'; } ?>>On-going</option>
                    </select>
                  </div>

              </div>
              <div class="card-footer">
                <div class="float-right">
                  <a href="academic.php" class="btn bg-secondary"><i class="fa-solid fa-backward"></i> Back to list</a>
                  <button type="submit" class="btn bg-primary" name="update_academic_year" id="create_admin"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- END UPDATE -->


<?php } ?>


  </div>

<?php } else { include '404.php'; } ?>


<br>
<br>
<br>
<br>
<br>
<br>
<?php include 'footer.php';  ?>

