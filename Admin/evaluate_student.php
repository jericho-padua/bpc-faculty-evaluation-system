<title>BPC Faculty Evaluation System | Evaluation Results (Student)</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Evaluation Results (Student)</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Evaluation Results (Student)</li>
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
            <br><div class="card">
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
            <th>NO. OF STUDENTS EVALUATED</th>
            <th>SECTION</th>
            <th>INSTRUCTOR</th>
            <th>SUBJECT</th>
            <th>RATING</th>
            <th>TOOLS</th>
        </tr>
    </thead>
    <tbody id="users_data">
        <?php 
    // Initialize an associative array to store combined values
    $combinedValues = [];

    $sql = mysqli_query($conn, "
        SELECT *, evaluation.user_Id AS eval_user_Id
        FROM evaluation 
        LEFT JOIN users ON evaluation.evaluated_by = users.user_Id 
        LEFT JOIN subject ON evaluation.subject_Id = subject.sub_Id
        LEFT JOIN section ON evaluation.section_Id = section.section_Id  
        LEFT JOIN academic_year ON evaluation.acad_Id = academic_year.acad_Id
        WHERE evaluation.grand_total <= 80 AND evaluation.evaluation_status = 1 AND evaluation.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status = 1)");

    while ($row = mysqli_fetch_array($sql)) {
        $sectionInfo = $row['department'].' '.$row['yr_level'].' - '.$row['section'];
        $instructorId = $row['eval_user_Id'];
        $subjectInfo = $row['code'].' - '.$row['name'];

        // Create a unique key for the combination of section, instructor, and subject
        $key = $sectionInfo . "_" . $instructorId . "_" . $subjectInfo;

        // Calculate the total grand total
        $a_total = ($row['A_Total']/4);
        $b_total = ($row['B_Total']/5);
        $c_total = ($row['C_Total']/3);
        $d_total = ($row['D_Total']/4);
        $total_grand_total = ($a_total + $b_total + $c_total + $d_total);

        // Check if the key exists in the combinedValues array
        if (!isset($combinedValues[$key])) {
            // Initialize the combined values for this combination
            $combinedValues[$key] = [
                'total_grand_total' => 0,
                'count' => 0,
                'ids' => []  // Initialize an array to store IDs
            ];
        }

        // Add the total grand total to the combined values for this combination
        $combinedValues[$key]['total_grand_total'] += $total_grand_total;
        $combinedValues[$key]['count']++;
        
        // Store the ID in the combined values for this combination
        $combinedValues[$key]['ids'][] = $row['Id'];
    }

    // Display the combined values along with the student section information
    foreach ($combinedValues as $key => $values) {
        list($sectionInfo, $instructorId, $subjectInfo) = explode("_", $key);

        // Calculate the average score
        $avg_score = $values['total_grand_total'] / $values['count'];
        
        ?>
        <tr>
            <td><?php echo $values['count']; ?></td>
            <td><?php echo $sectionInfo; ?></td>
            <td>
                <?php 
                    $sql2 = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$instructorId'");
                    $row2 = mysqli_fetch_array($sql2);
                    echo $row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix'];
                ?>                          
            </td>
            <td><?php echo $subjectInfo; ?></td>
            <td>
                <?php
                if ($avg_score >= 16.4 && $avg_score <= 20) {
                echo '<span class="badge bg-danger pt-1">Outstanding</span>';
            } elseif ($avg_score >= 12.4 && $avg_score <= 16.3) {
                echo '<span class="badge bg-warning pt-1">Very Satisfactory</span>';
            } elseif ($avg_score >= 8.4 && $avg_score <= 12.3) {
                echo '<span class="badge bg-info pt-1">Satisfactory</span>';
            } elseif ($avg_score >= 4.4 && $avg_score <= 8.3) {
                echo '<span class="badge bg-success pt-1">Moderately Satisfactory</span>';
            } elseif ($avg_score >= 0.4 && $avg_score <= 4.3) {
                echo '<span class="badge bg-primary pt-1">Fair</span>';
            } elseif ($avg_score < 0) {
                echo '<span class="badge bg-secondary pt-1">Poor</span>';
            }
                ?>
            </td>
            <td>
                <a class="btn btn-primary btn-xs" href="evaluate_views_student.php?Id=<?php echo implode(',', $values['ids']); ?>"><i class="fa-solid fa-eye"></i> View</a>
            </td>
        </tr>
        <?php
    }
?>

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

