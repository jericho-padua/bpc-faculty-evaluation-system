<title>BPC Faculty Evaluation System | Academic Year info</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Academic Year</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Academic Year info</li>
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
                <a href="academic_mgmt.php?page=create" class="btn btn-sm bg-primary ml-2"><i class="fa-sharp fa-solid fa-square-plus"></i> New Academic Year</a>
                <?php endif; ?>
                <a href="academic_print.php" class="btn btn-success btn-sm float-sm-right mr-2"><i class="fa-solid fa-print"></i> Print</a>
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
                    <th>ACADEMIC YEAR</th>
                    <th>SEMESTER</th>
                    <th>EVALUATION STATUS</th>
                    <th>DATE CREATED</th>
                    <?php if($u_type == 'Admin'): ?>
                    <th>TOOLS</th>
                    <?php endif; ?>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php 
                        $sql = mysqli_query($conn, "SELECT * FROM academic_year ");
                        while ($row = mysqli_fetch_array($sql)) {
                      ?>
                    <tr>
                       
                        <td><?php echo $row['year']; ?></td>
                        <td><?php echo $row['semester']; ?></td>
                        <td>
                          <?php if($row['status'] == 0): ?>
                                <span class="badge badge-dark pt-1">Off</span>
                          <?php else: ?>
                                <span class="badge badge-success pt-1">On-going</span>
                          <?php endif; ?>
                        </td>
                        <td class="text-primary"><?php echo date("F d, Y", strtotime($row['date_created'])); ?></td>
                        <?php if($u_type == 'Admin'): ?>
                        <td>
                          <a class="btn btn-info btn-sm" href="academic_mgmt.php?page=<?php echo $row['acad_Id']; ?>"><i class="fas fa-pencil-alt"></i> Edit</a>
                          <button type="button" class="btn bg-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $row['acad_Id']; ?>"><i class="fas fa-trash"></i> Delete</button>
                        </td> 
                        <?php endif; ?>
                    </tr>

                    <?php include 'academic_delete.php'; } ?>

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

