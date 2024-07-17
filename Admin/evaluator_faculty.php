<title>BPC Faculty Evaluation System | Faculty Evaluation History</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Faculty Evaluation History</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Faculty Evaluation History</li>
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
                <a href="evaluator_faculty_print.php" class="btn btn-success btn-sm float-sm-right mr-2"><i class="fa-solid fa-print"></i> Print</a>
                <!-- <div class="card-tools mr-1 mt-1">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div> -->
              </div>
              <div class="card-body p-3">
                 <form method="POST" action="export.php">
                      <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                              <div class="input-group">
                                  <div class="input-group-append">
                                      <div class="input-group-text">
                                          <i class="fa-solid fa-filter"></i>
                                      </div>
                                  </div>
                                  <select class="form-control form-control-sm small" name="year" required>
                                      <option selected value="">Export by year</option>
                                      <?php
                                        // Query to fetch distinct years from the date_evaluated column
                                        $yearQuery = mysqli_query($conn, "SELECT DISTINCT YEAR(date_evaluated) AS year FROM evaluation ORDER BY year");
                                        if(mysqli_num_rows($yearQuery) > 0 ) {
                                          while ($row = mysqli_fetch_assoc($yearQuery)) {
                                              $year = $row['year'];
                                              echo "<option value='$year'>$year</option>";
                                          }
                                        } else {
                                            echo "<option value='' selected disabled>No record found</option>";
                                        }
                                        
                                      ?>
                                  </select>
                                  <button type="submit" name="export_faculty_evaluators" class="ml-2 btn btn-success btn-sm float-right"><i class="fa-solid fa-file-excel"></i> Export</button>
                                  <button type="button" class="ml-2 btn btn-primary btn-sm float-right" onclick=location=URL><i class="fa-solid fa-arrows-rotate"></i> Refresh</button>
                              </div>
                          </div>
                      </div>
                 </form>
                 <table id="example11" class="table table-bordered table-hover text-sm table-sm">
                  <thead>
                  <tr> 
                    <th>EVALUATOR'S NAME</th>
                    <th>EVALUATEES</th>
                    <th>TOTAL SCORE</th>
                    <th>RATINGS</th>
                    <th>EVALUATION DATE</th>
                    <th>TOOLS</th>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php 
                        $sql = mysqli_query($conn, "SELECT *, AVG(grand_total) AS avg_grand_total
                        FROM 
                            evaluation
                        JOIN 
                            users ON evaluation.user_Id = users.user_Id
                        WHERE 
                            users.user_type = 'Faculty' 
                            AND evaluation.evaluation_status = 1
                            AND evaluation.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1)
                        GROUP BY 
                            evaluation.user_Id, 
                            users.user_Id, 
                            users.user_type
                        ");
                        while ($row = mysqli_fetch_array($sql)) {
                          $eval_by = $row['evaluated_by'];
                          $get_evaluator = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$eval_by'");
                          $row2 = mysqli_fetch_array($get_evaluator);
                      ?>
                    <tr>
                        <td><?php echo $row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix']; ?></td>
                        <td>
                          <?php
                            $evaluatedInstructorUserId = $row['user_Id'];
                            $evaluatedInstructorQuery = mysqli_query($conn, "SELECT CONCAT(firstname, ' ', middlename, ' ', lastname, ' ', suffix) AS evaluatedInstructor FROM users WHERE user_Id = '$evaluatedInstructorUserId'");
                            $evaluatedInstructorRow = mysqli_fetch_array($evaluatedInstructorQuery);
                            echo $evaluatedInstructorRow['evaluatedInstructor'];
                          ?>
                        </td>
                        <td>
                          <?php if($row['avg_grand_total'] <= 40): ?>
                          <span class="badge bg-danger pt-1"><?php echo number_format($row['avg_grand_total'], 2, '.', ','); ?> / 80</span>
                          <?php elseif($row['avg_grand_total'] <= 55): ?>
                          <span class="badge bg-warning pt-1"><?php echo number_format($row['avg_grand_total'], 2, '.', ','); ?> / 80</span>
                          <?php elseif($row['avg_grand_total'] <= 75): ?>
                          <span class="badge bg-primary pt-1"><?php echo number_format($row['avg_grand_total'], 2, '.', ','); ?> / 80</span>
                          <?php else: ?>
                          <span class="badge bg-success pt-1"><?php echo number_format($row['avg_grand_total'], 2, '.', ','); ?> / 80</span>
                        <?php endif; ?>
                        </td>
                        <td>
                          <?php
                            $avg_grand_total = $row['avg_grand_total'];
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

