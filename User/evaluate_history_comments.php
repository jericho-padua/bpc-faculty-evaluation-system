<title>BPC Faculty Evaluation System | Evaluation History</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Evaluation History</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Evaluation History</li>
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
                <!-- <div class="card-tools mr-1 mt-1">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div> -->
                <!--<a href="evaluate_history_print.php" class="btn btn-success btn-sm float-sm-right mr-2"><i class="fa-solid fa-print"></i> Print</a>-->
              </div>
              <div class="card-body p-3">
                 <?php if($row['user_type'] == 'Student') { ?>

                 <table id="example11" class="table table-bordered table-hover text-sm">
                  <thead>
                  <tr> 
                    <th>INSTRUCTOR'S NAME</th>
                    <th>SUBJECT</th>
                    <th>RATINGS</th>
                    <th>EVALUATION DATE</th>
                    <th>TOOLS</th>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php 
                        $sql = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id JOIN subject ON evaluation.subject_Id=subject.sub_Id WHERE evaluation.evaluated_by='$id' AND evaluation.evaluation_status=1 AND evaluation.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1) ");
                        while ($row = mysqli_fetch_array($sql)) {
                            $a_total = $row['A_Total'];
                            $b_total = $row['B_Total'];
                            $c_total = $row['C_Total'];
                            $d_total = $row['D_Total'];
                            $avg_grand_total = $a_total + $b_total + $c_total + $d_total;
                            
                      ?>
                    <tr>
                       
                        <td><?php echo ' '.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'].' '; ?></td>
                        <td><?php echo $row['name']; ?></td>

                        <td>
                          <?php
                            
                            if ($avg_grand_total >= 65 && $avg_grand_total <= 80) {
                                echo '<span class="badge bg-danger pt-1">Outstanding</span>';
                            } elseif ($avg_grand_total >= 49 && $avg_grand_total <= 64) {
                                echo '<span class="badge bg-warning pt-1">Very Satisfactory</span>';
                            } elseif ($avg_grand_total >= 33 && $avg_grand_total <= 48) {
                                echo '<span class="badge bg-info pt-1">Satisfactory</span>';
                            } elseif ($avg_grand_total >= 17 && $avg_grand_total <= 32) {
                                echo '<span class="badge bg-success pt-1">Moderately Satisfactory</span>';
                            } elseif ($avg_grand_total >= 1 && $avg_grand_total <= 16) {
                                echo '<span class="badge bg-primary pt-1">Fair</span>';
                            } elseif ($avg_grand_total < 0) {
                                echo '<span class="badge bg-secondary pt-1">Poor</span>';
                            }
                            ?>
                        </td>
                        <td class="text-primary"><?php echo date("F d, Y h:i A", strtotime($row['date_evaluated'])); ?></td>
                        <td>


                          <a class="btn btn-primary btn-xs" href="evaluate_view.php?Id=<?php echo $row['Id']; ?>"><i class="fa-solid fa-eye"></i> View</a>
                        </td> 
                    </tr>

                    <?php } ?>

                  </tbody>
                 </table>

                 <?php } else { ?>

                  <table id="example11" class="table table-bordered table-hover text-sm">
                    <thead>
                    <tr> 
                      <th>INSTRUCTOR'S NAME</th>
                      <th>TOTAL SCORE</th>
                      <th>RATINGS</th>
                      <th>EVALUATION DATE</th>
                      <th>TOOLS</th>
                    </tr>
                    </thead>
                    <tbody id="users_data">
                        <?php 
                          $sql = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id WHERE evaluation.evaluated_by='$id' AND evaluation.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1) ");
                          while ($row = mysqli_fetch_array($sql)) {
                              $a_total = $row['A_Total'];
                              $b_total = $row['B_Total'];
                              $c_total = $row['C_Total'];
                              $d_total = $row['D_Total'];
                              $avg_grand_total = $a_total + $b_total + $c_total + $d_total;
                              
                        ?>
                      <tr>
                         
                          <td><?php echo ' '.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'].' '; ?></td>
                          <td>
                            <?php if($row['grand_total'] <= 40): ?>
                            <span class="badge bg-danger pt-1"><?php echo $row['grand_total']; ?> / 80</span>
                            <?php elseif($row['grand_total'] <= 55): ?>
                            <span class="badge bg-warning pt-1"><?php echo $row['grand_total']; ?> / 80</span>
                            <?php elseif($row['grand_total'] <= 75): ?>
                            <span class="badge bg-primary pt-1"><?php echo $row['grand_total']; ?> / 80</span>
                            <?php else: ?>
                            <span class="badge bg-success pt-1"><?php echo $row['grand_total']; ?> / 80</span>
                          <?php endif; ?>
                          </td>
                          <td>
                            <?php
                              
                              if ($avg_grand_total >= 75 && $avg_grand_total <= 80) {
                                  echo '<span class="badge bg-danger pt-1">Outstanding</span>';
                              } elseif ($avg_grand_total >= 70 && $avg_grand_total < 75) {
                                  echo '<span class="badge bg-warning pt-1">Very Satisfactory</span>';
                              } elseif ($avg_grand_total >= 65 && $avg_grand_total < 70) {
                                  echo '<span class="badge bg-info pt-1">Satisfactory</span>';
                              } elseif ($avg_grand_total >= 60 && $avg_grand_total < 65) {
                                  echo '<span class="badge bg-success pt-1">Moderately Satisfactory</span>';
                              } elseif ($avg_grand_total >= 55 && $avg_grand_total < 60) {
                                  echo '<span class="badge bg-primary pt-1">Fair</span>';
                              } elseif ($avg_grand_total < 55) {
                                  echo '<span class="badge bg-secondary pt-1">Poor</span>';
                              }
                              ?>
                          </td>
                          <td class="text-primary"><?php echo date("F d, Y h:i A", strtotime($row['date_evaluated'])); ?></td>
                          <td>
                            <a class="btn btn-primary btn-xs" href="evaluate_view.php?Id=<?php echo $row['Id']; ?>"><i class="fa-solid fa-eye"></i> View</a>
                          </td> 
                      </tr>

                      <?php } ?>

                    </tbody>
                   </table>


                 <?php } ?>
                <div class="container mt-5 ">                  
                  <div class="d-flex flex-column align-items-end">
                    <!--<p class="text-center ">__________________________________ <br><b>Signed and Approved by</b></p>-->
                  </div>
                </div>
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

