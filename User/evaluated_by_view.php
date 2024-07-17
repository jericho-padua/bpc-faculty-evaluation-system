<title>BPC Faculty Evaluation System | Faculty profile</title>
<?php 
    include 'navbar.php';
    if(isset($_GET['Id'])) {
      $Id = $_GET['Id'];
     

      $faculty = mysqli_query($conn, "SELECT * FROM evaluation JOIN users ON evaluation.user_Id=users.user_Id JOIN subject ON evaluation.subject_Id=subject.sub_Id JOIN section ON evaluation.section_Id=section.section_Id WHERE evaluation.Id='$Id' ");

      // $faculty = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id'");
      $fac = mysqli_fetch_array($faculty);
      $evaluated_by = $fac['evaluated_by'];
      $sql2 = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$evaluated_by'");
      $row2 = mysqli_fetch_array($sql2);

      // GET ACTIVE YEAR FOR EVALUATION
      $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
      $activeId = mysqli_fetch_array($active); 


       // RATINGS FOR A B C D
     $grades = [
          'A' => $fac['A_Total'],
          'B' => $fac['B_Total'],
          'C' => $fac['C_Total'],
          'D' => $fac['D_Total'],
      ];

      foreach ($grades as $grade => $value) {
          if ($value >= 21 && $value <= 25) {
              $evaluations[$grade] = "Outstanding";
          } elseif ($value >= 16 && $value <= 20) {
              $evaluations[$grade] = "Very Satisfactory";
          } elseif ($value >= 11 && $value <= 15) {
              $evaluations[$grade] = "Satisfactory";
          } elseif ($value >= 6 && $value <= 10) {
              $evaluations[$grade] = "Moderately Satisfactory";
          } elseif ($value >= 4 && $value <= 5) {
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
            <!--<h1>Evaluator: <?php echo $row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix']; ?></h1>-->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Evaluator's evaluation</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
         <!--  <div class="col-md-3">

            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                    <?php //if($fac['image'] == ""): ?>
                    <img src="../dist/img/avatar.png" alt="User Avatar" class="img-size-50 img-circle">
                    <?php// else: ?>
                    <img class="profile-user-img img-fluid img-circle"src="../images-users/<?php //echo $fac['image']; ?>"alt="User profile picture"  style="height: 90px; width: 90px; border-radius: 50%;">
                    <?php// endif; ?>
                    
                </div>
                <h3 class="profile-username text-center"><?php //echo ' '.$fac['firstname'].' '.$fac['lastname'].' '; ?></h3>
                <p class="text-muted text-center"><?php //echo $fac['user_type']; ?></p>
                <a class="btn bg-gradient-primary btn-block">Profile</a>
              </div>
            </div>

          </div> -->


          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <!-- <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#evaltion_history" data-toggle="tab">Evalution record</a></li> -->
                 <!--  <li class="nav-item"><a class="nav-link" href="#viewprofile" data-toggle="tab">Faculty profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#subjectinfo" data-toggle="tab">Subject info</a></li> -->
                <button id="printButton" class="btn btn-success btn-sm float-sm-right"><i class="fa-solid fa-print"></i> Print</button>

                <!-- </ul> -->
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">


                  <div class="active tab-pane" id="printElement">
                      <div class="row d-flex ">
                      <img src="../images/bpc.ico" alt="logo" width="100">
                          <p class="ml-2 mt-3">Bulacan Polytechnic College<br>Bulihan, City of Malolos, Bulacan <br> <span class="text-sm text-muted"><b>Printed by:</b> <?= $logged_in; ?> on <?= date('Y-m-d h:i A') ?></span></p>
                      </div>
                      <hr>
                      <!--<p class="text-center"><b>EVALUATION BY <?php echo strtoupper($row2['firstname'].' '.$row2['middlename'].' '.$row2['lastname'].' '.$row2['suffix']); ?></b></p>-->
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
                          <!--<tr>
                            <td>5.  Keeps acurate records of student’s performance and prompt submission of the same.</td>
                            <td class="p-2 text-center"><span id="A5_Sub"><?php echo $fac['A5']; ?></span></td>
                          </tr>-->
                        </tbody>
                        <tfoot>
                          <tr>
                            <td class="text-center text-bold">Total Score</td>
                            <td class="text-center text-bold"><span id="A_Total"><?php echo $fac['A_Total'] ?></span></td>
                          </tr>
                          <tr>
                            <td class="text-center text-bold">Ratings</td>
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
                            <td class="text-center text-bold">Total Score</td>
                            <td class="text-center text-bold"><span id="A_Total"><?php echo $fac['B_Total'] ?></span></td>
                          </tr>
                          <tr>
                            <td class="text-center text-bold">Ratings</td>
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
                        </tr><!--<tr>
                          <td>4.  Allows students to think independently and make their own decisions and holding them accountable for their performance based largely on their success in executing decisions.</td>
                          <td class="p-2 text-center"><span id="C4_Sub"><?php echo $fac['C4']; ?></span></td>
                        </tr>-->
                        <!--<tr>
                          <td>5.  Encourages students to learn beyond what is required and help/guide the students how to apply the concept learned. </td>
                          <td class="p-2 text-center"><span id="C5_Sub"><?php echo $fac['C5']; ?></span></td>
                        </tr>-->
                      </tbody>
                      <tfoot>
                        <tr>
                          <td class="text-center text-bold">Total Score</td>
                          <td class="text-center text-bold"><span id="A_Total"><?php echo $fac['C_Total'] ?></span></td>
                        </tr>
                        <tr>
                          <td class="text-center text-bold">Ratings</td>
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
                        <!--<tr>
                          <td>5.  Use of Instructional Materials (audio/video materials: fieldtrips, film showing, computer aided instruction and etc.) to reinforces learning processors. </td>
                          <td class="p-2 text-center"><span id="D5_Sub"><?php echo $fac['D5']; ?></span></td>
                        </tr>-->
                      </tbody>
                      <tfoot>
                        <tr>
                          <td class="text-center text-bold">Total Score</td>
                          <td class="text-center text-bold"><span id="A_Total"><?php echo $fac['D_Total'] ?></span></td>
                        </tr>
                        <tr>
                          <td class="text-center text-bold">Ratings</td>
                          <td class="text-center text-bold"><span id="A_Total"><?php echo $evaluations['D'] ?></span></td>
                        </tr>
                      </tfoot>
                    </table>
                    <div class="container">
                      <p class="float-right">Overall Rating: 
                          <?php
                            $avg_grand_total = $fac['grand_total'];
                            if ($avg_grand_total >= 75 && $avg_grand_total <= 80) {
                                echo '<span class="badge bg-primary pt-1">Outstanding</span>';
                            } elseif ($avg_grand_total >= 70 && $avg_grand_total < 75) {
                                echo '<span class="badge bg-info pt-1">Very Satisfactory</span>';
                            } elseif ($avg_grand_total >= 65 && $avg_grand_total < 70) {
                                echo '<span class="badge bg-success pt-1">Satisfactory</span>';
                            } elseif ($avg_grand_total >= 60 && $avg_grand_total < 65) {
                                echo '<span class="badge bg-warning pt-1">Moderately Satisfactory</span>';
                            } elseif ($avg_grand_total >= 55 && $avg_grand_total < 60) {
                                echo '<span class="badge bg-light pt-1">Fair</span>';
                            } elseif ($avg_grand_total < 55) {
                                echo '<span class="badge bg-secondary pt-1">Poor</span>';
                            }
                            ?>
                      </p>
                    </div>
                  </div>

                  <div class="tab-pane" id="viewprofile">
                      <div class="form-group row">
                        <label for="First name" class="col-sm-2 col-form-label">Course</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="First name" placeholder="First name" value="<?php echo $fac['department']; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="First name" class="col-sm-2 col-form-label">Full name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="First name" placeholder="First name" value="<?php echo ' '.$fac['firstname'].' '.$fac['middlename'].' '.$fac['lastname'].' '.$fac['suffix'].' '; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="First name" class="col-sm-2 col-form-label">Date of birth</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="First name" placeholder="First name" value="<?php echo date("F d, Y", strtotime($fac['dob'])); echo ' - '; echo $fac['age'] ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="First name" class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="First name" placeholder="Gender" value="<?php echo $fac['gender']; ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="Email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="Email" placeholder="Email" value="<?php echo $fac['email']; ?>" readonly>
                        </div>
                      </div>
                  </div>

                  <div class="tab-pane" id="subjectinfo">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Subject name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $fac['name']; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Subject Code</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $fac['code']; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">No of units</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $fac['units']; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Assigned instructor</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $fac['firstname'].' '.$fac['middlename'].' '.$fac['lastname'].' '.$fac['suffix']; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Year and Section</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $fac['yr_level'].' - '.$fac['section']; ?>" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Date created</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo date("F d, Y", strtotime($fac['date_created'])); ?>" readonly>
                      </div>
                    </div>
                  </div>




                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
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

<?php } else { include '404.php'; } include 'footer.php'; ?>


<script>

 function newgetImagePreview(event)
  {
    var image=URL.createObjectURL(event.target.files[0]);
    var imagediv= document.getElementById('user_preview');
    var newimg=document.createElement('img');
    imagediv.innerHTML='';
    newimg.src=image;
    newimg.width="100";
    newimg.height="100";
    newimg.style['border-radius']="50%";
    newimg.style['display']="block";
    newimg.style['margin-left']="auto";
    newimg.style['margin-right']="auto";
    newimg.style['box-shadow']="rgba(100, 100, 111, 0.2) 0px 7px 29px 0px";
    imagediv.appendChild(newimg);
  }

</script>
