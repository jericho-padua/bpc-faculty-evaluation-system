<title>BPC Faculty Evaluation System | Evaluation criteria</title>
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
<style>
 #example111 th:first-child {
    width: 700px; /* Adjust the width as needed */
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Evaluation criteria</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="profile.php">Home</a></li>
              <li class="breadcrumb-item active">Evaluation criteria</li>
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
            <button id="printButton" class="btn btn-success btn-sm float-sm-right mr-4 mb-3"><i class="fa-solid fa-print"></i> Print</button>
             <a href="evaluate.php?section_Id=<?= $section_Id; ?>&&subject_Id=<?= $subject_Id; ?>&&user_Id=<?= $user_Id; ?>" type="button" class="btn btn-secondary btn-sm float-sm-right mr-2"><i class="fa-solid fa-backward"></i> Back</a>
            <div class="card-body">
              <div id="printElement">
                <h6>Instrument for Instruction/Teaching Effectiveness</h6>
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

                <br>

                <p class="text-left">Note: This questionnaire gives you an opportunity to express anonymously your views about your instructor. Carefully and honestly rate the performance of your instructor.</p>
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
         
                <br><br>

                <table id="example111" class="table table-bordered table-hover text-sm table-sm">
                  <thead>
                    <tr>
                      <th scope="col">A.  Attitude Toward Students</th>
                      <th colspan="5" scope="col">Scale</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1.  Listen and understand student's point of view; he/she may not agree but students feel understood. (Marunong makinig sa opinyon ng estudyante).</td>
                      <td class="p-2 text-center">1</td>
                      <td class="p-2 text-center">2</td>
                      <td class="p-2 text-center">3</td>
                      <td class="p-2 text-center">4</td>
                      <td class="p-2 text-center">5</td>
                    </tr>
                    <tr>
                      <td>2.  Imposes discipline among students fairly and consistently. (Patas at palagian ang pagpapatupad ng disiplina sa lahat ng mga mag-aaral).</td>
                      <td class="p-2 text-center">1</td>
                      <td class="p-2 text-center">2</td>
                      <td class="p-2 text-center">3</td>
                      <td class="p-2 text-center">4</td>
                      <td class="p-2 text-center">5</td>
                    </tr>
                    <tr>
                      <td>3.  Shows respect and consideration to all students. (Nagpapakita ng paggalang at konsiderasyon sa mga estudyante).</td>
                      <td class="p-2 text-center">1</td>
                      <td class="p-2 text-center">2</td>
                      <td class="p-2 text-center">3</td>
                      <td class="p-2 text-center">4</td>
                      <td class="p-2 text-center">5</td>
                    </tr><tr>
                      <td>4.  Encourages students to study harder. (Hinihimok ang mga mag-aaral na mag-aral na mabuti).</td>
                      <td class="p-2 text-center">1</td>
                      <td class="p-2 text-center">2</td>
                      <td class="p-2 text-center">3</td>
                      <td class="p-2 text-center">4</td>
                      <td class="p-2 text-center">5</td>
                    </tr>
                    <!--<tr>
                      <td>5.  Keeps acurate records of student’s performance and prompt submission of the same.</td>
                      <td class="p-2 text-center">1</td>
                      <td class="p-2 text-center">2</td>
                      <td class="p-2 text-center">3</td>
                      <td class="p-2 text-center">4</td>
                      <td class="p-2 text-center">5</td>
                    </tr>-->
                  </tbody>
                </table>

              <br>

              <table id="example111" class="table table-bordered table-hover text-sm table-sm">
                <thead>
                  <tr>
                    <th scope="col">B.  Subject Matter Presentation</th>
                    <th colspan="5" scope="col">Scale</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1.  Follows the syllabus/course outline provided by BPC. (Sinusunod ang gabay sa Pagtuturo ng BPC). </td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                  <tr>
                    <td>2.  Discusses lesson clearly & shows mastery on it. (Tinatalakay ng malinaw at nagpapakita ng malalim na kaalaman ukol sa aralin).</td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                  <tr>
                    <td>3.  Answers questions intelligently and welcomes comments. (Sinasagot ng may katalinuhan ang mga tanong at tinatanggap ang mga komento). </td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                  <tr>
                    <td>4.  Uses chalkboard and/or other audio-visual materials to effectively contribute to student's understanding of the lesson. (Gumagamit ng chalkboard at/o anomang audio-visual na bagay upang higit na makatulong sa pagkatuto ng mga mag-aaral).</td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                  <tr>
                    <td>5.  Speaks loudly and uses classroom language efficiently. (Malakas magsalita at ginagamit ng maayos ang lengwaheng pangsilid-aralan). </td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                </tbody>
              </table>

              <br>

              <table id="example111" class="table table-bordered table-hover text-sm table-sm">
                <thead>
                  <tr>
                    <th scope="col">C.  Classroom Management</th>
                    <th colspan="5" scope="col">Scale</th>
                </thead>
                <tbody>
                  <tr>
                    <td>1.  Checks the attendance systematically & consistently. (Maayos at palagiang tsine-check ang attendance).</td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                  <tr>
                    <td>2.  Requires students to cooperate in maintaining classroom cleanliness for a better classroom atmosphere. (Inuutusan ang mga mag-aaral na makiisa sa pagpapanatilo ng kaaya-ayang silid-aralan).</td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                  <tr>
                    <td>3.  Implements school's rules and regulations particularly in wearing ID and proper uniform. (Ipinatutipad ang batas at panuntunan ng paaralan lalo na sa pagsusuot ng ID at tamang uniporme). </td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr><!--<tr>
                    <td>4.  Allows students to think independently and make their own decisions and holding them accountable for their performance based largely on their success in executing decisions.</td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>-->
                  <!--<tr>
                    <td>5.  Encourages students to learn beyond what is required and help/guide the students how to apply the concept learned. </td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>-->
                </tbody>
              </table>

              <br>

              <table id="example111" class="table table-bordered table-hover text-sm table-sm">
                <thead>
                  <tr>
                    <th scope="col">D.  Management of Learning</th>
                    <th colspan="5" scope="col">Scale</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1.  Dresses neatly and respectably. (Malinis at kagalang-galang manamit). </td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                  <tr>
                    <td>2.  Starts and ends classes on time. (Sinisimulan at tinatapos ang klase sa tamang oras).</td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                  <tr>
                    <td>3.  Returns recorded test papers and projects. (Ibinabalik ang mga naitalang test papers at proyekto).</td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr><tr>
                    <td>4.  Gives transparent and fair grades and criticism. (Nagbibigay ng malinaw at patas na marka at puna).</td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>
                  <!--<tr>
                    <td>5.  Use of Instructional Materials (audio/video materials: fieldtrips, film showing, computer aided instruction and etc.) to reinforces learning processors. </td>
                    <td class="p-2 text-center">1</td>
                    <td class="p-2 text-center">2</td>
                    <td class="p-2 text-center">3</td>
                    <td class="p-2 text-center">4</td>
                    <td class="p-2 text-center">5</td>
                  </tr>-->
                </tbody>
              </table>
              
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
<script src="print.js"></script>
<?php } else { include '404.php'; } include 'footer.php'; ?>

<script>
   $(window).on('load', function() {
    document.getElementById("printButton").click();
   })
 </script>