<title>BPC Faculty Evaluation System | Register</title>
<?php include 'navbar.php';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row d-flex justify-content-center">

          <div class="col-lg-10 mt-5">
            <form action="processes.php" method="POST" enctype="multipart/form-data">
            <div class="card card-outline card-primary">
              <div class="card-header text-center">
                <a href="#" class="h1"><b>Student Registration</b></a>
                <br>
               
              </div>

                <div class="card-body">
                    <div class="container text-justify">
                      <div class="container mt-5">
                        <h1 class="card-title">Bulacan Polytechnic College Data Privacy Act</h1>
                        <p class="card-text">The Bulacan Polytechnic College Faculty Evaluation System prioritizes data privacy. It follows principles of lawfulness, fairness, and transparency in all data processing. Personal information is collected for specific purposes, minimizing unnecessary data.</p>
                        <p class="card-text">For privacy inquiries, contact the Data Protection Officer at [contact email/phone number].</p>
                      </div>

                    </div>
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
                            <input type="text" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control"  maxlength="8"placeholder="(20011120)" name="student_ID" required>
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
                            <span class="text-dark"><b>Course</b></span>
                            <select class="form-control" name="department" id="department" required>
                              <option selected disabled value="">Select Course</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-4 col col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>First name</b></span>
                              <input type="text" class="form-control"  placeholder="Juan" name="firstname" maxlength="20" onkeyup="lettersOnly(this)" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                              <span class="text-dark"><b>Middle name</b></span>
                              <input type="text" class="form-control"  placeholder="Martinez" maxlength="20" name="middlename" onkeyup="lettersOnly(this)" required>
                          </div>
                        </div>
                        <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Last name</b></span>
                              <input type="text" class="form-control"  placeholder="Dela Cruz" maxlength="20" name="lastname" required onkeyup="lettersOnly(this)" required>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Ext/Suffix</b></span>
                            <input type="text" class="form-control" maxlength="10" placeholder="Ext/Suffix" name="suffix">
                          </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Date of Birth</b></span>
                              <input type="date" class="form-control" name="dob" placeholder="Date of birth" required id="birthdate" onchange="calculateAge()" required>
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
                              <input type="email" class="form-control" maxlength="30" placeholder="jdelacruz@gmail.com" name="email" id="email"  onkeydown="validation()" onkeyup="validation()" required>
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
                                <!-- <div class="input-group-append">
                                  <span class="input-group-text">Upload</span>
                                </div> -->

                              </div>
                              <p class="help-block text-danger font-italic">Note: .png or .jpg files only up to 500KB max size</p>
                            </div>
                        </div>
                         <!-- LOAD IMAGE PREVIEW -->
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="form-group" id="preview">
                            </div>
                        </div>
                        <div class="col-12">
                          <hr>
                          <p>Already have an account? <a href="login.php">Click here!</a></p>
                        </div>

                    </div>
                    <!-- END ROW -->
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <button type="submit" class="btn bg-primary" name="create_user" id="create_admin"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                  </div>
                </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    <!-- /.content -->
    </div>
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
<?php include 'footer.php'; ?>
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
          url: 'processes.php', // Create this PHP file to handle the request
          data: { section_id: sectionId },
          success: function (response) {
            // Update the "Department name" dropdown with the received data
            $('#department').html(response);
          }
        });
      } else {
        // Clear the "Department name" dropdown if no section is selected
        $('#department').html('<option selected disabled value="">Select course</option>');
      }
    });
  });

    // SHOW/HIDE PASSWORD - REGISTRATION/SAVING/UPDATING RECORDS
    function togglePasswordVisibility(inputId) {
        var passwordInput = document.getElementById(inputId);
        var eyeToggle = document.getElementById("eye-toggle-" + inputId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeToggle.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
        } else {
            passwordInput.type = "password";
            eyeToggle.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
        }
    }
</script>