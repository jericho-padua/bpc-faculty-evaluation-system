<title>BPC Faculty Evaluation System | Evaluation History</title>
<?php 
    include 'navbar.php'; 

    // GET ACTIVE YEAR FOR EVALUATION
    $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
    $activeId = mysqli_fetch_array($active);

    // Split the academic year into two years
    $years = explode('-', $activeId['year']);


?>

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
               <button id="printButton" class="btn btn-success btn-sm float-sm-right mr-2"><i class="fa-solid fa-print"></i> Print</button>
                <a href="evaluated_by.php" type="button" class="btn btn-secondary btn-sm float-sm-right mr-2"><i class="fa-solid fa-backward"></i> Back</a>
              </div>
              
              <div class="card-body p-3">
                <div id="printElement">
                   <div class="row d-flex ">
                    <img src="../images/bpc.ico" alt="logo" width="100">
                        <p class="ml-2 mt-3">Bulacan Polytechnic College<br>Bulihan, City of Malolos, Bulacan <br> <span class="text-sm text-muted"><b>Printed by:</b> <?= $logged_in; ?> on <?= date('Y-m-d h:i A') ?></span></p>
                    </div>    
                    <hr>
                    <p class="text-center"><b>PEOPLE WHO EVALUATED YOU</b><br>
                      <?php 
                        if (count($years) === 2) {
                            $startYear = trim($years[0]);
                            $endYear = trim($years[1]);
                            echo '<p class="text-center">Rating Period: <span class="text-bold" style="text-decoration: underline;">'.$startYear.'</span> to <span class="text-bold" style="text-decoration: underline;">'.$endYear.'</span></p>';
                        } else {
                            // Handle the case where the data is not in the expected format
                            echo "<h6>Invalid academic year format</h6>";
                        }
                      ?>
                    </p>
                   <table id="" class="table table-bordered table-hover text-sm">
                    <thead>
                    <tr> 
                      <th>EVALUATOR'S NAME</th>
                      <th>SUBJECT</th>
                      <th>TOTAL SCORE</th>
                      <th>RATINGS</th>
                      <th>EVALUATION DATE</th>
                    </tr>
                    </thead>
                    <tbody id="users_data">
                        <?php 
                          $sql = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id JOIN subject ON evaluation.subject_Id=subject.sub_Id WHERE evaluation.user_Id='$id' AND evaluation.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1)");
                          if(mysqli_num_rows($sql) > 0) {
                          while ($row = mysqli_fetch_array($sql)) {
                            $evaluated_by = $row['evaluated_by'];
                            $sql2 = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$evaluated_by'");
                            $row2 = mysqli_fetch_array($sql2);

                        ?>
                      <tr>
                         
                          <td><?php echo ' '.$row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix'].' '; ?></td>
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
                              $grand_total = $row['grand_total'];
                              if ($grand_total >= 75 && $grand_total <= 80) {
                                  echo '<span class="badge bg-danger pt-1">Outstanding</span>';
                              } elseif ($grand_total >= 70 && $grand_total < 75) {
                                  echo '<span class="badge bg-warning pt-1">Very Satisfactory</span>';
                              } elseif ($grand_total >= 65 && $grand_total < 70) {
                                  echo '<span class="badge bg-info pt-1">Satisfactory</span>';
                              } elseif ($grand_total >= 60 && $grand_total < 65) {
                                  echo '<span class="badge bg-success pt-1">Moderately Satisfactory</span>';
                              } elseif ($grand_total >= 55 && $grand_total < 60) {
                                  echo '<span class="badge bg-primary pt-1">Fair</span>';
                              } elseif ($grand_total < 55) {
                                  echo '<span class="badge bg-secondary pt-1">Poor</span>';
                              }
                              ?>
                          </td>
                          <td class="text-primary"><?php echo date("F d, Y h:i A", strtotime($row['date_evaluated'])); ?></td>
                      </tr>
                      <?php } } else { ?>
                      <tr>
                        <td colspan="6" class="text-center">No record found</td>
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
   $(window).on('load', function() {
    document.getElementById("printButton").click();
   })
 </script>