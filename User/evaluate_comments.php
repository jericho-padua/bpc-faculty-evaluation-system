<title>BPC Faculty Evaluation System | Evaluation</title>
<?php
include 'navbar.php';
if (isset($_GET['section_Id']) && isset($_GET['subject_Id']) && isset($_GET['user_Id'])) {
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


  if (!isset($_SESSION['eval_section_Id']) || !isset($_SESSION['eval_subject_Id']) || !isset($_SESSION['eval_user_Id']) || $_SESSION['eval_section_Id'] !== $section_Id || $_SESSION['eval_subject_Id'] !== $subject_Id || $_SESSION['eval_user_Id'] !== $user_Id) {
    $isNewEvaluation = true;
  }

  // Set session variables
  $_SESSION['eval_section_Id'] = $section_Id;
  $_SESSION['eval_subject_Id'] = $subject_Id;
  $_SESSION['eval_user_Id'] = $user_Id;

  // Select only the com field from the evaluation table
  $query = "SELECT com 
            FROM comment 
            WHERE section_Id='$section_Id' AND subject_Id='$subject_Id' AND user_Id='$user_Id'";
  
  $result = mysqli_query($conn, $query);

  // Fetch the result
  $evaluationData = mysqli_fetch_array($result);
  $com = $evaluationData['com'];  // Assign the com value to $com

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Comments</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="profile.php">Home</a></li>
              <li class="breadcrumb-item active">Comments</li>
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
          <div class="card-body text-center">

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
              <p>Note: This comments gives you an opportunity to express anonymously your views about your instructor. Carefully and honestly comment the performance of your instructor.</p>
              


            </div>
          </div>

          <form action="process_save.php" method="post">
          <div class="card-body">

            <input type="hidden" class="form-control" name="evaluated_by" id="evaluated_by" value="<?php echo $id; ?>">
            <input type="hidden" class="form-control" name="section_Id" id="section_Id" value="<?php echo $section_Id; ?>">
            <input type="hidden" class="form-control" name="subject_Id" id="subject_Id" value="<?php echo $subject_Id; ?>">
            <input type="hidden" class="form-control" name="user_Id" id="user_Id" value="<?php echo $user_Id; ?>">
            <input type="hidden" class="form-control" name="acad_Id" id="acad_Id" value="<?php echo $activeId['acad_Id']; ?>">

            <br><label for="com" >Comments:</label>
            <textarea name="com" id="com" rows="10" cols="191" class="form-control" required><?php echo isset($com) ? htmlspecialchars($com) : '' ?></textarea>
          </div>
          <div class="card-footer">
            <button type="submit" name="com" class="btn btn-primary btn-sm float-sm-right" id="done_evaluation"><i class="fa-solid fa-circle-check"></i> Submit</button>
          </div>
          <!-- Add this anchor tag -->
<div class="card-footer">
    <a href="dashboard.php" class="btn btn-secondary btn-sm float-sm-left">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>
</div>
        </div>
        </form>
      </div>
    </section>

    <!-- /.content -->
  </div>
<?php } else {
  include '404.php';
}
include 'footer.php'; ?>

<script>
  $(document).ready(function() {
    $('#done_evaluation').click(function(e) {
        e.preventDefault();

        var evaluated_by = $('#evaluated_by').val();
        var sectionId = $('#section_Id').val();
        var subjectId = $('#subject_Id').val();
        var userId = $('#user_Id').val();
        var acad_Id = $('#acad_Id').val();
        var com = $('#com').val();

        // AJAX request
        $.ajax({
            url: 'process_save.php',
            method: 'POST',
            data: {
                evaluated_by: evaluated_by,
                section_Id: sectionId,
                subject_Id: subjectId,
                user_Id: userId,
                acad_Id: acad_Id,
                com: com
            },
            success: function(response) {
                console.log(response);
                // Handle success response here, like showing a success message to the user
                alert(response); // Temporary alert to show the response
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                // Handle error response here, like showing an error message to the user
                alert("Error: " + xhr.responseText); // Temporary alert to show the error
            }
        });
    });
});

</script>