<title>BPC Faculty Evaluation System | Faculty Profile</title>
<?php 
include 'navbar.php';
if(isset($_GET['Id'])) {
    $Id = $_GET['Id'];
    
    $check_eval = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.evaluated_by=users.user_Id WHERE evaluation.Id='$Id' ");
    $r_check_eval = mysqli_fetch_array($check_eval);

    $faculty = '';
    if($r_check_eval['user_type'] == 'Dean' || $r_check_eval['user_type'] == 'Faculty') {
        $faculty = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id WHERE evaluation.Id='$Id' ");
    } else {
        $faculty = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id JOIN subject ON evaluation.subject_Id=subject.sub_Id JOIN section ON evaluation.section_Id=section.section_Id WHERE evaluation.Id='$Id' ");
    }
    $fac = mysqli_fetch_array($faculty);

    // GET ACTIVE YEAR FOR EVALUATION
    $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
    $activeId = mysqli_fetch_array($active);

    // Define total scores for each grade
    $A_Total = [
        'A' => $fac['A_Total'],
        
    ];

    // Compute ratings for each grade A_Total
    foreach ($A_Total as $grade => $value) {
          if ($value >= 17 && $value <= 20) {
              $evaluations[$grade] = "Outstanding";
          } elseif ($value >= 13 && $value <= 16) {
              $evaluations[$grade] = "Very Satisfactory";
          } elseif ($value >= 9 && $value <= 12) {
              $evaluations[$grade] = "Satisfactory";
          } elseif ($value >= 5 && $value <= 8) {
              $evaluations[$grade] = "Moderately Satisfactory";
          } elseif ($value >= 1 && $value <= 4) {
              $evaluations[$grade] = "Fair";
          } else {
              $evaluations[$grade] = "Poor";
          }
      }

     // Define total scores for each grade
    $B_Total = [
        'B' => $fac['B_Total'],
        
    ];

    // Compute ratings for each grade A_Total
    foreach ($B_Total as $grade => $value) {
          if ($value >= 21 && $value <= 25) {
              $evaluations[$grade] = "Outstanding";
          } elseif ($value >= 16 && $value <= 20) {
              $evaluations[$grade] = "Very Satisfactory";
          } elseif ($value >= 11 && $value <= 15) {
              $evaluations[$grade] = "Satisfactory";
          } elseif ($value >= 6 && $value <= 10) {
              $evaluations[$grade] = "Moderately Satisfactory";
          } elseif ($value >= 1 && $value <= 5) {
              $evaluations[$grade] = "Fair";
          } else {
              $evaluations[$grade] = "Poor";
          }
      }

    // Define total scores for each grade
    $C_Total = [
        'C' => $fac['C_Total'],
        
    ];

    // Compute ratings for each grade A_Total
    foreach ($C_Total as $grade => $value) {
          if ($value >= 13 && $value <= 15) {
              $evaluations[$grade] = "Outstanding";
          } elseif ($value >= 10 && $value <= 12) {
              $evaluations[$grade] = "Very Satisfactory";
          } elseif ($value >= 7 && $value <= 9) {
              $evaluations[$grade] = "Satisfactory";
          } elseif ($value >= 4 && $value <= 6) {
              $evaluations[$grade] = "Moderately Satisfactory";
          } elseif ($value >= 1 && $value <= 3) {
              $evaluations[$grade] = "Fair";
          } else {
              $evaluations[$grade] = "Poor";
          }
      }

    // Define total scores for each grade
    $D_Total = [
        'D' => $fac['D_Total'],
        
    ];

    // Compute ratings for each grade A_Total
    foreach ($D_Total as $grade => $value) {
          if ($value >= 17 && $value <= 20) {
              $evaluations[$grade] = "Outstanding";
          } elseif ($value >= 13 && $value <= 16) {
              $evaluations[$grade] = "Very Satisfactory";
          } elseif ($value >= 9 && $value <= 12) {
              $evaluations[$grade] = "Satisfactory";
          } elseif ($value >= 5 && $value <= 8) {
              $evaluations[$grade] = "Moderately Satisfactory";
          } elseif ($value >= 1 && $value <= 4) {
              $evaluations[$grade] = "Fair";
          } else {
              $evaluations[$grade] = "Poor";
          }
      }
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
                    <p class="text-center" style="font-family: Verdana, sans-serif; font-size: 20px; font-weight:bold;">FACULTY EVALUATION RESULT</p>
                    <p>Instructor Name: <b><?php echo ($fac['firstname'].' '.$fac['middlename'].' '.$fac['lastname'].' '.$fac['suffix']); ?></b></p>
                    <p>Section: <b><?php echo ($fac['department'].' '.$fac['yr_level'].' - '.$fac['section']); ?></b></p>
                    <p>Subject: <b><?php echo ($fac['code'].' - '.$fac['name']); ?></b></p>
                    <table id="" class="table table-bordered table-hover text-sm table-sm">
                        <thead>
                          <tr>
                            <th>A.  Attitude Toward Students</th>
                            <th>Score</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1.  Listen and understand student's point of view; he/she may not agree but students feel understood. (Marunong makinig sa opinyon ng estudyante).</td>
                            <td class="p-2 text-center"><span id="A1_Sub"><?php echo $fac['A1']; ?></span></td>
                          </tr>
                          <tr>
                            <td>2.  Imposes discipline among students fairly and consistently. (Patas at palagian ang pagpapatupad ng disiplina sa lahat ng mga mag-aaral).</td>
                            <td class="p-2 text-center"><span id="A2_Sub"><?php echo $fac['A2']; ?></span></td>
                          </tr>
                          <tr>
                            <td>3.  Shows respect and consideration to all students. (Nagpapakita ng paggalang at konsiderasyon sa mga estudyante).</td>
                            <td class="p-2 text-center"><span id="A3_Sub"><?php echo $fac['A3']; ?></span></td>
                          </tr><tr>
                            <td>4.  Encourages students to study harder. (Hinihimok ang mga mag-aaral na mag-aral na mabuti).</td>
                            <td class="p-2 text-center"><span id="A4_Sub"><?php echo $fac['A4']; ?></span></td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><span id="A_Total" style="color: darkred;"><?php echo $fac['A_Total'] ?></span></td>
                          </tr>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><span id="A_Total"><?php echo $evaluations['A'] ?></span></td>
                          </tr>
                        </tfoot>
                    </table>

                    <br>

                    <table id="" class="table table-bordered table-hover text-sm table-sm">
                      <thead>
                        <tr>
                          <th>B.  Subject Matter Presentation</th>
                          <th>Score</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1.  Follows the syllabus/course outline provided by BPC. (Sinusunod ang gabay sa Pagtuturo ng BPC). </td>
                          <td class="p-2 text-center"><span id="B1_Sub"><?php echo $fac['B1']; ?></span></td>
                        </tr>
                        <tr>
                          <td>2.  Discusses lesson clearly & shows mastery on it. (Tinatalakay ng malinaw at nagpapakita ng malalim na kaalaman ukol sa aralin).</td>
                          <td class="p-2 text-center"><span id="B2_Sub"><?php echo $fac['B2']; ?></span></td>
                        </tr>
                        <tr>
                          <td>3.  Answers questions intelligently and welcomes comments. (Sinasagot ng may katalinuhan ang mga tanong at tinatanggap ang mga komento). </td>
                          <td class="p-2 text-center"><span id="B3_Sub"><?php echo $fac['B3']; ?></span></td>
                        </tr><tr>
                          <td>4.  Uses chalkboard and/or other audio-visual materials to effectively contribute to student's understanding of the lesson. (Gumagamit ng chalkboard at/o anomang audio-visual na bagay upang higit na makatulong sa pagkatuto ng mga mag-aaral).</td>
                          <td class="p-2 text-center"><span id="B4_Sub"><?php echo $fac['B4']; ?></span></td>
                        </tr>
                        <tr>
                          <td>5.  Speaks loudly and uses classroom language efficiently. (Malakas magsalita at ginagamit ng maayos ang lengwaheng pangsilid-aralan). </td>
                          <td class="p-2 text-center"><span id="B5_Sub"><?php echo $fac['B5']; ?></span></td>
                        </tr>
                      </tbody>
                      <tfoot>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><span id="A_Total" style="color: darkred;"><?php echo $fac['B_Total'] ?></span></td>
                          </tr>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><span id="A_Total"><?php echo $evaluations['B'] ?></span></td>
                          </tr>
                        </tfoot>
                    </table>

                    <br>

                    <table id="" class="table table-bordered table-hover text-sm table-sm">
                      <thead>
                        <tr>
                          <th>C.  Classroom Management</th>
                          <th>Score</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1.  Checks the attendance systematically & consistently. (Maayos at palagiang tsine-check ang attendance).</td>
                          <td class="p-2 text-center"><span id="C1_Sub"><?php echo $fac['C1']; ?></span></td>
                        </tr>
                        <tr>
                          <td>2.  Requires students to cooperate in maintaining classroom cleanliness for a better classroom atmosphere. (Inuutusan ang mga mag-aaral na makiisa sa pagpapanatilo ng kaaya-ayang silid-aralan).</td>
                          <td class="p-2 text-center"><span id="C2_Sub"><?php echo $fac['C2']; ?></span></td>
                        </tr>
                        <tr>
                          <td>3.  Implements school's rules and regulations particularly in wearing ID and proper uniform. (Ipinatutipad ang batas at panuntunan ng paaralan lalo na sa pagsusuot ng ID at tamang uniporme). </td>
                          <td class="p-2 text-center"><span id="C3_Sub"><?php echo $fac['C3']; ?></span></td>
                        </tr>

                      </tbody>
                      <tfoot>
                        <tr>
                          <td class="text-center text-bold"></td>
                          <td class="text-center text-bold"><span id="A_Total" style="color: darkred;"><?php echo $fac['C_Total'] ?></span></td>
                        </tr>
                        <tr>
                          <td class="text-center text-bold"></td>
                          <td class="text-center text-bold"><span id="A_Total"><?php echo $evaluations['C'] ?></span></td>
                        </tr>
                      </tfoot>
                    </table>

                    <br>

                    <table id="" class="table table-bordered table-hover text-sm table-sm">
                      <thead>
                        <tr>
                          <th>D.  Etiquette</th>
                          <th>Score</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1.  Dresses neatly and respectably. (Malinis at kagalang-galang manamit). </td>
                          <td class="p-2 text-center"><span id="D1_Sub"><?php echo $fac['D1']; ?></span></td>
                        </tr>
                        <tr>
                          <td>2.  Starts and ends classes on time. (Sinisimulan at tinatapos ang klase sa tamang oras).</td>
                          <td class="p-2 text-center"><span id="D2_Sub"><?php echo $fac['D2']; ?></span></td>
                        </tr>
                        <tr>
                          <td>3.  Returns recorded test papers and projects. (Ibinabalik ang mga naitalang test papers at proyekto).</td>
                          <td class="p-2 text-center"><span id="D3_Sub"><?php echo $fac['D3']; ?></span></td>
                        </tr><tr>
                          <td>4.  Gives transparent and fair grades and criticism. (Nagbibigay ng malinaw at patas na marka at puna).</td>
                          <td class="p-2 text-center"><span id="D4_Sub"><?php echo $fac['D4']; ?></span></td>
                        </tr>
                      </tbody>
                      <tfoot>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><span id="A_Total" style="color: darkred;"><?php echo $fac['D_Total'] ?></span></td>
                          </tr>
                          <tr>
                            <td class="text-center text-bold"></td>
                            <td class="text-center text-bold"><span id="A_Total"><?php echo $evaluations['D'] ?></span></td>
                          </tr>
                        </tfoot>
                    </table>

                    <div class="container-right">
                      <p class="float-right" style="font-weight:bold;">General Weighted Average (GWA): <span style="color:darkred;"><?php echo number_format($fac['grand_total'] / 16, 2) ?></span>
                          <?php
                            $avg_grand_total = $fac['grand_total'];

                            if ($avg_grand_total >= 65 && $avg_grand_total <= 80) {
                                echo '<span class="badge bg-primary pt-1">Outstanding</span>';
                            } elseif ($avg_grand_total >= 49 && $avg_grand_total <= 64) {
                                echo '<span class="badge bg-info pt-1">Very Satisfactory</span>';
                            } elseif ($avg_grand_total >= 33 && $avg_grand_total <= 48) {
                                echo '<span class="badge bg-success pt-1">Satisfactory</span>';
                            } elseif ($avg_grand_total >= 17 && $avg_grand_total <= 32) {
                                echo '<span class="badge bg-warning pt-1">Moderately Satisfactory</span>';
                            } elseif ($avg_grand_total >= 1 && $avg_grand_total <= 16) {
                                echo '<span class="badge bg-light pt-1">Fair</span>';
                            } elseif ($avg_grand_total < 0) {
                                echo '<span class="badge bg-secondary pt-1">Poor</span>';
                            }
                            ?>
                      </p>
                    </div>

    </section>
<?php } else { include '404.php'; } include 'footer.php'; ?>