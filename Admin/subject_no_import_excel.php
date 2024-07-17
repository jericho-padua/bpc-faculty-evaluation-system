<title>BPC Faculty Evaluation System | Evaluation Records</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Subject records</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Evaluation Records</li>
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
                <a href="subject_mgmt.php?page=create" class="btn btn-sm bg-primary ml-2"><i class="fa-sharp fa-solid fa-square-plus"></i> New Subject</a>
                <?php endif; ?>
                <a href="subject_print.php" class="btn btn-success btn-sm float-sm-right mr-2"><i class="fa-solid fa-print"></i> Print</a>
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
                    <th>SUBJECT NAME</th>
                    <th>CODE</th>
                    <th>UNITS</th>
                    <th>INSTRUCTOR NAME</th>
                    <th>SECTION</th>
                    <th>DATE CREATED</th>
                    <?php if($u_type == 'Admin'): ?>
                    <th>TOOLS</th>
                    <?php endif; ?>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php 
                        $sql = mysqli_query($conn, "SELECT * FROM subject s JOIN users u ON s.instructor_Id=u.user_Id JOIN section sec ON s.section_Id=sec.section_Id ");
                        while ($row = mysqli_fetch_array($sql)) {
                      ?>
                    <tr>
                       
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['code']; ?></td>
                        <td><?php echo $row['units']; ?></td>
                        <td><?php echo ' '.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'].' '; ?></td>
                        <td><?php echo $row['yr_level'].' - '.$row['section']; ?></td>
                        <td class="text-primary"><?php echo date("F d, Y", strtotime($row['date_created'])); ?></td>
                        <?php if($u_type == 'Admin'): ?>
                        <td>
                          <a class="btn btn-info btn-sm" href="subject_mgmt.php?page=<?php echo $row['sub_Id']; ?>"><i class="fas fa-pencil-alt"></i> Edit</a>
                          <button type="button" class="btn bg-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $row['sub_Id']; ?>"><i class="fas fa-trash"></i> Delete</button>
                        </td> 
                        <?php endif; ?>
                    </tr>

                    <?php include 'subject_delete.php'; } ?>

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

