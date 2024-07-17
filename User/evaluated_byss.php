<title>BPC Faculty Evaluation System | Evaluation Overall</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Evaluation Overall</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Evaluation Overall</li>
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
            <th>INSTRUCTOR</th>
            <th>OVERALL AVERAGE</th>
            <th>RATING</th>
        </tr>
    </thead>
    <tbody id="users_data">
        <?php
        $check_eval = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.evaluated_by=users.user_Id ");
        $r_check_eval = mysqli_fetch_array($check_eval);

        $faculty = '';
        if($r_check_eval['user_type'] == 'Faculty') {
            $faculty = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id  ");
            $faculty = mysqli_query($conn, "SELECT * FROM evaluation_superior JOIN users ON evaluation_superior.user_Id=users.user_Id  ");
        } else {
            $faculty = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id JOIN subject ON evaluation.subject_Id=subject.sub_Id JOIN section ON evaluation.section_Id=section.section_Id ");

        }

        $fac = mysqli_fetch_array($faculty);

        // GET ACTIVE YEAR FOR EVALUATION
        $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
        $activeId = mysqli_fetch_array($active); 

        // Calculate average scores
        $avg_scores = [
            'A' => ($fac['A_Total'] / 4),
            'B' => ($fac['B_Total'] / 5),
            'C' => ($fac['C_Total'] / 3),
            'D' => ($fac['D_Total'] / 4),
        ];

        // Fetch all A1 scores for the same section and subject
        $sectionId = $fac['section_Id'];
        $subjectId = $fac['subject_Id'];

        $allA1ScoresQuery = "SELECT A1 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allA1ScoresResult = mysqli_query($conn, $allA1ScoresQuery);
        
        $totalA1 = 0;
        $numStudents = 0;

        while ($row = mysqli_fetch_assoc($allA1ScoresResult)) {
            $totalA1 += $row['A1'];
            $numStudents++;
        }

        $avgA1 = ($numStudents > 0) ? $totalA1 / $numStudents : 0;

        // Fetch all A2 scores for the same section and subject
        $allA2ScoresQuery = "SELECT A2 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allA2ScoresResult = mysqli_query($conn, $allA2ScoresQuery);

        $totalA2 = 0;
        $numStudentsA2 = 0;

        while ($row = mysqli_fetch_assoc($allA2ScoresResult)) {
            $totalA2 += $row['A2'];
            $numStudentsA2++;
        }

        $avgA2 = ($numStudentsA2 > 0) ? $totalA2 / $numStudentsA2 : 0;

        // Fetch all A3 scores for the same section and subject
        $allA3ScoresQuery = "SELECT A3 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allA3ScoresResult = mysqli_query($conn, $allA3ScoresQuery);

        $totalA3 = 0;
        $numStudentsA3 = 0;

        while ($row = mysqli_fetch_assoc($allA3ScoresResult)) {
            $totalA3 += $row['A3'];
            $numStudentsA3++;
        }

        $avgA3 = ($numStudentsA3 > 0) ? $totalA3 / $numStudentsA3 : 0;

        // Fetch all A4 scores for the same section and subject
        $allA4ScoresQuery = "SELECT A4 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allA4ScoresResult = mysqli_query($conn, $allA4ScoresQuery);

        $totalA4 = 0;
        $numStudentsA4 = 0;

        while ($row = mysqli_fetch_assoc($allA4ScoresResult)) {
            $totalA4 += $row['A4'];
            $numStudentsA4++;
        }

        $avgA4 = ($numStudentsA4 > 0) ? $totalA4 / $numStudentsA4 : 0;

        // Fetch all B1 scores for the same section and subject
        $allB1ScoresQuery = "SELECT B1 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allB1ScoresResult = mysqli_query($conn, $allB1ScoresQuery);
        
        $totalB1 = 0;
        $numStudentsB1 = 0;

        while ($row = mysqli_fetch_assoc($allB1ScoresResult)) {
            $totalB1 += $row['B1'];
            $numStudentsB1++;
        }

        $avgB1 = ($numStudentsB1 > 0) ? $totalB1 / $numStudentsB1 : 0;

        // Fetch all B2 scores for the same section and subject
        $allB2ScoresQuery = "SELECT B2 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allB2ScoresResult = mysqli_query($conn, $allB2ScoresQuery);

        $totalB2 = 0;
        $numStudentsB2 = 0;

        while ($row = mysqli_fetch_assoc($allB2ScoresResult)) {
            $totalB2 += $row['B2'];
            $numStudentsB2++;
        }

        $avgB2 = ($numStudentsB2 > 0) ? $totalB2 / $numStudentsB2 : 0;

        // Fetch all B3 scores for the same section and subject
        $allB3ScoresQuery = "SELECT B3 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allB3ScoresResult = mysqli_query($conn, $allB3ScoresQuery);

        $totalB3 = 0;
        $numStudentsB3 = 0;

        while ($row = mysqli_fetch_assoc($allB3ScoresResult)) {
            $totalB3 += $row['B3'];
            $numStudentsB3++;
        }

        $avgB3 = ($numStudentsB3 > 0) ? $totalB3 / $numStudentsB3 : 0;

        // Fetch all B4 scores for the same section and subject
        $allB4ScoresQuery = "SELECT B4 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allB4ScoresResult = mysqli_query($conn, $allB4ScoresQuery);

        $totalB4 = 0;
        $numStudentsB4 = 0;

        while ($row = mysqli_fetch_assoc($allB4ScoresResult)) {
            $totalB4 += $row['B4'];
            $numStudentsB4++;
        }

        $avgB4 = ($numStudentsB4 > 0) ? $totalB4 / $numStudentsB4 : 0;

        // Fetch all B5 scores for the same section and subject
        $allB5ScoresQuery = "SELECT B5 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allB5ScoresResult = mysqli_query($conn, $allB5ScoresQuery);

        $totalB5 = 0;
        $numStudentsB5 = 0;

        while ($row = mysqli_fetch_assoc($allB5ScoresResult)) {
            $totalB5 += $row['B5'];
            $numStudentsB5++;
        }

        $avgB5 = ($numStudentsB5 > 0) ? $totalB5 / $numStudentsB5 : 0;

        // Fetch all C1 scores for the same section and subject
        $allC1ScoresQuery = "SELECT C1 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allC1ScoresResult = mysqli_query($conn, $allC1ScoresQuery);
        
        $totalC1 = 0;
        $numStudentsC1 = 0;

        while ($row = mysqli_fetch_assoc($allC1ScoresResult)) {
            $totalC1 += $row['C1'];
            $numStudentsC1++;
        }

        $avgC1 = ($numStudentsC1 > 0) ? $totalC1 / $numStudentsC1 : 0;

        // Fetch all C2 scores for the same section and subject
        $allC2ScoresQuery = "SELECT C2 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allC2ScoresResult = mysqli_query($conn, $allC2ScoresQuery);

        $totalC2 = 0;
        $numStudentsC2 = 0;

        while ($row = mysqli_fetch_assoc($allC2ScoresResult)) {
            $totalC2 += $row['C2'];
            $numStudentsC2++;
        }

        $avgC2 = ($numStudentsC2 > 0) ? $totalC2 / $numStudentsC2 : 0;

        // Fetch all C3 scores for the same section and subject
        $allC3ScoresQuery = "SELECT C3 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allC3ScoresResult = mysqli_query($conn, $allC3ScoresQuery);

        $totalC3 = 0;
        $numStudentsC3 = 0;

        while ($row = mysqli_fetch_assoc($allC3ScoresResult)) {
            $totalC3 += $row['C3'];
            $numStudentsC3++;
        }

        $avgC3 = ($numStudentsC3 > 0) ? $totalC3 / $numStudentsC3 : 0;

         // Fetch all D1 scores for the same section and subject
        $allD1ScoresQuery = "SELECT D1 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allD1ScoresResult = mysqli_query($conn, $allD1ScoresQuery);
        
        $totalD1 = 0;
        $numStudentsD1 = 0;

        while ($row = mysqli_fetch_assoc($allD1ScoresResult)) {
            $totalD1 += $row['D1'];
            $numStudentsD1++;
        }

        $avgD1 = ($numStudentsD1 > 0) ? $totalD1 / $numStudentsD1 : 0;

        // Fetch all D2 scores for the same section and subject
        $allD2ScoresQuery = "SELECT D2 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allD2ScoresResult = mysqli_query($conn, $allD2ScoresQuery);
        
        $totalD2 = 0;
        $numStudentsD2 = 0;

        while ($row = mysqli_fetch_assoc($allD2ScoresResult)) {
            $totalD2 += $row['D2'];
            $numStudentsD2++;
        }

        $avgD2 = ($numStudentsD2 > 0) ? $totalD2 / $numStudentsD2 : 0;

        // Fetch all D3 scores for the same section and subject
        $allD3ScoresQuery = "SELECT D3 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allD3ScoresResult = mysqli_query($conn, $allD3ScoresQuery);
        
        $totalD3 = 0;
        $numStudentsD3 = 0;

        while ($row = mysqli_fetch_assoc($allD3ScoresResult)) {
            $totalD3 += $row['D3'];
            $numStudentsD3++;
        }

        $avgD3 = ($numStudentsD3 > 0) ? $totalD3 / $numStudentsD3 : 0;

        // Fetch all D4 scores for the same section and subject
        $allD4ScoresQuery = "SELECT D4 FROM evaluation WHERE section_Id='$sectionId' AND subject_Id='$subjectId'";
        $allD4ScoresResult = mysqli_query($conn, $allD4ScoresQuery);
        
        $totalD4 = 0;
        $numStudentsD4 = 0;

        while ($row = mysqli_fetch_assoc($allD4ScoresResult)) {
            $totalD4 += $row['D4'];
            $numStudentsD4++;
        }

        $avgD4 = ($numStudentsD4 > 0) ? $totalD4 / $numStudentsD4 : 0;

        // Calculate the overall average of A1, A2, A3, A4, B1, B2, B3, B4, and B5
        $overallAvgAA = ($avgA1 + $avgA2 + $avgA3 + $avgA4) / 4;
        $overallAvgBB = ($avgB1 + $avgB2 + $avgB3 + $avgB4 + $avgB5) / 5;
        $overallAvgC = ($avgC1 + $avgC2 + $avgC3) / 3;
        $overallAvgD = ($avgD1 + $avgD2 + $avgD3 + $avgD4) / 4;
        $overallAvg = ($overallAvgAA + $overallAvgBB + $overallAvgC + $overallAvgD)/4;


        // Calculate average scores
        $avg_scores = [
            'A' => ($fac['A_Total'] / 9),
            'B' => ($fac['B_Total'] / 8),
        ];


        $allA1ScoresQuery = "SELECT A1 FROM evaluation_superior ";
        $allA1ScoresResult = mysqli_query($conn, $allA1ScoresQuery);
        
        $totalA1 = 0;
        $numStudents = 0;

        while ($row = mysqli_fetch_assoc($allA1ScoresResult)) {
            $totalA1 += $row['A1'];
            $numStudents++;
        }

        $avgA1 = ($numStudents > 0) ? $totalA1 / $numStudents : 0;

        // Fetch all A2 scores for the same section and subject
        $allA2ScoresQuery = "SELECT A2 FROM evaluation_superior ";
        $allA2ScoresResult = mysqli_query($conn, $allA2ScoresQuery);

        $totalA2 = 0;
        $numStudentsA2 = 0;

        while ($row = mysqli_fetch_assoc($allA2ScoresResult)) {
            $totalA2 += $row['A2'];
            $numStudentsA2++;
        }

        $avgA2 = ($numStudentsA2 > 0) ? $totalA2 / $numStudentsA2 : 0;

        // Fetch all A3 scores for the same section and subject
        $allA3ScoresQuery = "SELECT A3 FROM evaluation_superior ";
        $allA3ScoresResult = mysqli_query($conn, $allA3ScoresQuery);

        $totalA3 = 0;
        $numStudentsA3 = 0;

        while ($row = mysqli_fetch_assoc($allA3ScoresResult)) {
            $totalA3 += $row['A3'];
            $numStudentsA3++;
        }

        $avgA3 = ($numStudentsA3 > 0) ? $totalA3 / $numStudentsA3 : 0;

        // Fetch all A4 scores for the same section and subject
        $allA4ScoresQuery = "SELECT A4 FROM evaluation_superior ";
        $allA4ScoresResult = mysqli_query($conn, $allA4ScoresQuery);

        $totalA4 = 0;
        $numStudentsA4 = 0;

        while ($row = mysqli_fetch_assoc($allA4ScoresResult)) {
            $totalA4 += $row['A4'];
            $numStudentsA4++;
        }

        $avgA4 = ($numStudentsA4 > 0) ? $totalA4 / $numStudentsA4 : 0;

        // Fetch all A5 scores for the same section and subject
        $allA5ScoresQuery = "SELECT A5 FROM evaluation_superior ";
        $allA5ScoresResult = mysqli_query($conn, $allA5ScoresQuery);
        
        $totalA5 = 0;
        $numStudentsA5 = 0;

        while ($row = mysqli_fetch_assoc($allA5ScoresResult)) {
            $totalA5 += $row['A5'];
            $numStudentsA5++;
        }

        $avgA5 = ($numStudentsA5 > 0) ? $totalA5 / $numStudentsA5 : 0;

        // Fetch all A6 scores for the same section and subject
        $allA6ScoresQuery = "SELECT A6 FROM evaluation_superior ";
        $allA6ScoresResult = mysqli_query($conn, $allA6ScoresQuery);

        $totalA6 = 0;
        $numStudentsA6 = 0;

        while ($row = mysqli_fetch_assoc($allA6ScoresResult)) {
            $totalA6 += $row['A6'];
            $numStudentsA6++;
        }

        $avgA6 = ($numStudentsA6 > 0) ? $totalA6 / $numStudentsA6 : 0;

        // Fetch all A7 scores for the same section and subject
        $allA7ScoresQuery = "SELECT A7 FROM evaluation_superior ";
        $allA7ScoresResult = mysqli_query($conn, $allA7ScoresQuery);

        $totalA7 = 0;
        $numStudentsA7 = 0;

        while ($row = mysqli_fetch_assoc($allA7ScoresResult)) {
            $totalA7 += $row['A7'];
            $numStudentsA7++;
        }

        $avgA7 = ($numStudentsA7 > 0) ? $totalA7 / $numStudentsA7 : 0;

        // Fetch all A8 scores for the same section and subject
        $allA8ScoresQuery = "SELECT A8 FROM evaluation_superior ";
        $allA8ScoresResult = mysqli_query($conn, $allA8ScoresQuery);

        $totalA8 = 0;
        $numStudentsA8 = 0;

        while ($row = mysqli_fetch_assoc($allA8ScoresResult)) {
            $totalA8 += $row['A8'];
            $numStudentsA8++;
        }

        $avgA8 = ($numStudentsA8 > 0) ? $totalA8 / $numStudentsA8 : 0;

        // Fetch all A9 scores for the same section and subject
        $allA9ScoresQuery = "SELECT A9 FROM evaluation_superior ";
        $allA9ScoresResult = mysqli_query($conn, $allA9ScoresQuery);

        $totalA9 = 0;
        $numStudentsA9 = 0;

        while ($row = mysqli_fetch_assoc($allA9ScoresResult)) {
            $totalA9 += $row['A9'];
            $numStudentsA9++;
        }

        $avgA9 = ($numStudentsA9 > 0) ? $totalA9 / $numStudentsA9 : 0;

        // Fetch all B10 scores for the same section and subject
        $allB10ScoresQuery = "SELECT B10 FROM evaluation_superior ";
        $allB10ScoresResult = mysqli_query($conn, $allB10ScoresQuery);
        
        $totalB10 = 0;
        $numStudentsB10 = 0;

        while ($row = mysqli_fetch_assoc($allB10ScoresResult)) {
            $totalB10 += $row['B10'];
            $numStudentsB10++;
        }

        $avgB10 = ($numStudentsB10 > 0) ? $totalB10 / $numStudentsB10 : 0;

        // Fetch all B11 scores for the same section and subject
        $allB11ScoresQuery = "SELECT B11 FROM evaluation_superior ";
        $allB11ScoresResult = mysqli_query($conn, $allB11ScoresQuery);

        $totalB11 = 0;
        $numStudentsB11 = 0;

        while ($row = mysqli_fetch_assoc($allB11ScoresResult)) {
            $totalB11 += $row['B11'];
            $numStudentsB11++;
        }

        $avgB11 = ($numStudentsB11 > 0) ? $totalB11 / $numStudentsB11 : 0;

        // Fetch all B12 scores for the same section and subject
        $allB12ScoresQuery = "SELECT B12 FROM evaluation_superior ";
        $allB12ScoresResult = mysqli_query($conn, $allB12ScoresQuery);

        $totalB12 = 0;
        $numStudentsB12 = 0;

        while ($row = mysqli_fetch_assoc($allB12ScoresResult)) {
            $totalB12 += $row['B12'];
            $numStudentsB12++;
        }

        $avgB12 = ($numStudentsB12 > 0) ? $totalB12 / $numStudentsB12 : 0;

         // Fetch all B13 scores for the same section and subject
        $allB13ScoresQuery = "SELECT B13 FROM evaluation_superior ";
        $allB13ScoresResult = mysqli_query($conn, $allB13ScoresQuery);
        
        $totalB13 = 0;
        $numStudentsB13 = 0;

        while ($row = mysqli_fetch_assoc($allB13ScoresResult)) {
            $totalB13 += $row['B13'];
            $numStudentsB13++;
        }

        $avgB13 = ($numStudentsB13 > 0) ? $totalB13 / $numStudentsB13 : 0;

        // Fetch all B14 scores for the same section and subject
        $allB14ScoresQuery = "SELECT B14 FROM evaluation_superior ";
        $allB14ScoresResult = mysqli_query($conn, $allB14ScoresQuery);
        
        $totalB14 = 0;
        $numStudentsB14 = 0;

        while ($row = mysqli_fetch_assoc($allB14ScoresResult)) {
            $totalB14 += $row['B14'];
            $numStudentsB14++;
        }

        $avgB14 = ($numStudentsB14 > 0) ? $totalB14 / $numStudentsB14 : 0;

        // Fetch all B15 scores for the same section and subject
        $allB15ScoresQuery = "SELECT B15 FROM evaluation_superior ";
        $allB15ScoresResult = mysqli_query($conn, $allB15ScoresQuery);
        
        $totalB15 = 0;
        $numStudentsB15 = 0;

        while ($row = mysqli_fetch_assoc($allB15ScoresResult)) {
            $totalB15 += $row['B15'];
            $numStudentsB15++;
        }

        $avgB15 = ($numStudentsB15 > 0) ? $totalB15 / $numStudentsB15 : 0;

        // Fetch all B16 scores for the same section and subject
        $allB16ScoresQuery = "SELECT B16 FROM evaluation_superior ";
        $allB16ScoresResult = mysqli_query($conn, $allB16ScoresQuery);
        
        $totalB16 = 0;
        $numStudentsB16 = 0;

        while ($row = mysqli_fetch_assoc($allB16ScoresResult)) {
            $totalB16 += $row['B16'];
            $numStudentsB16++;
        }

        $avgB16 = ($numStudentsB16 > 0) ? $totalB16 / $numStudentsB16 : 0;

        // Fetch all B17 scores for the same section and subject
        $allB17ScoresQuery = "SELECT B17 FROM evaluation_superior ";
        $allB17ScoresResult = mysqli_query($conn, $allB17ScoresQuery);
        
        $totalB17 = 0;
        $numStudentsB17 = 0;

        while ($row = mysqli_fetch_assoc($allB17ScoresResult)) {
            $totalB17 += $row['B17'];
            $numStudentsB17++;
        }

        $avgB17 = ($numStudentsB17 > 0) ? $totalB17 / $numStudentsB17 : 0;

        // Calculate the overall average of A1, A2, A3, A4, B1, B2, B3, B4, and B5
        $overallAvgA = ($avgA1 + $avgA2 + $avgA3 + $avgA4 + $avgA5 + $avgA6 + $avgA7 + $avgA8 + $avgA9) / 9;
        $overallAvgB = ($avgB10 + $avgB11 + $avgB12 + $avgB13 + $avgB14 + $avgB15 + $avgB16 + $avgB17) / 8;
        $overallAvg = ($overallAvgA + $overallAvgB)/2;

        // Calculate overall average for student evaluations
        $overallAvgStudents = ($overallAvgAA + $overallAvgBB + $overallAvgC + $overallAvgD) / 4;

// Calculate overall average for superior evaluations
        $overallAvgSuperior = ($overallAvgA + $overallAvgB)/2;

// Combine the overall averages
        $finalOverallAvg = ($overallAvgStudents + $overallAvgSuperior) / 2;

        ?>
        <tr>
            <td><?php echo $fac['firstname'].' '.$fac['lastname'] ; ?></td>
            <td><?php echo number_format($finalOverallAvg, 2) ?></td>
            <td>
                <?php if ($finalOverallAvg >= 4.1 && $finalOverallAvg <= 5) {
        echo '<span class="badge bg-danger pt-1">Outstanding</span>';
    } elseif ($finalOverallAvg >= 3.1 && $finalOverallAvg <= 4) {
        echo '<span class="badge bg-warning pt-1">Very Satisfactory</span>';
    } elseif ($finalOverallAvg >= 2.1 && $finalOverallAvg <= 3.09) { // Adjusted range to avoid overlap
        echo '<span class="badge bg-info pt-1">Satisfactory</span>';
    } elseif ($finalOverallAvg >= 1.2 && $finalOverallAvg <= 2.09) { // Adjusted range to avoid overlap
        echo '<span class="badge bg-success pt-1">Moderately Satisfactory</span>';
    } elseif ($finalOverallAvg >= 0.1 && $finalOverallAvg <= 1.09) { // Adjusted range to avoid overlap
        echo '<span class="badge bg-primary pt-1">Fair</span>';
    } elseif ($finalOverallAvg < 0) {
        echo '<span class="badge bg-secondary pt-1">Poor</span>';
    }?>
            </td>
        </tr>

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

