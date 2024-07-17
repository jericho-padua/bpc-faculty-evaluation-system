<title>BPC Faculty Evaluation System | Section Records</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Section Records</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Section Records</li>
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
                <?php if($row['user_type'] == 'Admin'): ?>
                  <a href="section_mgmt.php?page=create" class="btn btn-sm bg-primary ml-2"><i class="fa-sharp fa-solid fa-square-plus"></i> New Section</a>
                <?php endif; ?>
                  <a href="section_print.php" class="btn btn-success btn-sm float-sm-right mr-2"><i class="fa-solid fa-print"></i> Print</a>
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
                    <th>YEAR LEVEL</th>
                    <th>SECTION NAME</th>
                    <th>COURSE</th>
                    <th>DATE CREATED</th>
                    <?php if($u_type == 'Admin'): ?>
                    <th>TOOLS</th>
                    <?php endif; ?>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php 
                        $sql = mysqli_query($conn, "SELECT * FROM section ");
                        while ($row = mysqli_fetch_array($sql)) {
                      ?>
                    <tr>
                        <td><?php echo $row['yr_level'] . "th year"; ?></td>
                        <td><?php echo $row['section']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td class="text-primary"><?php echo date("F d, Y", strtotime($row['date_created'])); ?></td>
                        <?php if($u_type == 'Admin'): ?>
                        <td>
                          <a class="btn btn-info btn-sm" href="section_mgmt.php?page=<?php echo $row['section_Id']; ?>"><i class="fas fa-pencil-alt"></i> Edit</a>
                          <button type="button" class="btn bg-danger btn-sm" data-toggle="modal" data-target="#delete<?php echo $row['section_Id']; ?>"><i class="fas fa-trash"></i> Delete</button>
                        </td> 
                        <?php endif; ?>
                    </tr>

                    <?php include 'section_delete.php'; } ?>

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

