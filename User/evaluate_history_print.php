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
             <a href="evaluate_history.php" type="button" class="btn btn-secondary btn-sm float-sm-right mr-2"><i class="fa-solid fa-backward"></i> Back</a>
          </div>
            <div class="card-body">
              <div id="printElement">
                <div class="row d-flex ">
                    <img src="../images/bpc.ico" alt="logo" width="100">
                    <p class="ml-2 mt-3">Bulacan Polytechnic College<br>Bulihan, City of Malolos, Bulacan <br> <span class="text-sm text-muted"><b>Printed by:</b> <?= $logged_in; ?> on <?= date('Y-m-d h:i A') ?></span></p>
                </div>
                <hr>
                <p class="text-center"><b>EVALUATION HISTORY RECORDS</b></p>
                <div class="table-responsive">

                  <?php if($row['user_type'] == 'Student') { ?>
                  
                  <table id="" class="table table-bordered table-hover table-sm text-sm">
                    <thead>
                    <tr> 
                      <th>INSTRUCTOR'S NAME</th>
                      <th>SUBJECT</th>
                      <th>TOTAL SCORE</th>
                      <th>RATINGS</th>
                      <th>EVALUATION DATE</th>
                    </tr>
                    </thead>
                    <tbody id="users_data">
                        <?php 
                          $sql = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id JOIN subject ON evaluation.subject_Id=subject.sub_Id WHERE evaluation.evaluated_by='$id' AND evaluation.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1) ");
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
                      </tr>

                      <?php } ?>

                    </tbody>
                  </table>

                  <?php } else { ?>

                  <table id="example11" class="table table-bordered table-hover table-sm text-sm">
                    <thead>
                    <tr> 
                      <th>INSTRUCTOR'S NAME</th>
                      <th>TOTAL SCORE</th>
                      <th>RATINGS</th>
                      <th>EVALUATION DATE</th>
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
                      </tr>

                      <?php } ?>

                    </tbody>
                   </table>

                  <?php } ?>
                </div>
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