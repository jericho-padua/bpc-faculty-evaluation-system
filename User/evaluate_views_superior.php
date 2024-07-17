<title>BPC Faculty Evaluation System | Faculty Profile</title>
<?php 
    include 'navbar.php';
    if(isset($_GET['Id'])) {
        $Id = $_GET['Id'];

        $check_eval = mysqli_query($conn, "SELECT * FROM evaluation_superior JOIN users ON evaluation_superior.evaluated_by=users.user_Id WHERE evaluation_superior.Id='$Id' ");
        $r_check_eval = mysqli_fetch_array($check_eval);

        $faculty = '';
        if($r_check_eval['user_type'] == 'Superior') {
            $faculty = mysqli_query($conn, "SELECT * FROM evaluation_superior JOIN users ON evaluation_superior.user_Id=users.user_Id WHERE evaluation_superior.Id='$Id' ");
        } else {
            $faculty = mysqli_query($conn, "SELECT * FROM evaluation_superior JOIN users ON evaluation_superior.user_Id=users.user_Id JOIN subject ON evaluation_superior.subject_Id=subject.sub_Id JOIN section ON evaluation_superior.section_Id=section.section_Id WHERE evaluation_superior.Id='$Id' ");
        }

        $fac = mysqli_fetch_array($faculty);

        // GET ACTIVE YEAR FOR EVALUATION
        $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
        $activeId = mysqli_fetch_array($active); 

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
    
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>Faculty Profile</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="card">
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="evaltion_history">
                    <button id="printButton" class="btn btn-success btn-sm float-sm-right"><i class="fa-solid fa-print"></i> Print</button>
                    <div class="active tab-pane" id="printElement">
                    <div class="row d-flex ">
                    <img src="../images/bpc.ico" alt="logo" width="100" height="100">
                        <p class="ml-2 mt-3">Bulacan Polytechnic College<br>Bulihan, City of Malolos, Bulacan <br> <span class="text-sm text-muted"><b>Printed by:</b> BPC Admin on <?= date('Y-m-d h:i A') ?><br><?php if(mysqli_num_rows($active) > 0) { echo $activeId['year'].': '.$activeId['semester']; } else { echo 'Evaluation: OFF'; } ?></span></p>
                    </div>
                    <hr>
                    <p class="text-center" style="font-family: Verdana, sans-serif; font-size: 20px; font-weight:bold;">FACULTY EVALUATION RESULT</p>
                    <p>Instructor Name: <b><?php echo ($fac['firstname'].' '.$fac['middlename'].' '.$fac['lastname'].' '.$fac['suffix']); ?></b></p>
                    <p>No. of Superior Evaluated: <b><?php echo $numStudents++; ?></b></p>
                    <table id="" class="table table-bordered table-hover text-sm table-sm">
                        <thead>
                          <tr>
                            <th>A. On Instruction and Administrative Functions</th>
                            <th>Rating</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1. Adhere to the faithful implementation of the policies on students performance in the class, values development, examination procedures, and other school policies.</td>
                            <td class="text-center text-bold"><!--A1_Total--><?php echo number_format($avgA1, 2) ?></td>
                          </tr>
                          <tr>
                            <td>2. Imposes objectivism, by providing a sound judgement of evaluation of the students' academic performance according to the grading system or policies.</td>
                            <td class="text-center text-bold"><!--A2_Total--><?php echo number_format($avgA2, 2) ?></td>
                          </tr>
                          <tr>
                            <td>3. Creates a classroom climate conducive to teaching and learning processes.</td>
                            <td class="text-center text-bold"><!--A3_Total--><?php echo number_format($avgA3, 2) ?></td>
                          </tr>
                          <tr>
                            <td>4. Practices exemplary punctuality in attending classes.</td>
                            <td class="text-center text-bold"><!--A4_Total--><?php echo number_format($avgA4, 2) ?></td>
                          </tr>
                          <tr>
                            <td>5. Attends faculty meetings, area or committee meetings, in-service training assemblies, graduation exercises and other school functions.</td>
                            <td class="text-center text-bold"><!--A5_Total--><?php echo number_format($avgA5, 2) ?></td>
                          </tr>
                          <tr>
                            <td>6. Observes punctuality in the submission of school's requirements such as examination, committee reports and grading sheets of the students and other reports duly assigned by the College administrator.</td>
                            <td class="text-center text-bold"><!--A6_Total--><?php echo number_format($avgA6, 2) ?></td>
                          </tr>
                          <tr>
                            <td>7. Imposes virtual classroom disciplines.</td>
                            <td class="text-center text-bold"><!--A7_Total--><?php echo number_format($avgA7, 2) ?></td>
                          </tr>
                          <tr>
                            <td>8. Serves as good class adviser or club moderator/serves as good example in the campus.</td>
                            <td class="text-center text-bold"><!--A8_Total--><?php echo number_format($avgA8, 2) ?></td>
                          </tr>
                          <tr>
                            <td>9. Endeavors for the accomplishment of the institution's mission and vision.</td>
                            <td class="text-center text-bold"><!--A9_Total--><?php echo number_format($avgA9, 2) ?></td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><span style="color: darkred;"><!--A_Total / 4--><?php echo number_format($overallAvgA, 2) ?></span></td>
                          </tr>
                        </tfoot>

                    </table><br>
                    <table id="" class="table table-bordered table-hover text-sm table-sm">
                      <thead>
                        <tr>
                          <th>B. On Professionalism</th>
                          <th>Rating</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>10. Conducts pre-consultation with the College Administrator/Cluster Heads before implementing certain rules and regulations.</td>
                          <td class="text-center text-bold"><!--B10_Total--><?php echo number_format($avgB10, 2) ?></td>
                        </tr>
                        <tr>
                          <td>11. Possesses potential qualities of being present-minded, creative, optimistic, open-minded and willing to champion he/her profession.</td>
                          <td class="text-center text-bold"><!--B11_Total--><?php echo number_format($avgB11, 2) ?></td>
                        </tr>
                        <tr>
                          <td>12. Upholds the noble task of providing and insuring high standard of teaching through the adoptin of innovative methodologies. </td>
                          <td class="text-center text-bold"><!--B12_Total--><?php echo number_format($avgB12, 2) ?></td>
                        </tr><tr>
                          <td>13. Adopts conscientious, just and humane teaching techniques that promote desirable transformation of moral values of the students.</td>
                          <td class="text-center text-bold"><!--B13_Total--><?php echo number_format($avgB13, 2) ?></td>
                        </tr>
                        <tr>
                          <td>14. Instills harmonious relationship with the administration and adheres to the objectives and implementing rules of the school by recognizing authority channels, and open to communication processes.</td>
                          <td class="text-center text-bold"><!--B14_Total--><?php echo number_format($avgB14, 2) ?></td>
                        </tr>
                        <tr>
                          <td>15. Gives importance to the needs of the school's working committees through active participation if needed.</td>
                          <td class="text-center text-bold"><!--B15_Total--><?php echo number_format($avgB15, 2) ?></td>
                        </tr>
                        <tr>
                          <td>16. Have a strong support and full understanding of the contributions of the faculty and their area of specialization in the common task of higher education.</td>
                          <td class="text-center text-bold"><!--B16_Total--><?php echo number_format($avgB16, 2) ?></td>
                        </tr>
                        <tr>
                          <td>17. Observes professional growth through pursuit of post degree course that are relevant to their teaching needs and by attending seminars and conferences.</td>
                          <td class="text-center text-bold"><!--B17_Total--><?php echo number_format($avgB17, 2) ?></td>
                        </tr>

                      </tbody>
                      <tfoot>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><!--B_Total / 5--><span style="color: darkred;"><?php echo number_format($overallAvgB, 2) ?></span></td>
                          </tr>
                        </tfoot>
                    </table><br>
                    <div class="container">
                      <p class="float-right" style="font-weight: bold;">General Weighted Average (GWA): <span style="color:darkred;"><?php echo number_format($overallAvg, 2) ?></span>
                        <?php
    if ($overallAvg >= 4.1 && $overallAvg <= 5) {
        echo '<span class="badge bg-danger pt-1">Outstanding</span>';
    } elseif ($overallAvg >= 3.1 && $overallAvg <= 4) {
        echo '<span class="badge bg-warning pt-1">Very Satisfactory</span>';
    } elseif ($overallAvg >= 2.1 && $overallAvg <= 3.09) { // Adjusted range to avoid overlap
        echo '<span class="badge bg-info pt-1">Satisfactory</span>';
    } elseif ($overallAvg >= 1.2 && $overallAvg <= 2.09) { // Adjusted range to avoid overlap
        echo '<span class="badge bg-success pt-1">Moderately Satisfactory</span>';
    } elseif ($overallAvg >= 0.1 && $overallAvg <= 1.09) { // Adjusted range to avoid overlap
        echo '<span class="badge bg-primary pt-1">Fair</span>';
    } elseif ($overallAvg < 0) {
        echo '<span class="badge bg-secondary pt-1">Poor</span>';
    }
?>

                      </p>
                    </div>
    </section>
<?php } else { include '404.php'; } include 'footer.php'; ?>