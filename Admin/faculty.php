<title>BPC Faculty Evaluation System | Faculty Records</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Faculty Records</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Faculty Records</li>
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
                  <a href="faculty_mgmt.php?page=create" class="btn btn-sm bg-primary ml-2"><i class="fa-sharp fa-solid fa-square-plus"></i> New Faculty</a>
                <?php endif; ?>
                  <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="formToggle('importFrm');"><i class="fa-solid fa-file-import"></i> Import CSV</a>
                        <div class="upload bg-light p-2" id="importFrm" style="display:none;">
                            <form action="processes_faculty.php" method="post" enctype="multipart/form-data" id="uploadFrm" class="form-vertical">
                                <div class="form-group">
                                    <div class="d-flex">
                                        <input type="file" name="file" id="file" class="form-control" required>
                                        <button type="submit" class="btn btn-success btn-xs ml-2" name="importSubmit"><i class="fa-solid fa-upload"></i> Upload</button>
                                    </div>
                                </div>
                            </form>  
                        </div>
                  <a href="faculty_print.php" class="btn btn-success btn-sm float-sm-right mr-2"><i class="fa-solid fa-print"></i> Print</a>
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
                    <th>PHOTO</th>
                    <th>NAME</th>
                    <th>GENDER</th>
                    <th>EMAIL</th>
                    <th>STATUS</th>
                    <th>DATE ADDED</th>
                    <th>TOOLS</th>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php 
                        $sql = mysqli_query($conn, "SELECT * FROM users WHERE is_deleted=0 AND user_type = 'Faculty'");
                        while ($row = mysqli_fetch_array($sql)) {
                      ?>
                    <tr>
                        <td>
                            <a data-toggle="modal" data-target="#viewphoto<?php echo $row['user_Id']; ?>">
                              <img src="../images-users/<?php echo $row['image']; ?>" alt="" width="25" height="25" class="img-circle d-block m-auto">
                            </a href="">
                        </td>
                        <td><?php echo ' '.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'].' '; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                          <?php if($row['faculty_status'] == 0): ?>
                            <span class="badge badge-success pt-1">Active</span>
                          <?php else: ?>
                            <span class="badge badge-dark pt-1">Inactive</span>
                          <?php endif; ?>
                        </td> 
                        <td class="text-primary"><?php echo $row['date_registered']; ?></td>
                        <td>
                          <a class="btn btn-primary btn-sm" href="faculty_view.php?user_Id=<?php echo $row['user_Id']; ?>"><i class="fas fa-folder"></i> View</a>

                          <?php if($u_type == 'Admin'): ?>
                          <!--<a class="btn btn-info btn-sm" href="faculty_mgmt.php?page=<?php echo $row['user_Id']; ?>"><i class="fas fa-pencil-alt"></i> Edit</a>-->
                          <!-- <button type="button" class="btn bg-danger btn-sm" data-toggle="modal" data-target="#delete<?php //echo $row['user_Id']; ?>"><i class="fas fa-trash"></i> Delete</button> -->
                          <button type="button" class="btn bg-success btn-sm" data-toggle="modal" data-target="#active<?php echo $row['user_Id']; ?>" <?php if($row['faculty_status'] == 0) { echo 'disabled'; } ?>><i class="fas fa-pencil-alt"></i> Set Active</button>
                          <button type="button" class="btn bg-dark btn-sm" data-toggle="modal" data-target="#inactive<?php echo $row['user_Id']; ?>" <?php if($row['faculty_status'] == 1) { echo 'disabled'; } ?>><i class="fas fa-pencil-alt"></i> Set Inactive</button>
                          <!--<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#password<?php echo $row['user_Id']; ?>"><i class="fa-solid fa-lock"></i> Security</button>-->
                          <?php endif; ?>
                        </td> 
                    </tr>
                    <?php include 'faculty_delete.php'; } ?>
                     
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
  function formToggle(ID){
        var element = document.getElementById(ID);
        if(element.style.display === "none"){
            element.style.display = "block";
        } else{
            element.style.display = "none";
        }
    }
</script>