<title>BPC Faculty Evaluation System | Evaluation</title>
<?php 
    include 'navbar.php'; 
    if(isset($_GET['section_Id']) && isset($_GET['subject_Id']) && isset($_GET['user_Id'])) {
      $section_Id = mysqli_real_escape_string($conn, $_GET['section_Id']);
      $subject_Id = mysqli_real_escape_string($conn, $_GET['subject_Id']);
      $user_Id    = mysqli_real_escape_string($conn, $_GET['user_Id']);

      $faculty = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id'");
      $fac     = mysqli_fetch_array($faculty);

      // GET ACTIVE YEAR FOR EVALUATION
      $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
      $activeId = mysqli_fetch_array($active);

      // Split the academic year into two years
      $years = explode('-', $activeId['year']);
?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Evaluation</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="profile.php">Home</a></li>
              <li class="breadcrumb-item active">Evaluation</li>
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
          <div class="card-header text-center">
            <a href="evaluate_print.php?section_Id=<?= $section_Id; ?>&&subject_Id=<?= $subject_Id; ?>&&user_Id=<?= $user_Id; ?>" class="btn btn-dark btn-sm float-sm-right"><i class="fa-solid fa-print"></i> Print</a>
            <h5>Instrument for Instruction/Teaching Effectiveness</h5>
            <?php 
              if (count($years) === 2) {
                  $startYear = trim($years[0]);
                  $endYear = trim($years[1]);
                  echo '<h6>Rating Period: <span class="text-bold" style="text-decoration: underline;">'.$startYear.'</span> to <span class="text-bold" style="text-decoration: underline;">'.$endYear.'</span></h6>';
              } else {
                  // Handle the case where the data is not in the expected format
                  echo "<h6>Invalid academic year format</h6>";
              }
            ?>
            <h6>Name of Faculty: <span class="text-bold" style="text-decoration: underline;"><?php echo ' '.$fac['firstname'].' '.$fac['middlename'].' '.$fac['lastname'].' '.$fac['suffix'].' '; ?></span></h6>

            <div id="print_Element">
              <p>Note: This questionnaire gives you an opportunity to express anonymously your views about your instructor. Carefully and honestly rate the performance of your instructor.</p>
              <br><p><b>Instructions. Read each statement carefully and indicate your response by writing your rating on the provided answer sheet. The number rating stands for the following:</b></p>

              <table class="table table-bordered table-hover text-sm table-sm">
                <thead>
                <tr class="text-center"> 
                  <th>SCALE</th>
                  <th>DESCRIPTIVE RATING</th>
                  <!--<th>QUALITATIVE DESCRIPTION</th>-->
                </tr>
                </thead>
                <tbody id="users_data">
                  <tr>
                     <td class="text-center">5</td>
                     <td class="text-center">Always</td>
                     <!--<td class="text-justify text-center">The performance almost always exceeds the job requirements. The Faculty is an exceptional role model</td>-->
                  </tr>
                  <tr>
                     <td class="text-center">4</td>
                     <td class="text-center">Most of the time</td>
                     <!--<td class="text-justify text-center">The performance meets and often exceeds the job requirements</td>-->
                  </tr>
                  <tr>
                     <td class="text-center">3</td>
                     <td class="text-center">Sometimes</td>
                     <!--<td class="text-justify text-center">The performance meets job requirements</td>-->
                  </tr>
                  <tr>
                     <td class="text-center">2</td>
                     <td class="text-center">Once in a while</td>
                     <!--<td class="text-justify text-center">The performance needs some development to meet job requirements</td>-->
                  </tr>
                  <tr>
                     <td class="text-center">1</td>
                     <td class="text-center">Rarely</td>
                     <!--<td class="text-justify text-center">The faculty fails to meet the job requirements</td>-->
                  </tr>
                </tbody>
              </table>
            </div>
          </div>


          <div class="card-body">
          <style>
           #example111 th:first-child {
              width: 700px; /* Adjust the width as needed */
            }
          </style>
          
            <input type="hidden" class="form-control" name="evaluated_by" id="evaluated_by" value="<?php echo $id; ?>">
            <input type="hidden" class="form-control" name="section_Id" id="section_Id" value="<?php echo $section_Id; ?>">
            <input type="hidden" class="form-control" name="subject_Id" id="subject_Id" value="<?php echo $subject_Id; ?>">
            <input type="hidden" class="form-control" name="user_Id" id="user_Id" value="<?php echo $user_Id; ?>">
            <input type="hidden" class="form-control" name="acad_Id" id="acad_Id" value="<?php echo $activeId['acad_Id']; ?>">

            <table id="example111" class="table table-bordered table-hover text-sm table-sm">
              <thead>
                <tr>
                  <th scope="col">A.  Attitude Toward Students</th>
                  <th colspan="5" scope="col">Scale</th>
                  <th colspan="1" scope="col">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1.  Listen and understand student's point of view; he/she may not agree but students feel understood. (Marunong makinig sa opinyon ng estudyante).</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A1_Sub"></span></td>
                </tr>
                <tr>
                  <td>2.  Imposes discipline among students fairly and consistently. (Patas at palagian ang pagpapatupad ng disiplina sa lahat ng mga mag-aaral).</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A2_Sub"></span></td>
                </tr>
                <tr>
                  <td>3.  Shows respect and consideration to all students. (Nagpapakita ng paggalang at konsiderasyon sa mga estudyante).</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A3_Sub"></span></td>
                </tr><tr>
                  <td>4.  Encourages students to study harder. (Hinihimok ang mga mag-aaral na mag-aral na mabuti).</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A4_Sub"></span></td>
                </tr>
                <tr>
                  <!--<td>5.  Keeps acurate records of student’s performance and prompt submission of the same.</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A5_Sub"></span></td>
                </tr>-->
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" class="text-center text-bold">Total Score</td>
                  <td class="text-center text-bold"><span id="A_Total">0</span></td>
                </tr>
              </tfoot>
            </table>

            <br>

            <table id="example111" class="table table-bordered table-hover text-sm table-sm">
              <thead>
                <tr>
                  <th scope="col">B.  Subject Matter Presentation</th>
                  <th colspan="5" scope="col">Scale</th>
                  <th colspan="1" scope="col">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1.  Follows the syllabus/course outline provided by BPC. (Sinusunod ang gabay sa Pagtuturo ng BPC). </td>
                  <td class="p-2 text-center"><input type="radio" name="B1" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B1" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B1" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B1" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B1" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B1_Sub"></span></td>
                </tr>
                <tr>
                  <td>2.  Discusses lesson clearly & shows mastery on it. (Tinatalakay ng malinaw at nagpapakita ng malalim na kaalaman ukol sa aralin).</td>
                  <td class="p-2 text-center"><input type="radio" name="B2" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B2" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B2" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B2" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B2" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B2_Sub"></span></td>
                </tr>
                <tr>
                  <td>3.  Answers questions intelligently and welcomes comments. (Sinasagot ng may katalinuhan ang mga tanong at tinatanggap ang mga komento). </td>
                  <td class="p-2 text-center"><input type="radio" name="B3" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B3" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B3" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B3" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B3" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B3_Sub"></span></td>
                </tr><tr>
                  <td>4.  Uses chalkboard and/or other audio-visual materials to effectively contribute to student's understanding of the lesson. (Gumagamit ng chalkboard at/o anomang audio-visual na bagay upang higit na makatulong sa pagkatuto ng mga mag-aaral).</td>
                  <td class="p-2 text-center"><input type="radio" name="B4" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B4" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B4" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B4" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B4" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B4_Sub"></span></td>
                </tr>
                <tr>
                  <td>5.  Speaks loudly and uses classroom language efficiently. (Malakas magsalita at ginagamit ng maayos ang lengwaheng pangsilid-aralan). </td>
                  <td class="p-2 text-center"><input type="radio" name="B5" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B5" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B5" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B5" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B5" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B5_Sub"></span></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" class="text-center text-bold">Total Score</td>
                  <td class="text-center text-bold"><span id="B_Total">0</span></td>
                </tr>
              </tfoot>
            </table>

            <br>

            <table id="example111" class="table table-bordered table-hover text-sm table-sm">
              <thead>
                <tr>
                  <th scope="col">C.  Classroom Management</th>
                  <th colspan="5" scope="col">Scale</th>
                  <th colspan="1" scope="col">Subtotal</th>
              </thead>
              <tbody>
                <tr>
                  <td>1.  Checks the attendance systematically & consistently. (Maayos at palagiang tsine-check ang attendance).</td>
                  <td class="p-2 text-center"><input type="radio" name="C1" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="C1" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="C1" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="C1" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="C1" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="C1_Sub"></span></td>
                </tr>
                <tr>
                  <td>2.  Requires students to cooperate in maintaining classroom cleanliness for a better classroom atmosphere. (Inuutusan ang mga mag-aaral na makiisa sa pagpapanatilo ng kaaya-ayang silid-aralan).</td>
                  <td class="p-2 text-center"><input type="radio" name="C2" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="C2" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="C2" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="C2" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="C2" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="C2_Sub"></span></td>
                </tr>
                <tr>
                  <td>3.  Implements school's rules and regulations particularly in wearing ID and proper uniform. (Ipinatutipad ang batas at panuntunan ng paaralan lalo na sa pagsusuot ng ID at tamang uniporme). </td>
                  <td class="p-2 text-center"><input type="radio" name="C3" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="C3" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="C3" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="C3" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="C3" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="C3_Sub"></span></td>
                </tr><!--<tr>
                  <td>4.  Allows students to think independently and make their own decisions and holding them accountable for their performance based largely on their success in executing decisions.</td>
                  <td class="p-2 text-center"><input type="radio" name="C4" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="C4" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="C4" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="C4" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="C4" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="C4_Sub"></span></td>
                </tr>-->
                <!--<tr>
                  <td>5.  Encourages students to learn beyond what is required and help/guide the students how to apply the concept learned. </td>
                  <td class="p-2 text-center"><input type="radio" name="C5" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="C5" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="C5" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="C5" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="C5" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="C5_Sub"></span></td>
                </tr>-->
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" class="text-center text-bold">Total Score</td>
                  <td class="text-center text-bold"><span id="C_Total">0</span></td>
                </tr>
              </tfoot>
            </table>

            <br>

            <table id="example111" class="table table-bordered table-hover text-sm table-sm">
              <thead>
                <tr>
                  <th scope="col">D.  Etiquette</th>
                  <th colspan="5" scope="col">Scale</th>
                  <th colspan="1" scope="col">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1.  Dresses neatly and respectably. (Malinis at kagalang-galang manamit). </td>
                  <td class="p-2 text-center"><input type="radio" name="D1" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="D1" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="D1" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="D1" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="D1" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="D1_Sub"></span></td>
                </tr>
                <tr>
                  <td>2.  Starts and ends classes on time. (Sinisimulan at tinatapos ang klase sa tamang oras).</td>
                  <td class="p-2 text-center"><input type="radio" name="D2" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="D2" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="D2" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="D2" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="D2" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="D2_Sub"></span></td>
                </tr>
                <tr>
                  <td>3.  Returns recorded test papers and projects. (Ibinabalik ang mga naitalang test papers at proyekto).</td>
                  <td class="p-2 text-center"><input type="radio" name="D3" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="D3" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="D3" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="D3" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="D3" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="D3_Sub"></span></td>
                </tr><tr>
                  <td>4.  Gives transparent and fair grades and criticism. (Nagbibigay ng malinaw at patas na marka at puna).</td>
                  <td class="p-2 text-center"><input type="radio" name="D4" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="D4" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="D4" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="D4" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="D4" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="D4_Sub"></span></td>
                </tr>
                <!--<tr>
                  <td>5.  Use of Instructional Materials (audio/video materials: fieldtrips, film showing, computer aided instruction and etc.) to reinforces learning processors. </td>
                  <td class="p-2 text-center"><input type="radio" name="D5" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="D5" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="D5" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="D5" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="D5" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="D5_Sub"></span></td>
                </tr>-->
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" class="text-center text-bold">Total Score</td>
                  <td class="text-center text-bold"><span id="D_Total">0</span></td>
                </tr>
              </tfoot>
            </table>
            
          </div>
          <div class="card-footer">
              <a type="button" class="btn btn-primary btn-sm float-sm-right" id="done_evaluation"><i class="fa-solid fa-circle-check"></i> Submit</a>
              <button type="button" class="mr-2 btn btn-dark btn-sm float-sm-right" id="clear_evaluation"><i class="fa-sharp fa-solid fa-trash"></i> Clear All</button>
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
<?php } else { include '404.php'; } include 'footer.php'; ?>

<script>

  $(document).ready(function() {

    $('input[type="radio"]').on('click', function() {
      var evaluated_by = $('#evaluated_by').val();
      var sectionId = $('#section_Id').val();
      var subjectId = $('#subject_Id').val();
      var userId = $('#user_Id').val();
      var acad_Id = $('#acad_Id').val();
      var inputName = $(this).attr('name');
      var inputValue = $(this).val();

      // AJAX request for Table 1: evaluation
      $.ajax({
        url: 'process_save.php',
        method: 'POST',
        data: {
          evaluated_by: evaluated_by,
          section_Id: sectionId,
          subject_Id: subjectId,
          user_Id: userId,
          acad_Id: acad_Id,
          input_name: inputName,
          input_value: inputValue,
          table: 'evaluation'
        },
        success: function(response) {
          console.log(response);
          // Handle success response here
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          // Handle error response here
        }
      });
    });

    $('input[type="radio"]').on('click', function() {
      var inputName = $(this).attr('name');
      var inputValue = parseInt($(this).val());

      // Calculate and update subtotal
      var subtotal = inputValue;
      $('#'+inputName+'_Sub').text(subtotal);

      // Calculate and update total
      calculateTotal();
    });

    function calculateTotal() {
      var a_total = 0;
      $('[id^="A"][id$="_Sub"]').each(function() {
        a_total += parseInt($(this).text()) || 0;
      });
      $('#A_Total').text(a_total);

      var b_total = 0;
      $('[id^="B"][id$="_Sub"]').each(function() {
        b_total += parseInt($(this).text()) || 0;
      });
      $('#B_Total').text(b_total);

      var c_total = 0;
      $('[id^="C"][id$="_Sub"]').each(function() {
        c_total += parseInt($(this).text()) || 0;
      });
      $('#C_Total').text(c_total);

      var d_total = 0;
      $('[id^="D"][id$="_Sub"]').each(function() {
        d_total += parseInt($(this).text()) || 0;
      });
      $('#D_Total').text(d_total);
    }



    // Clear All button click event
    $('#clear_evaluation').on('click', function() {
      // Display a confirmation dialog
      var confirmation = confirm("Are you sure you want to clear?");

      // Check if the user clicked 'OK' in the confirmation dialog
      if (confirmation) {
        // Uncheck all radio buttons
        $('input[type="radio"]').prop('checked', false);

        // Reset the subtotal and total values
        $('[id$="_Sub"]').text('0');
        $('#A_Total').text('0');
        $('#B_Total').text('0');
        $('#C_Total').text('0');
        $('#D_Total').text('0');

        // Delete record from the evaluation table
        var evaluated_by = $('#evaluated_by').val();
        var sectionId = $('#section_Id').val();
        var subjectId = $('#subject_Id').val();
        var userId = $('#user_Id').val();
        var acad_Id = $('#acad_Id').val();

        $.ajax({
          url: 'process_delete.php',
          method: 'POST',
          data: {
            evaluated_by: evaluated_by,
            section_Id: sectionId,
            subject_Id: subjectId,
            user_Id: userId,
            acad_Id: acad_Id
          },
          success: function(response) {
            console.log(response);
            // Handle success response here
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseText);
            // Handle error response here
          }
        });
      }
    });




 $('#done_evaluation').on('click', function(e) {
  var uncheckedRowsExist = false;

  // Check if any row in Table 1 has an unchecked radio button
  $('#example111 tbody tr').each(function() {
    if ($(this).find('input[type="radio"]:checked').length === 0) {
      uncheckedRowsExist = true;
      return false; // Exit the loop early if an unchecked radio button is found
    }
  });

  if (uncheckedRowsExist) {
    e.preventDefault(); // Prevent navigating to dashboard.php
    alert('Please complete all evaluations before proceeding.');
  } else {
    // Make an AJAX request to update evaluation_status
    var evaluatedBy = $('#evaluated_by').val();
    var sectionId = $('#section_Id').val();
    var subjectId = $('#subject_Id').val();
    var userId = $('#user_Id').val();
    var acadId = $('#acad_Id').val();
     

    $.ajax({
      url: 'process_update.php',
      method: 'POST',
      data: {
        evaluated_by: evaluatedBy,
        section_Id: sectionId,
        subject_Id: subjectId,
        user_Id: userId,
        acad_Id: acadId
      },
      success: function(response) {
        console.log('Evaluation status updated successfully.');
        // Display SweetAlert on success
        swal({
          title: "Submitted successfully",
          text: "Success",
          icon: "success",
          confirmButtonColor: '#3085d6',
          confirmButtonText: "Okay",
          timer: 5000
        });

        // Redirect to dashboard.php after 5 seconds
        setTimeout(function() {
          window.location.href = 'dashboard.php';
        }, 5000);
      },
      error: function(xhr, status, error) {
        console.error('An error occurred while updating evaluation status:', error);
      }
    });
  }



  
});


  });
 
</script>
