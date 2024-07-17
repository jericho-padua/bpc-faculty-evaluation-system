<title>BPC Faculty Evaluation System | Evaluation</title>
<?php
include 'navbar.php';
if (isset($_GET['evaluated_by']) && isset($_GET['user_Id'])) {
  $evaluated_by = mysqli_real_escape_string($conn, $_GET['evaluated_by']);
  $user_Id = mysqli_real_escape_string($conn, $_GET['user_Id']);

  $faculty = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id'");
  $fac = mysqli_fetch_array($faculty);

  // GET ACTIVE YEAR FOR EVALUATION
  $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
  $activeId = mysqli_fetch_array($active);

  // Split the academic year into two years
  $years = explode('-', $activeId['year']);

  $isNewEvaluation = false;
  // Check if it's a new evaluation
  if (
    !isset($_SESSION['evaluated_by_faculty']) || !isset($_SESSION['user_Id_faculty']) ||
    $_SESSION['evaluated_by_faculty'] !== $evaluated_by || $_SESSION['user_Id_faculty'] !== $user_Id
  ) {
    $isNewEvaluation = true;
  }

  // Set session variables
  $_SESSION['evaluated_by_faculty'] = $evaluated_by;
  $_SESSION['user_Id_faculty'] = $user_Id;

  // Output JavaScript to clear local storage if it's a new evaluation
  if ($isNewEvaluation) {
    echo "<script>";
    echo "localStorage.removeItem('storedData');";
    echo "</script>";
  }
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
            <?php if ($row['user_type'] == 'Dean') : ?>
              <a href="evaluate_print.php?section_Id=<?= $section_Id; ?>&&subject_Id=<?= $subject_Id; ?>&&user_Id=<?= $user_Id; ?>" class="btn btn-dark btn-sm float-sm-right"><i class="fa-solid fa-print"></i> Print</a>
            <?php endif; ?>

            <h5>Instrument for Instruction/Teaching Effectiveness</h5>
            <?php
            if (count($years) === 2) {
              $startYear = trim($years[0]);
              $endYear = trim($years[1]);
              echo '<h6>Rating Period: <span class="text-bold" style="text-decoration: underline;">' . $startYear . '</span> to <span class="text-bold" style="text-decoration: underline;">' . $endYear . '</span></h6>';
            } else {
              // Handle the case where the data is not in the expected format
              echo "<h6>Invalid academic year format</h6>";
            }
            ?>
            <h6>Name of Faculty: <span class="text-bold" style="text-decoration: underline;"><?php echo ' ' . $fac['firstname'] . ' ' . $fac['middlename'] . ' ' . $fac['lastname'] . ' ' . $fac['suffix'] . ' '; ?></span></h6>

            <div id="print_Element">
              <p>Instructions: Please evaluate the faculty using the scale below. Encircle your rating.</p>

              <table class="table table-bordered table-hover text-sm table-sm">
                <thead>
                  <tr class="text-center">
                    <th>SCALE</th>
                    <th>DESCRIPTIVE RATING</th>
                  </tr>
                </thead>
                <tbody id="users_data">
                  <tr>
                    <td class="text-center">5</td>
                    <td class="text-center">Outstanding</td>
                  </tr>
                  <tr>
                    <td class="text-center">4</td>
                    <td class="text-center">Very Satisfactory</td>
                  </tr>
                  <tr>
                    <td class="text-center">3</td>
                    <td class="text-center">Satisfactory</td>
                  </tr>
                  <tr>
                    <td class="text-center">2</td>
                    <td class="text-center">Fair</td>
                  </tr>
                  <tr>
                    <td class="text-center">1</td>
                    <td class="text-center">Poor</td>
                  </tr>
                </tbody>
              </table>
              <br />
            </div>
          </div>


          <div class="card-body">
            <style>
              #example111 th:first-child {
                width: 700px;
                /* Adjust the width as needed */
              }
            </style>
            <input type="hidden" class="form-control" name="evaluated_by" id="evaluated_by" value="<?php echo $id; ?>">
            <input type="hidden" class="form-control" name="user_Id" id="user_Id" value="<?php echo $user_Id; ?>">
            <input type="hidden" class="form-control" name="acad_Id" id="acad_Id" value="<?php echo $activeId['acad_Id']; ?>">

            <table id="example111" class="table table-bordered table-hover text-sm table-sm">
              <thead>
                <tr>
                  <th scope="col">A. On Instruction and Administrative Functions</th>
                  <th colspan="5" scope="col">Scale</th>
                  <th colspan="1" scope="col">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1. Adhere to the faithful implementation of the policies on students performance in the class, values development, examination procedures, and other school policies.</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A1" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A1_Sub"></span></td>
                </tr>
                <tr>
                  <td>2. Imposes objectivism, by providing a sound judgement of evaluation of the students' academic performance according to the grading system or policies.</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A2" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A2_Sub"></span></td>
                </tr>
                <tr>
                  <td>3. Creates a classroom climate conducive to teaching and learning processes.</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A3" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A3_Sub"></span></td>
                </tr>
                <tr>
                  <td>4. Practices exemplary punctuality in attending classes.</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A4" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A4_Sub"></span></td>
                </tr>
                <tr>
                  <td>5. Attends faculty meetings, area or committee meetings, in-service training assemblies, graduation exercises and other school functions.</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A5" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A5_Sub"></span></td>
                </tr>
                <tr>
                  <td>6. Observes punctuality in the submission of school's requirements such as examination, committee reports and grading sheets of the students and other reports duly assigned by the College administrator.</td>
                  <td class="p-2 text-center"><input type="radio" name="A6" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A6" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A6" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A6" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A6" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A6_Sub"></span></td>
                </tr>
                <tr>
                  <td>7. Imposes virtual classroom disciplines.</td>
                  <td class="p-2 text-center"><input type="radio" name="A7" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A7" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A7" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A7" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A7" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A7_Sub"></span></td>
                </tr>
                <tr>
                  <td>8. Serves as good class adviser or club moderator/serves as good example in the campus.</td>
                  <td class="p-2 text-center"><input type="radio" name="A8" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A8" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A8" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A8" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A8" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A8_Sub"></span></td>
                </tr>
                <tr>
                  <td>9. Endeavors for the accomplishment of the institution's mission and vision.</td>
                  <td class="p-2 text-center"><input type="radio" name="A9" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="A9" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="A9" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="A9" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="A9" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="A9_Sub"></span></td>
                </tr>
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
                  <th scope="col">B. On Professionalism</th>
                  <th colspan="5" scope="col">Scale</th>
                  <th colspan="1" scope="col">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>10. Conducts pre-consultation with the College Administrator/Cluster Heads before implementing certain rules and regulations. </td>
                  <td class="p-2 text-center"><input type="radio" name="B10" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B10" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B10" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B10" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B10" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B10_Sub"></span></td>
                </tr>
                <tr>
                  <td>11. Possesses potential qualities of being present-minded, creative, optimistic, open-minded and willing to champion he/her profession.</td>
                  <td class="p-2 text-center"><input type="radio" name="B11" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B11" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B11" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B11" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B11" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B11_Sub"></span></td>
                </tr>
                <tr>
                  <td>12. Upholds the noble task of providing and insuring high standard of teaching through the adoptin of innovative methodologies. </td>
                  <td class="p-2 text-center"><input type="radio" name="B12" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B12" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B12" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B12" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B12" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B12_Sub"></span></td>
                </tr>
                <tr>
                  <td>13. Adopts conscientious, just and humane teaching techniques that promote desirable transformation of moral values of the students.</td>
                  <td class="p-2 text-center"><input type="radio" name="B13" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B13" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B13" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B13" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B13" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B13_Sub"></span></td>
                </tr>
                <tr>
                  <td>14. Instills harmonious relationship with the administration and adheres to the objectives and implementing rules of the school by recognizing authority channels, and open to communication processes. </td>
                  <td class="p-2 text-center"><input type="radio" name="B14" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B14" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B14" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B14" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B14" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B14_Sub"></span></td>
                </tr>
                <tr>
                  <td>15. Gives importance to the needs of the school's working committees through active participation if needed. </td>
                  <td class="p-2 text-center"><input type="radio" name="B15" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B15" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B15" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B15" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B15" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B15_Sub"></span></td>
                </tr>
                <tr>
                  <td>16. Have a strong support and full understanding of the contributions of the faculty and their area of specialization in the common task of higher education. </td>
                  <td class="p-2 text-center"><input type="radio" name="B16" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B16" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B16" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B16" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B16" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B16_Sub"></span></td>
                </tr>
                <tr>
                  <td>17. Observes professional growth through pursuit of post degree course that are relevant to their teaching needs and by attending seminars and conferences.</td>
                  <td class="p-2 text-center"><input type="radio" name="B17" class="btn btn-xs btn-primary" value="1"> 1</td>
                  <td class="p-2 text-center"><input type="radio" name="B17" class="btn btn-xs btn-primary" value="2"> 2</td>
                  <td class="p-2 text-center"><input type="radio" name="B17" class="btn btn-xs btn-primary" value="3"> 3</td>
                  <td class="p-2 text-center"><input type="radio" name="B17" class="btn btn-xs btn-primary" value="4"> 4</td>
                  <td class="p-2 text-center"><input type="radio" name="B17" class="btn btn-xs btn-primary" value="5"> 5</td>
                  <td class="p-2 text-center"><span id="B17_Sub"></span></td>
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
<?php } else {
  include '404.php';
}
include 'footer.php'; ?>

<script>
  $(document).ready(function() {



    // Function to load saved choices from localStorage
    function loadSavedChoices() {
      $('input[type="radio"]').each(function() {
        var inputName = $(this).attr('name');
        var savedValue = localStorage.getItem(inputName);
        if (savedValue) {
          $(this).prop('checked', false); // Uncheck all radio buttons
          $(this).filter('[value="' + savedValue + '"]').prop('checked', true); // Check the saved radio button
          updateSubtotal(inputName, savedValue); // Update subtotal
        }
      });
      calculateTotal(); // Calculate and update total
    }

    // Function to update subtotal based on radio button selection
    function updateSubtotal(inputName, inputValue) {
      var subtotal = parseInt(inputValue) || 0;
      $('#' + inputName + '_Sub').text(subtotal);
    }



    $('input[type="radio"]').on('click', function() {
      var evaluated_by = $('#evaluated_by').val();
      var userId = $('#user_Id').val();
      var acad_Id = $('#acad_Id').val();
      var inputName = $(this).attr('name');
      var inputValue = $(this).val();
      // Save the selected choice to localStorage
      localStorage.setItem(inputName, inputValue);
      // Update subtotal
      updateSubtotal(inputName, inputValue);
      // AJAX request for Table 1: evaluation
      $.ajax({
        url: 'process_save_faculty.php',
        method: 'POST',
        data: {
          evaluated_by: evaluated_by,
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
      calculateTotal(); // Calculate and update total

    });

    $('input[type="radio"]').on('click', function() {
      var inputName = $(this).attr('name');
      var inputValue = parseInt($(this).val());

      // Calculate and update subtotal
      var subtotal = inputValue;
      $('#' + inputName + '_Sub').text(subtotal);

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
        localStorage.removeItem(inputName);
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
        var userId = $('#user_Id').val();
        var acad_Id = $('#acad_Id').val();

        $.ajax({
          url: 'process_delete_faculty.php',
          method: 'POST',
          data: {
            evaluated_by: evaluated_by,
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
        var userId = $('#user_Id').val();
        var acadId = $('#acad_Id').val();

        $.ajax({
          url: 'process_update_faculty.php',
          method: 'POST',
          data: {
            evaluated_by: evaluatedBy,
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
              timer: 2000
            });

            // Redirect to dashboard.php after 5 seconds
            setTimeout(function() {
              window.location.href = 'dashboard.php';
            }, 2000);
          },
          error: function(xhr, status, error) {
            console.error('An error occurred while updating evaluation status:', error);
          }
        });
      }
    });
    loadSavedChoices();

  });
</script>

<script>
  // Check if it's a new evaluation
  var isNewEvaluation = <?php echo json_encode($isNewEvaluation); ?>;

  // Function to clear local storage if it's a new evaluation
  function clearLocalStorage() {
    if (isNewEvaluation) {
      $('input[type="radio"]').each(function() {
        var inputName = $(this).attr('name');
        localStorage.removeItem(inputName);
      });
    }
  }

  // Execute the function after the page loads
  $(document).ready(function() {
    clearLocalStorage();
  });
</script>