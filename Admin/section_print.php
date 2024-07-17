<title>BPC Faculty Evaluation System | Section reports</title>
<?php  
    include 'navbar.php'; 
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Section reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="profile.php">Home</a></li>
              <li class="breadcrumb-item active">Section reports</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card p-3">
          <div class="card-header">
            <button id="printButton" class="btn btn-success btn-sm float-sm-right mb-3"><i class="fa-solid fa-print"></i> Print</button>
             <a href="section.php" type="button" class="btn btn-secondary btn-sm float-sm-right mr-2"><i class="fa-solid fa-backward"></i> Back</a>
          </div>
            <div class="card-body">
              <div id="printElement">
                <div class="row d-flex ">
                    <img src="../images/bpc.ico" alt="logo" width="100">
                    <p class="ml-2 mt-3">Bulacan Polytechnic College<br>Bulihan, City of Malolos, Bulacan <br> <span class="text-sm text-muted"><b>Printed by:</b> <?= $printed_by; ?> on <?= date('Y-m-d h:i A') ?></span></p>
                </div>
                <hr>
                <p class="text-center"><b>SECTION RECORDS</b></p>
                <table id="example11" class="table table-bordered table-hover text-sm">
                  <thead>
                  <tr>
                    <th>#</th>  
                    <th>YEAR LEVEL</th>
                    <th>SECTION NAME</th>
                    <th>COURSE</th>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php
                        $i = 1;  
                        $sql = mysqli_query($conn, "SELECT * FROM section ORDER BY yr_level");
                        while ($row = mysqli_fetch_array($sql)) {
                      ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['yr_level']; ?></td>
                        <td><?php echo $row['section']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                    </tr>

                    <?php } ?>

                  </tbody>
                </table>
                <div class="container mt-5 ">
                  <hr>
                  <div class="d-flex flex-column align-items-end">
                    <p class="text-center ">__________________________________ <br><b>Signed and Approved by</b></p>
                  </div>
                </div>
              </div>
            </div>
          <div class="card-footer">
          </div>
        </div>
      </div>
    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include 'footer.php'; ?>

<script>
   $(window).on('load', function() {
    document.getElementById("printButton").click();
   })
 </script>