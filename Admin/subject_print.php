<title>BPC Faculty Evaluation System | Subject reports</title>
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
            <h1 class="m-0">Subject reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="profile.php">Home</a></li>
              <li class="breadcrumb-item active">Subject reports</li>
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
             <a href="subject.php" type="button" class="btn btn-secondary btn-sm float-sm-right mr-2"><i class="fa-solid fa-backward"></i> Back</a>
          </div>
            <div class="card-body">
              <div id="printElement">
                <div class="row d-flex ">
                    <img src="../images/bpc.ico" alt="logo" width="100">
                    <p class="ml-2 mt-3">Bulacan Polytechnic College<br>Bulihan, City of Malolos, Bulacan <br> <span class="text-sm text-muted"><b>Printed by:</b> <?= $printed_by; ?> on <?= date('Y-m-d h:i A') ?></span></p>
                </div>
                <hr>
                <p class="text-center"><b>SUBJECT RECORDS</b></p>
                <table id="example11" class="table table-bordered table-hover text-sm">
                  <thead>
                  <tr>
                    <th>#</th> 
                    <th>SUBJECT NAME</th>
                    <th>CODE</th>
                    <th>UNITS</th>
                    <th>INSTRUCTOR NAME</th>
                    <th>SECTION</th>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php
                        $i = 1;  
                        $sql = mysqli_query($conn, "SELECT * FROM subject ORDER BY name");
                        // $sql = mysqli_query($conn, "SELECT * FROM subject s JOIN users u ON s.instructor_Id=u.user_Id JOIN section sec ON s.section_Id=sec.section_Id ORDER BY name");
                        while ($row = mysqli_fetch_array($sql)) {
                      ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['code']; ?></td>
                        <td><?php echo $row['units']; ?></td>
                        <td>
                          <?php 
                              if (is_numeric($row['instructor_Id'])) {
                                  $ins_Id = $row['instructor_Id']; 
                                  $fetch = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$ins_Id'");
                                  $row2 = mysqli_fetch_array($fetch);
                                  echo $row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix'];
                              } else {
                                  echo $row['instructor_Id'];
                              }
                          ?>
                        </td>
                        <td>
                          <?php 
                              if (is_numeric($row['section_Id'])) {
                                  $sec_Id = $row['section_Id']; 
                                  $fetch2 = mysqli_query($conn, "SELECT * FROM section WHERE section_Id='$sec_Id'");
                                  $row2 = mysqli_fetch_array($fetch2);
                                  echo $row2['yr_level'].' - '.$row2['section'];
                              } else {
                                  echo $row['section_Id'];
                              }
                          ?>
                        </td>
                        <!-- <td><?php //echo ' '.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'].' '; ?></td> -->
                        <!-- <td><?php //echo $row['yr_level'].' - '.$row['section']; ?></td> -->
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