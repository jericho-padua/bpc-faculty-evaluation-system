<title>BPC Faculty Evaluation System | Evaluation History Reports</title>
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
            <h1 class="m-0">Evaluation History Reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="profile.php">Home</a></li>
              <li class="breadcrumb-item active">Evaluation History Reports</li>
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
             <a href="evaluator_dean.php" type="button" class="btn btn-secondary btn-sm float-sm-right mr-2"><i class="fa-solid fa-backward"></i> Back</a>
          </div>
            <div class="card-body">
              <div id="printElement">
                <div class="row d-flex ">
                    <img src="../images/bpc.ico" alt="logo" width="100">
                    <p class="ml-2 mt-3">Bulacan Polytechnic College<br>Bulihan, City of Malolos, Bulacan <br> <span class="text-sm text-muted"><b>Printed by:</b> <?= $printed_by; ?> on <?= date('Y-m-d h:i A') ?></span></p>
                </div>
                <hr>
                <p class="text-center"><b>DEAN EVALUATOR RECORDS</b></p>
                <table id="" class="table table-bordered table-hover text-sm table-sm">
                  <thead>
                  <tr> 
                    <th>EVALUATOR'S NAME</th>
                    <th>EVALUATEES</th>
                    <th>TOTAL SCORE</th>
                    <th>RATINGS</th>
                    <th>EVALUATION DATE</th>
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
                            users.user_type = 'Dean' 
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