<title>BPC Faculty Evaluation System | Evaluation</title>
<?php 
    include 'navbar.php'; 

    $active = mysqli_query($conn, "SELECT * FROM academic_year WHERE status = 1");
    if (mysqli_num_rows($active) > 0) {
        $showModal = false;
    } else {
        $showModal = true;
    }
?>
    <style>
      /* Hide the default dropdown arrow in the select element */
      select#user_Id::-ms-expand,
      select#user_Id::-webkit-select {
        display: none;
      }

      /* Add a custom arrow indicator, if needed */
      select#user_Id {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('path-to-your-custom-arrow-image.png'); /* Replace with your arrow image */
        background-position: right center;
        background-repeat: no-repeat;
        padding-right: 20px; /* Adjust as needed to align the arrow */
      }
    </style>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Evaluation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="profile.php">Home</a></li>
              <li class="breadcrumb-item active">Evaluation</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid ">
        <div class="row d-flex justify-content-center">

          <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="card">
              <!--EVALUATION TEACHERS (STUDENTS)-->
              <?php 
                  $sect_Id = $row['year_section'];
                  if($row['user_type'] == 'Student') { 
              ?>
              <form action="process_save.php" method="POST">
                <div class="card-header">
                  <h5>Evaluation requirement fields</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="evaluated_by" id="evaluated_by" class="form-control" value="<?php echo $id; ?>">
                    <?php if($row['stud_type'] == 'Regular') { ?>  
                      <div class="form-group">
                        <span class="text-dark text-bold">Section name</span>
                        <select name="section_Id" class="form-control" id="section_Id" onchange="getSubject_by_Section(this.value)" required>
                          <option value="" selected disabled>Select section</option>
                          <?php 
                            $user_section = $row['year_section'];
                            $sec = mysqli_query($conn, "SELECT * FROM section WHERE section_Id='$sect_Id' ORDER BY yr_level ");
                            if(mysqli_num_rows($sec) > 0) {
                              while ($s = mysqli_fetch_array($sec)) {
                                ?>
                                <option value="<?php echo $s['section_Id']; ?>" selected><?php echo $s['department'].' : '.$s['yr_level'].' - '.$s['section']; ?></option>
                                <?php
                              }
                            } else {
                          ?>
                            <option value="">No record found</option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                    <?php } else { ?>
                      <div class="form-group">
                        <span class="text-dark text-bold">Section name</span>
                        <select name="section_Id" class="form-control" id="section_Id" onchange="getSubject_by_Section(this.value)" required>
                          <option value="" selected disabled>Select section</option>
                          <?php 
                            $sec = mysqli_query($conn, "SELECT * FROM section ORDER BY yr_level ");
                            if(mysqli_num_rows($sec) > 0) {
                              while ($s = mysqli_fetch_array($sec)) {
                                ?>
                                <option value="<?php echo $s['section_Id']; ?>"><?php echo $s['yr_level'].' - '.$s['section'].' : '.$s['department']; ?></option>
                                <?php
                              }
                            } else {
                          ?>
                            <option value="">No record found</option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>
                    <?php } ?>

                      <div class="form-group">
                        <!-- INCLUDE THIS SIGNED IN USER VALUE TO SHOW ONLY FACULTIES THAT ARE NOT YET EVALUATED -->
                        <span class="text-dark text-bold">Subject</span>
                        <select name="subject_Id" class="form-control" id="subject_Id" onchange="getinstructor_by_Subject(this.value)" required>>
                          <option value="" selected disabled>Select subject</option>
                          <?php 
                            $sub = mysqli_query($conn, "SELECT * FROM subject JOIN academic_year ON subject.acad_Id=academic_year.acad_Id WHERE subject.section_Id='$sect_Id' AND subject.acad_Id IN (SELECT acad_Id FROM academic_year WHERE status=1) ORDER BY subject.name ");
                            if(mysqli_num_rows($sub) > 0) {
                              while ($s = mysqli_fetch_array($sub)) {
                                ?>
                                <option value="<?php echo $s['sub_Id']; ?>"><?php echo $s['name']; ?></option>
                                <?php
                              }
                            } else {
                          ?>
                            <option value="">No record found</option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <span class="text-dark text-bold">Instructor</span>
                        <select name="user_Id" class="form-control" id="user_Id" required>
                          <option value="" selected disabled>Select instructor</option>
                        </select>
                      </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-sm-right" name="evaluation">Proceed</button>
                </div>
              </form>
            <?php } else if ($row['user_type'] == 'Superior'){ ?>

              <!--EVALUATION TEACHERS (Superior)-->
              <form action="process_save.php" method="POST">
                <div class="card-header">
                  <h5>Evaluation requirement fields</h5>
                </div>
                <div class="card-body">
                  <input type="hidden" name="evaluated_by" id="evaluated_by" class="form-control" value="<?php echo $id; ?>">
                  <div class="form-group">
                    <span class="text-dark text-bold">Instructor</span>
                    <select name="user_Id" class="form-control" id="user_Id" required>
                      <option value="" selected disabled>Select instructor</option>
                      <?php
                      $instructors = mysqli_query($conn, "SELECT * FROM users WHERE faculty_status = 0");
if (mysqli_num_rows($instructors) > 0) {
    while ($row = mysqli_fetch_array($instructors)) {
        echo '<option value="'.$row['user_Id'].'" selected>'.$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].' '.$row['suffix'].'</option>';
    }
} else {
    echo '<option value="" selected>No faculty available.</option>';
}

                      ?>
                    </select>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-sm-right" name="evaluation_faculty">Proceed</button>
                  </div>
                </form>
            <?php } ?>
            </div>
          </div>
          

        </div>
      </div>
    </section>




    <!-- MODAL THAT SHOWS IF EVALUATION IS OFF -->
    <div class="modal fade" id="active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
             <div class="modal-header bg-light">
              <h5 class="modal-title" id="exampleModalLabel">Evaluation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();">
                <span aria-hidden="true"><i class="fa-solid fa-circle-xmark"></i></span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" name="acad_Id">
                <h6 class="text-center">Evaluation for teachers is not yet available.</h6>
            </div>
            <div class="modal-footer alert-light">
              <a href="dashboard.php" class="btn bg-secondary"><i class="fa-solid fa-backward"></i> Back</a>
            </div>
          </div>
        </div>
      </div>


  </div>

<?php include 'footer.php'; ?>
<script>
    $(window).on('load', function() {
        <?php if ($showModal) { ?>
            $('#active').modal('show');
        <?php } ?>
    });


    // GET SUBJECT BY SECTION
     function getSubject_by_Section(section_Id) {
      $('#subject_Id').html('<option value="" selected disabled>Select subject</option>');
      $('#user_Id').html('<option value="" selected disabled>Select instructor</option>');
      $('#sec_department').val(''); // Clear the department input field
      
      $.ajax({
        type: 'post',
        url: 'ajax.php',
        data: { section_Id: section_Id },
        success: function(data) {
          $('#subject_Id').append(data);
          
          // Get the department value from the response and update the input field
          var department = $(data).filter('#sec_department').val();
          $('#sec_department').val(department);
        }
      });
    }




   

    // GET INSTRUCTOR BY SUBJECT
    function getinstructor_by_Subject(subject_Id){
        $('#user_Id').html('');
        
        // Get the value of the input element
        var evaluatedBy = $('#evaluated_by').val();
        
        $.ajax({
            type:'post',
            url: 'ajax.php',
            data : { subject_Id : subject_Id, evaluated_by: evaluatedBy }, // Include evaluated_by in the data object
            success : function(data){
                $('#user_Id').html(data);
            }
        });
    }

    


</script>