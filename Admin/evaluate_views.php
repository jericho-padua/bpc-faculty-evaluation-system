<title>BPC Faculty Evaluation System | Faculty Profile</title>
<?php 
    include 'navbar.php';
    if(isset($_GET['Id'])) {
        $Id = $_GET['Id'];

        $check_eval = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.evaluated_by=users.user_Id WHERE evaluation.Id='$Id' ");
        $r_check_eval = mysqli_fetch_array($check_eval);

        $faculty = '';
        if($r_check_eval['user_type'] == 'Faculty') {
            $faculty = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id WHERE evaluation.Id='$Id' ");
        } else {
            $faculty = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id JOIN subject ON evaluation.subject_Id=subject.sub_Id JOIN section ON evaluation.section_Id=section.section_Id WHERE evaluation.Id='$Id' ");
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
        $overallAvgA = ($avgA1 + $avgA2 + $avgA3 + $avgA4) / 4;
        $overallAvgB = ($avgB1 + $avgB2 + $avgB3 + $avgB4 + $avgB5) / 5;
        $overallAvgC = ($avgC1 + $avgC2 + $avgC3) / 3;
        $overallAvgD = ($avgD1 + $avgD2 + $avgD3 + $avgD4) / 4;
        $overallAvg = ($overallAvgA + $overallAvgB + $overallAvgC + $overallAvgD)/4;
    
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
                        <p class="ml-2 mt-3">Bulacan Polytechnic College<br>Bulihan, City of Malolos, Bulacan <br> <span class="text-sm text-muted"><b>Printed by:</b> <?= $printed_by; ?> on <?= date('Y-m-d h:i A') ?><br><?php if(mysqli_num_rows($active) > 0) { echo $activeId['year'].': '.$activeId['semester']; } else { echo 'Evaluation: OFF'; } ?></span></p>
                    </div>
                    <hr>
                    <p class="text-center" style="font-family: Verdana, sans-serif; font-size: 20px; font-weight:bold;">FACULTY EVALUATION RESULT</p>
                    <p>Instructor Name: <b><?php echo ($fac['firstname'].' '.$fac['middlename'].' '.$fac['lastname'].' '.$fac['suffix']); ?></b></p>
                    <p>Section: <b><?php echo ($fac['department'].' '.$fac['yr_level'].' - '.$fac['section']); ?></b></p>
                    <p>Subject: <b><?php echo ($fac['code'].' - '.$fac['name']); ?></b></p>

                    <p>No. of Students Evaluated: <b><?php echo $numStudents++; ?></b></p>
                    <table id="" class="table table-bordered table-hover text-sm table-sm">
                        <thead>
                          <tr>
                            <th>A.  Attitude Toward Students</th>
                            <th>Rating</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1.  Listen and understand student's point of view; he/she may not agree but students feel understood. (Marunong makinig sa opinyon ng estudyante).</td>
                            <td class="text-center text-bold"><!--A1_Total--><?php echo number_format($avgA1, 2) ?></td>
                          </tr>
                          <tr>
                            <td>2.  Imposes discipline among students fairly and consistently. (Patas at palagian ang pagpapatupad ng disiplina sa lahat ng mga mag-aaral).</td>
                            <td class="text-center text-bold"><!--A2_Total--><?php echo number_format($avgA2, 2) ?></td>
                          </tr>
                          <tr>
                            <td>3.  Shows respect and consideration to all students. (Nagpapakita ng paggalang at konsiderasyon sa mga estudyante).</td>
                            <td class="text-center text-bold"><!--A3_Total--><?php echo number_format($avgA3, 2) ?></td>
                          </tr>
                          <tr>
                            <td>4.  Encourages students to study harder. (Hinihimok ang mga mag-aaral na mag-aral na mabuti).</td>
                            <td class="text-center text-bold"><!--A4_Total--><?php echo number_format($avgA4, 2) ?></td>
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
                          <th>B.  Subject Matter Presentation</th>
                          <th>Rating</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1.  Follows the syllabus/course outline provided by BPC. (Sinusunod ang gabay sa Pagtuturo ng BPC). </td>
                          <td class="text-center text-bold"><!--B1_Total--><?php echo number_format($avgB1, 2) ?></td>
                        </tr>
                        <tr>
                          <td>2.  Discusses lesson clearly & shows mastery on it. (Tinatalakay ng malinaw at nagpapakita ng malalim na kaalaman ukol sa aralin).</td>
                          <td class="text-center text-bold"><!--B2_Total--><?php echo number_format($avgB2, 2) ?></td>
                        </tr>
                        <tr>
                          <td>3.  Answers questions intelligently and welcomes comments. (Sinasagot ng may katalinuhan ang mga tanong at tinatanggap ang mga komento). </td>
                          <td class="text-center text-bold"><!--B3_Total--><?php echo number_format($avgB3, 2) ?></td>
                        </tr><tr>
                          <td>4.  Uses chalkboard and/or other audio-visual materials to effectively contribute to student's understanding of the lesson. (Gumagamit ng chalkboard at/o anomang audio-visual na bagay upang higit na makatulong sa pagkatuto ng mga mag-aaral).</td>
                          <td class="text-center text-bold"><!--B4_Total--><?php echo number_format($avgB4, 2) ?></td>
                        </tr>
                        <tr>
                          <td>5.  Speaks loudly and uses classroom language efficiently. (Malakas magsalita at ginagamit ng maayos ang lengwaheng pangsilid-aralan). </td>
                          <td class="text-center text-bold"><!--B5_Total--><?php echo number_format($avgB5, 2) ?></td>
                        </tr>
                      </tbody>
                      <tfoot>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><!--B_Total / 5--><span style="color: darkred;"><?php echo number_format($overallAvgB, 2) ?></span></td>
                          </tr>
                        </tfoot>
                    </table><br>
                    <table id="" class="table table-bordered table-hover text-sm table-sm">
                      <thead>
                        <tr>
                          <th>C.  Classroom Management</th>
                          <th>Rating</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1.  Checks the attendance systematically & consistently. (Maayos at palagiang tsine-check ang attendance).</td>
                          <td class="text-center text-bold"><!--C1_Total--><?php echo number_format($avgC1, 2) ?></td>
                        </tr>
                        <tr>
                          <td>2.  Requires students to cooperate in maintaining classroom cleanliness for a better classroom atmosphere. (Inuutusan ang mga mag-aaral na makiisa sa pagpapanatilo ng kaaya-ayang silid-aralan).</td>
                          <td class="text-center text-bold"><!--C2_Total--><?php echo number_format($avgC2, 2) ?></td>
                        </tr>
                        <tr>
                          <td>3.  Implements school's rules and regulations particularly in wearing ID and proper uniform. (Ipinatutipad ang batas at panuntunan ng paaralan lalo na sa pagsusuot ng ID at tamang uniporme). </td>
                          <td class="text-center text-bold"><!--C3_Total--><?php echo number_format($avgC3, 2) ?></td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td class="text-center text-bold"></td>
                          <td class="text-center text-bold"><!--C_Total / 3--><span style="color: darkred;"><?php echo number_format($overallAvgC, 2) ?></span></td>
                        </tr>
                      </tfoot>
                    </table><br>
                    <table id="" class="table table-bordered table-hover text-sm table-sm">
                      <thead>
                        <tr>
                          <th>D.  Etiquette</th>
                          <th>Rating</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1.  Dresses neatly and respectably. (Malinis at kagalang-galang manamit). </td>
                          <td class="text-center text-bold"><!--D1_Total--><?php echo number_format($avgD1, 2) ?></td>
                        </tr>
                        <tr>
                          <td>2.  Starts and ends classes on time. (Sinisimulan at tinatapos ang klase sa tamang oras).</td>
                          <td class="text-center text-bold"><!--D2_Total--><?php echo number_format($avgD2, 2) ?></td>
                        </tr>
                        <tr>
                          <td>3.  Returns recorded test papers and projects. (Ibinabalik ang mga naitalang test papers at proyekto).</td>
                          <td class="text-center text-bold"><!--D3_Total--><?php echo number_format($avgD3, 2) ?></td>
                        </tr><tr>
                          <td>4.  Gives transparent and fair grades and criticism. (Nagbibigay ng malinaw at patas na marka at puna).</td>
                          <td class="text-center text-bold"><!--D4_Total--><?php echo number_format($avgD4, 2) ?></td>
                        </tr>
                      </tbody>
                      <tfoot>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><!--D_Total / 4--><span style="color: darkred;"><?php echo number_format($overallAvgD, 2) ?></span></td>
                          </tr>
                        </tfoot>
                    </table>
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