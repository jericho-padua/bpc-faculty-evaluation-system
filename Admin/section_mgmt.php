<title>BPC Faculty Evaluation System | Section info</title>
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
            <h3>New Section</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Section info</li>
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
                    <span class="text-dark"><b>Year level</b></span>
                    <select class="form-control" name="yr_level" required>
                      <option selected disabled value="">Select level</option>
                      <option value="1">1st year</option>
                      <option value="2">2nd year</option>
                      <option value="3">3rd year</option>
                      <option value="4">4th year</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <span class="text-dark"><b>Section name</b></span>
                    <input type="text" class="form-control" placeholder="Enter section name" name="section" maxlength="1" onkeyup="lettersOnly(this)" pattern="[A-Z]" required>
                  </div>

                  <div class="form-group">
                    <span class="text-dark"><b>Course</b></span>
                    <select class="form-control" name="department" required>
                      <option selected disabled value="">Select Course</option>
                      <option value="BSIS">Bachelor of Science in Information Systems</option>
                      <option value="BSAIS">Bachelor of Science in Accounting Information Systems</option>
                      <option value="BSOM">Bachelor of Science in Office Management</option>
                      <option value="BTVTED">Bachelor of Technical-Vocational Teacher Education</option>
                    </select>
                  </div>

                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a href="section.php" class="btn bg-secondary"><i class="fa-solid fa-backward"></i> Back to list</a>
                    <button type="submit" class="btn bg-primary" name="create_section" id="create_admin"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
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
  $section_Id = $page;
  $fetch = mysqli_query($conn, "SELECT * FROM section WHERE section_Id='$section_Id'");
  $row = mysqli_fetch_array($fetch);

?>

  <!-- UPDATE -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3>Update Section</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Section info</li>
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
            <input type="hidden" class="form-control" name="section_Id" required value="<?php echo $section_Id; ?>">
            <div class="card">
              <div class="card-body">

                    <div class="form-group">
                      <span class="text-dark"><b>Year level</b></span>
                      <select class="form-control" name="yr_level" required>
                        <option selected disabled value="">Select level</option>
                        <option value="1" <?php if($row['yr_level'] == '1') { echo 'selected'; } ?>>1st year</option>
                        <option value="2" <?php if($row['yr_level'] == '2') { echo 'selected'; } ?>>2nd year</option>
                        <option value="3" <?php if($row['yr_level'] == '3') { echo 'selected'; } ?>>3rd year</option>
                        <option value="4" <?php if($row['yr_level'] == '4') { echo 'selected'; } ?>>4th year</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <span class="text-dark"><b>Section name</b></span>
                      <input type="text" class="form-control" placeholder="Enter section name" name="section" maxlength="1" onkeyup="lettersOnly(this)" pattern="[A-Z]" required value="<?php echo $row['section']; ?>">
                    </div>

                    <div class="form-group">
                      <span class="text-dark"><b>Course</b></span>
                      <select class="form-control" name="department" required>
                        <option selected disabled value="">Select Course</option>
                        <option value="BSIS" <?php if($row['department'] == 'BSIS') { echo 'selected'; } ?>>Bachelor of Science in Information Systems</option>
                        <option value="BSAIS" <?php if($row['department'] == 'BSAIS') { echo 'selected'; } ?>>Bachelor of Science in Accounting Information Systems</option>
                        <option value="BSOM" <?php if($row['department'] == 'BSOM') { echo 'selected'; } ?>>Bachelor of Science in Office Management</option>
                        <option value="BTVTED" <?php if($row['department'] == 'BTVTED') { echo 'selected'; } ?>>Bachelor of Technical-Vocational Teacher Education</option>
                      </select>
                    </div>

              </div>
              <div class="card-footer">
                <div class="float-right">
                  <a href="section.php" class="btn bg-secondary"><i class="fa-solid fa-backward"></i> Back to list</a>
                  <button type="submit" class="btn bg-primary" name="update_section" id="create_admin"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
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

