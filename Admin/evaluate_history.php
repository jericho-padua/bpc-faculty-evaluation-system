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
                <!--<a href="evaluate_history_print.php" class="btn btn-success btn-sm float-sm-right mr-2"><i class="fa-solid fa-print"></i> Print</a>-->
                <!-- <div class="card-tools mr-1 mt-1">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div> -->
              <div class="card-body p-3">
                 <form method="POST" action="export.php">
                      <div class="row">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                              <div class="input-group">
                                  <div class="input-group-append">
                                  </div>
                              </div>
                          </div>
                      </div>
                 </form>
                 <table id="example11" class="table table-bordered table-hover text-sm">
                  <thead>
                  <tr> 
                    <th>EVALUATOR'S NAME</th>
                    <th>SECTION</th>
                    <th>INSTRUCTOR</th>
                    <th>SUBJECT</th>
                    <th>RATINGS</th>
                    <th>EVALUATION DATE</th>
                    <th>TOOLS</th>
                  </tr>
                  </thead>
                  <tbody id="users_data">
                      <?php 
                        $sql = mysqli_query($conn, "
                            SELECT *, evaluation.user_Id AS eval_user_Id 
                            FROM evaluation 
                            LEFT JOIN users ON evaluation.evaluated_by = users.user_Id 
                            LEFT JOIN subject ON evaluation.subject_Id = subject.sub_Id 
                            LEFT JOIN academic_year ON evaluation.acad_Id = academic_year.acad_Id
                            LEFT JOIN section ON evaluation.section_Id = section.section_Id
                            WHERE evaluation.grand_total<=80 AND evaluation.evaluation_status=1 AND evaluation.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1)");

                        while ($row = mysqli_fetch_array($sql)) {
                            $a_total = $row['A_Total'];
                            $b_total = $row['B_Total'];
                            $c_total = $row['C_Total'];
                            $d_total = $row['D_Total'];
                            $avg_grand_total = $a_total + $b_total + $c_total + $d_total;
                      ?>
                    <tr>
                       
                        <td><?php echo $row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix']; ?></td>
                         <td><?php echo $row['department'].' '.$row['yr_level'].' - '.$row['section']; ?></td>
                        <td>
                          <?php 
                            $evaluation_user_Id = $row['eval_user_Id'];
                            $sql2 = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$evaluation_user_Id'");
                            $row2 = mysqli_fetch_array($sql2);
                            echo $row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix'];
                          ?>                          
                        </td>
                        <td><?php echo $row['code'].' - '.$row['name']; ?></td>

                        <!--RATINGS-->
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
                        <a class="btn btn-info btn-xs <?php if ($u_type == 'Dean') {
                                                        echo 'd-none';
                                                      } ?>" href="evaluate_history_edit.php?Id=<?php echo $row['Id']; ?>"><i class="fas fa-pencil-alt"></i> Edit</a>
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

