<title>BPC Faculty Evaluation System | Student info</title>
<?php 
    include 'navbar.php'; 
    if(isset($_GET['page'])) {
      $page = $_GET['page'];
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">



<?php if($page === 'create') { ?>

    <!-- CREATION -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>New Student</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Student info</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <form action="process_save.php" method="POST" enctype="multipart/form-data">
              <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mt-1 mb-2">
                          <a class="h5 text-primary"><b>Basic information</b></a>
                          <div class="dropdown-divider"></div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <span class="text-dark"><b>Student type</b></span>
                            <select class="form-control" name="stud_type" id="stud_type" required>
                              <option selected disabled value="">Select type</option>
                              <option value="Regular">Regular student</option>
                              <option value="Irregular">Irregular student</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Student ID</b></span>
                            <input type="text" class="form-control"  placeholder="Student ID" name="student_ID" required>
                          </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Year and Section</b></span>
                            <select class="form-control" name="year_section" id="year_section" required>
                              <option selected disabled value="">Select section</option>
                              <?php 
                                $fetch = mysqli_query($conn, "SELECT * FROM section");
                                if(mysqli_num_rows($fetch) > 0) {
                                  while ($row = mysqli_fetch_array($fetch)) {
                                    ?>
                                    <option value="<?php echo $row['section_Id']; ?>"><?php echo $row['yr_level'].' - '.$row['section']; ?></option>
                                    <?php
                                  }
                                } else { ?>
                                  <option value="">No record found</option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>COURSE</b></span>
                            <select class="form-control" name="department" id="department" required>
                              <option selected disabled value="">Select Course</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-4 col col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>First name</b></span>
                              <input type="text" class="form-control"  placeholder="First name" name="firstname" required onkeyup="lettersOnly(this)">
                            </div>
                        </div>
                        <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                              <span class="text-dark"><b>Middle name</b></span>
                              <input type="text" class="form-control"  placeholder="Middle name" name="middlename" onkeyup="lettersOnly(this)">
                          </div>
                        </div>
                        <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Last name</b></span>
                              <input type="text" class="form-control"  placeholder="Last name" name="lastname" required onkeyup="lettersOnly(this)">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Ext/Suffix</b></span>
                            <input type="text" class="form-control"  placeholder="Ext/Suffix" name="suffix">
                          </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Date of Birth</b></span>
                              <input type="date" class="form-control" name="dob" placeholder="Date of birth" required id="birthdate" onchange="calculateAge()">
                            </div>
                        </div>
                       <!--  <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Age</b></span>
                              <input type="text" class="form-control bg-white" placeholder="Age" required id="txtage" name="age" readonly>
                            </div>
                        </div> -->
                       
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Sex</b></span>
                            <select class="form-control" name="gender" required>
                              <option selected disabled value="">Select sex</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-lg-5 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Email</b></span>
                              <input type="email" class="form-control" placeholder="Email" name="email" id="email"  onkeydown="validation()" onkeyup="validation()" required>
                              <small id="text" style="font-style: italic;"></small>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3 mb-2 col-md-12 col-sm-12 col-12">
                          <a class="h5 text-primary"><b>Account password</b></a>
                          <div class="dropdown-divider"></div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <span class="text-dark"><b>Password</b></span>
                                <div class="input-group">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="Password" minlength="8">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="eye-toggle-password" onclick="togglePasswordVisibility('password')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                                <span id="password-message" class="text-bold" style="font-style: italic; font-size: 12px; color: #e60000;"></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <span class="text-dark"><b>Confirm password</b></span>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="cpassword" placeholder="Retype password" id="cpassword" onkeyup="validate_password_confirm_password()" required minlength="8">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="eye-toggle-cpassword" onclick="togglePasswordVisibility('cpassword')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                                <small id="wrong_pass_alert" class="text-bold" style="font-style: italic; font-size: 12px;"></small>
                            </div>
                        </div>


                        <div class="col-lg-12 mt-3 mb-2">
                          <a class="h5 text-primary"><b>Additional information</b></a>
                          <div class="dropdown-divider"></div>
                        </div>
                        
                        <div class="col-lg-8 col-md-8 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Upload photo (COR or ID)</b></span>
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" id="exampleInputFile" name="fileToUpload" onchange="getImagePreview(event)" required>
                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                              </div>
                              <p class="help-block text-danger font-italic">Note: .png or .jpg files only up to 500KB max size</p>
                            </div>
                        </div>
                         <!-- LOAD IMAGE PREVIEW -->
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="form-group" id="preview">
                            </div>
                        </div>
                    </div>
                    <!-- END ROW -->
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a href="users.php" class="btn bg-secondary"><i class="fa-solid fa-backward"></i> Back to list</a>
                    <button type="submit" class="btn bg-primary" name="create_user" id="create_admin"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  <!-- END CREATION -->









<?php } else { 
  $user_Id = $page;
  $fetch = mysqli_query($conn, "SELECT * FROM users WHERE user_Id='$user_Id'");
  $row = mysqli_fetch_array($fetch);
?>


  <!-- UPDATE -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3>Update Student</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Student info</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form action="process_update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" class="form-control" name="user_Id" required value="<?php echo $row['user_Id']; ?>">
            <div class="card">
              <div class="card-body">
                  <div class="row">
                      <div class="col-lg-12 mt-1 mb-2">
                        <a class="h5 text-primary"><b>Basic information</b></a>
                        <div class="dropdown-divider"></div>
                      </div>
                      <div class="col-lg-4">
                          <div class="form-group">
                            <span class="text-dark"><b>Student type</b></span>
                            <select class="form-control" name="stud_type" id="stud_type" required>
                              <option selected disabled value="">Select type</option>
                              <option value="Regular" <?php if($row['stud_type'] == 'Regular') { echo 'selected'; } ?>>Regular student</option>
                              <option value="Irregular" <?php if($row['stud_type'] == 'Irregular') { echo 'selected'; } ?>>Irregular student</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"></div>
                      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <span class="text-dark"><b>Student ID</b></span>
                          <input type="text" class="form-control"  placeholder="Student ID" name="student_ID" required value="<?php echo $row['student_ID']; ?>">
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <span class="text-dark"><b>Year and Section</b></span>
                          <select class="form-control" name="year_section" id="year_section" <?php if($row['stud_type'] == 'Regular') { echo 'required'; } else { echo 'disabled'; } ?>>
                            <option selected disabled value="">Select section</option>
                            <?php 
                              $sec = $row['year_section'];
                              $fetch2 = mysqli_query($conn, "SELECT * FROM section");
                              if(mysqli_num_rows($fetch2) > 0) {
                                while ($row2 = mysqli_fetch_array($fetch2)) {
                                  ?>
                                  <option value="<?php echo $row2['section_Id']; ?>" <?php if($row2['section_Id'] == $sec) { echo 'selected'; } ?>><?php echo $row2['yr_level'].' - '.$row2['section']; ?></option>
                                  <?php
                                }
                              } else { ?>
                                <option value="">No record found</option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <span class="text-dark"><b>Course</b></span>
                          <select class="form-control" name="department" id="department">
                            <option selected disabled value="">Select Course</option>
                            <option value="Bachelor of Science in Information Systems" <?php if($row['department'] == 'Bachelor of Science in Information Systems') { echo 'selected'; } ?>>Bachelor of Science in Information Systems</option>
                            <option value="Bachelor of Science in Accounting Information Systems" <?php if($row['department'] == 'Bachelor of Science in Accounting Information Systems') { echo 'selected'; } ?>>Bachelor of Science in Accounting Information Systems</option>
                            <option value="Bachelor of Science in Office Management" <?php if($row['department'] == 'Bachelor of Science in Office Management') { echo 'selected'; } ?>>Bachelor of Science in Office Management</option>
                            <option value="Bachelor of Technical-Vocational Teacher Education" <?php if($row['department'] == 'Bachelor of Technical-Vocational Teacher Education') { echo 'selected'; } ?>>Bachelor of Technical-Vocational Teacher Education</option>

                          </select>
                        </div>
                      </div>
                      <div class="col-lg-4 col col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>First name </b></span>
                            <input type="text" class="form-control"  placeholder="First name" name="firstname" required onkeyup="lettersOnly(this)" value="<?php echo $row['firstname']; ?>">
                          </div>
                      </div>
                      <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <span class="text-dark"><b>Middle name</b></span>
                            <input type="text" class="form-control"  placeholder="Middle name" name="middlename" onkeyup="lettersOnly(this)" value="<?php echo $row['middlename']; ?>">
                        </div>
                      </div>
                      <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Last name</b></span>
                            <input type="text" class="form-control"  placeholder="Last name" name="lastname" required onkeyup="lettersOnly(this)" value="<?php echo $row['lastname']; ?>">
                          </div>
                      </div>
                      <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <span class="text-dark"><b>Ext/Suffix</b></span>
                          <input type="text" class="form-control"  placeholder="Ext/Suffix" name="suffix" value="<?php echo $row['suffix']; ?>">
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Date of Birth</b></span>
                            <input type="date" class="form-control" name="dob" placeholder="Date of birth" required id="birthdate" onchange="calculateAge()" value="<?php echo $row['dob']; ?>">
                          </div>
                      </div>
                     <!--  <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Age</b></span>
                            <input type="text" class="form-control bg-white" placeholder="Select DOB first" required id="txtage" name="age" readonly value="<?php //echo $row['age']; ?>">
                          </div>
                      </div>
                      -->
                      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <span class="text-dark"><b>Sex</b></span>
                          <select class="form-control" name="gender" required>
                            <option selected disabled value="">Select sex</option>
                            <option value="Male"       <?php if($row['gender'] == 'Male') { echo 'selected'; } ?>>Male</option>
                            <option value="Female"     <?php if($row['gender'] == 'Female') { echo 'selected'; } ?>>Female</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-lg-5 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Email</b></span>
                            <input type="email" class="form-control" placeholder="Email" name="email" id="email"  onkeydown="validation()" onkeyup="validation()" required value="<?php echo $row['email']; ?>">
                            <small id="text" style="font-style: italic;"></small>
                          </div>
                      </div>

                      <div class="col-lg-12 mt-3 mb-2">
                        <a class="h5 text-primary"><b>Additional information</b></a>
                        <div class="dropdown-divider"></div>
                      </div>
                      
                      <div class="col-lg-8 col-md-8 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Upload photo (COR or ID)</b></span>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="fileToUpload" onchange="getImagePreview(event)" >
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                            </div>
                            <p class="help-block text-danger font-italic">Note: .png or .jpg files only up to 500KB max size</p>
                          </div>
                      </div>
                       <!-- LOAD IMAGE PREVIEW -->
                      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                          <div class="form-group" id="preview">
                          </div>
                      </div>
                  </div>
                  <!-- END ROW -->
              </div>
              <div class="card-footer">
                <div class="float-right">
                  <a href="users.php" class="btn bg-secondary"><i class="fa-solid fa-backward"></i> Back to list</a>
                  <button type="submit" class="btn bg-primary" name="update_user" id="create_admin"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- END UPDATE -->


<?php } ?>



</div>

<?php } else { include '404.php'; } ?>



<br>
<br>
<br>
<br>
<br>
<br>
<?php include 'footer.php';  ?>

<script>
  // Get references to the dropdowns
  var studentTypeDropdown = document.getElementById('stud_type');
  var yearSectionDropdown = document.getElementById('year_section');
  var departmentDropdown = document.getElementById('department');
  // Define the department options for Irregular students
  var irregularDepartmentOptions = `
    <option selected disabled value="">Select Course</option>
    <option value="Bachelor of Science in Information Systems">Bachelor of Science in Information Systems</option>
    <option value="Bachelor of Science in Accounting Information Systems">Bachelor of Science in Accounting Information Systems</option>
    <option value="Bachelor of Science in Office Management">Bachelor of Science in Office Management</option>
    <option value="Bachelor of Technical-Vocational Teacher Education">Bachelor of Technical-Vocational Teacher Education</option>
  `;

  // Store the original options for the Year and Section dropdown
  var originalYearSectionOptions = yearSectionDropdown.innerHTML;
  
  // Add an event listener to the Student Type dropdown
  studentTypeDropdown.addEventListener('change', function() {
    if (studentTypeDropdown.value === 'Irregular') {
      // If Irregular is selected, disable Year and Section dropdown
      yearSectionDropdown.disabled = true;
      yearSectionDropdown.removeAttribute('required');
      yearSectionDropdown.innerHTML = '<option selected disabled value="">Select section</option>';
      departmentDropdown.innerHTML = irregularDepartmentOptions;

    } else {
      // If Regular is selected, enable Year and Section dropdown and make it required
      yearSectionDropdown.disabled = false;
      yearSectionDropdown.setAttribute('required', 'required');
      departmentDropdown.innerHTML = '<option selected disabled value="">Select Course</option>';
      // Restore the original options for the Year and Section dropdown
      yearSectionDropdown.innerHTML = originalYearSectionOptions;
    }
  });


  $(document).ready(function () {
    // When the "Year and Section" dropdown changes
    $('#year_section').on('change', function () {
      // Get the selected section ID
      var sectionId = $(this).val();
      
      if (sectionId) {
        // Make an Ajax request to fetch the department for the selected section
        $.ajax({
          type: 'POST',
          url: '../processes.php', // Create this PHP file to handle the request
          data: { section_id: sectionId },
          success: function (response) {
            // Update the "Department name" dropdown with the received data
            $('#department').html(response);
          }
        });
      } else {
        // Clear the "Department name" dropdown if no section is selected
        $('#department').html('<option selected disabled value="">Select Course</option>');
      }
    });
  });

</script>