<title>BPC Faculty Evaluation System | Student Records</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Student Records</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Student Records</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <?php if($u_type == 'Admin'): ?>
                  <!--<a href="users_mgmt.php?page=create" class="btn btn-sm bg-primary ml-2"><i class="fa-sharp fa-solid fa-square-plus"></i> New Student</a>-->
                <?php endif; ?>
                  <button type="button" class="btn btn-primary btn-sm float-sm-right mr-2" id="admitAllBtn">Admit All Students</button>
                  <a href="users_print.php" class="btn btn-success btn-sm float-sm-right mr-2"><i class="fa-solid fa-print"></i> Print</a>
                <!-- <div class="card-tools mr-1 mt-3">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div> -->
              </div>
              <div class="card-body p-3">

                 <table id="example11" class="table table-bordered table-hover text-sm">
                  <thead>
                  <tr>
                    <th>SCHOOL ID</th> 
                    <th>COURSE</th>
                    <th>NAME</th>
                    <th>GENDER</th>
                    <!-- <th>EMAIL/CONTACT</th> -->
                    <th>STATUS</th>
                    <th>DATE ADDED</th>
                    <th>TOOLS</th>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php 
                        $sql = mysqli_query($conn, "SELECT * FROM users WHERE user_type = 'Student' AND student_status=0 ");
                        while ($row = mysqli_fetch_array($sql)) {

                      ?>
                    <tr>
                        <td><?php echo $row['student_ID']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <!-- <td><?php //echo $row['email']; ?> <br> <span class="text-info"><?php //if($row['contact'] !== '') { echo '+63 '.$row['contact']; } ?></span></td> -->
                        <td>
                          <?php if($row['student_status'] == 0): ?>
                            <span class="badge bg-warning pt-1">Pending</span>
                          <?php elseif($row['student_status'] == 1): ?>
                            <span class="badge bg-success pt-1">Confirmed</span>
                          <?php else: ?>
                            <span class="badge bg-danger pt-1">Denied</span>
                          <?php endif; ?>
                        </td>
                        <td class="text-primary"><?php echo $row['date_registered']; ?></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="users_view.php?user_Id=<?php echo $row['user_Id']; ?>"><i class="fas fa-folder"></i> View</a>
                          <!--<a class="btn btn-info btn-sm" href="users_mgmt.php?page=<?php echo $row['user_Id']; ?>"><i class="fas fa-pencil-alt"></i> Edit</a>-->

                          <?php if($u_type == 'Admin'): ?>
                            <?php if($row['student_status'] == 0): ?>
                              <button type="button" class="btn bg-success btn-sm" data-toggle="modal" data-target="#verify<?php echo $row['user_Id']; ?>"><i class="fa-sharp fa-solid fa-circle-check"></i> Confirm</button>
                            <?php else: ?>
                              <button type="button" class="btn bg-success btn-sm" data-toggle="modal" data-target="#verify<?php echo $row['user_Id']; ?>" disabled><i class="fa-sharp fa-solid fa-circle-check"></i> Confirm</button>
                            <?php endif; ?>
                            
                            <!-- <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#password<?php //echo $row['user_Id']; ?>"><i class="fa-solid fa-lock"></i> Security</button> -->
                            <button type="button" class="btn bg-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $row['user_Id']; ?>"><i class="fas fa-trash"></i> Delete</button>
                          <?php endif; ?>

                        </td> 
                    </tr>

                    <?php include 'users_delete.php'; } ?>

                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php include 'footer.php';  ?>
<!-- <script>
  window.addEventListener("load", window.print());
</script> -->
<script>
document.getElementById("admitAllBtn").addEventListener("click", function() {
    if (confirm("Are you sure you want to admit all unverified students?")) {
        // AJAX call to update student_status for all unverified students
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Reload the page to reflect the changes
                location.reload();
            }
        };
        xhttp.open("POST", "admit_all_students.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=admit_all");
    }
});
</script>
