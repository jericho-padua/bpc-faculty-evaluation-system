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
              <div class="card-header p-2 text-center">
                <h5><b>People who evaluated you
                  <?php 
                    if (count($years) === 2) {
                        $startYear = trim($years[0]);
                        $endYear = trim($years[1]);
                        echo '<h6>Rating Period: <span class="text-bold" style="text-decoration: underline;">'.$startYear.'</span> to <span class="text-bold" style="text-decoration: underline;">'.$endYear.'</span></h6>';
                    } else {
                        // Handle the case where the data is not in the expected format
                        echo "<h6>Invalid academic year format</h6>";
                    }
                  ?></b>
                </h5>
              </div>
              <div class="card-body p-3">
                 <table id="example11" class="table table-bordered table-hover text-sm">
    <thead>
        <tr> 
            <th>NO. OF SUPERIOR EVALUATED</th>
            <th>INSTRUCTOR</th>
            <th>RATING</th>
            <th>TOOLS</th>
        </tr>
    </thead>
    <tbody id="users_data">
        <?php 
    // Initialize an associative array to store combined values
    $combinedValues = [];

    $sql = mysqli_query($conn, "
        SELECT *, evaluation_superior.user_Id AS eval_user_Id
        FROM evaluation_superior 
        LEFT JOIN users ON evaluation_superior.evaluated_by = users.user_Id 
        LEFT JOIN subject ON evaluation_superior.subject_Id = subject.sub_Id
        LEFT JOIN section ON evaluation_superior.section_Id = section.section_Id  
        LEFT JOIN academic_year ON evaluation_superior.acad_Id = academic_year.acad_Id
        WHERE evaluation_superior.grand_total <= 85 AND evaluation_superior.evaluation_status = 0 AND evaluation_superior.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status = 1)");

    while ($row = mysqli_fetch_array($sql)) {
        $sectionInfo = $row['department'].' '.$row['yr_level'].' - '.$row['section'];
        $instructorId = $row['eval_user_Id'];
        $subjectInfo = $row['code'].' - '.$row['name'];

        // Create a unique key for the combination of section, instructor, and subject
        $key = $sectionInfo . "_" . $instructorId . "_" . $subjectInfo;

        // Calculate the total grand total
        $a_total = ($row['A_Total']/9);
        $b_total = ($row['B_Total']/8);
        $total_grand_total = ($a_total + $b_total);

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

    // Display the combined values along with the superior section information
    foreach ($combinedValues as $key => $values) {
        list($sectionInfo, $instructorId, $subjectInfo) = explode("_", $key);

        // Calculate the average score
        $avg_score = $values['total_grand_total'] / $values['count'];

        // Determine the rating
        $rating = '';
        if ($avg_score >= 9 && $avg_score <= 10) {
            $rating = '<span class="badge bg-danger pt-1">Outstanding</span>';
        } elseif ($avg_score >= 7 && $avg_score <= 8) {
            $rating = '<span class="badge bg-warning pt-1">Very Satisfactory</span>';
        } elseif ($avg_score >= 5 && $avg_score <= 6) {
            $rating = '<span class="badge bg-info pt-1">Satisfactory</span>';
        } elseif ($avg_score >= 3 && $avg_score <= 4) {
            $rating = '<span class="badge bg-success pt-1">Moderately Satisfactory</span>';
        } elseif ($avg_score >= 1 && $avg_score <= 2) {
            $rating = '<span class="badge bg-primary pt-1">Fair</span>';
        } elseif ($avg_score < 0) {
            $rating = '<span class="badge bg-secondary pt-1">Poor</span>';
        }

        ?>
        <tr>
            <td><?php echo $values['count']; ?></td>
            <td>
                <?php 
                    $sql2 = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$instructorId'");
                    $row2 = mysqli_fetch_array($sql2);
                    echo $row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix'];
                ?>                          
            </td>
            <td><?php echo $rating; ?></td>
            <td>
                <a class="btn btn-primary btn-xs" href="evaluate_views_superior.php?Id=<?php echo implode(',', $values['ids']); ?>"><i class="fa-solid fa-eye"></i> View</a>
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
<!-- <script>
  window.addEventListener("load", window.print());
</script> -->

