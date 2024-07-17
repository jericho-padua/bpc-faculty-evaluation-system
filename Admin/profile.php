<title>BPC Faculty Evaluation System | Admin profile</title>
<?php include 'navbar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h1>Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active"><?php if ($u_type = 'Admin') {
              echo 'Admin';
            } else {
              echo 'Dean';
            } ?>
              Profile</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <?php if ($row['image'] == ""): ?>
                  <img src="../dist/img/avatar.png" alt="User Avatar" class="img-size-50 img-circle">
                <?php else: ?>
                  <img class="profile-user-img img-fluid img-circle" src="../images-users/<?php echo $row['image']; ?>"
                    alt="User profile picture" style="height: 90px; width: 90px; border-radius: 50%;">
                <?php endif; ?>

              </div>
              <h3 class="profile-username text-center"><?php echo ' ' . $row['firstname'] . ' ' . $row['lastname'] . ' '; ?>
              </h3>
              <p class="text-muted text-center"><?php echo $row['user_type']; ?></p>
              <a class="btn bg-gradient-primary btn-block">Profile</a>
            </div>
          </div>

        </div>


        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#viewprofile" data-toggle="tab">Profile info</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#updateprofile" data-toggle="tab">Update info</a></li>
                <li class="nav-item"><a class="nav-link" href="#accountsecurity" data-toggle="tab">Account security</a>
                </li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">

                <div class="active tab-pane" id="viewprofile">
                  <div class="form-group row">
                    <label for="First name" class="col-sm-2 col-form-label">Full name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="First name" placeholder="First name"
                        value="<?php echo ' ' . $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'] . ' ' . $row['suffix'] . ' '; ?>"
                        readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="First name" class="col-sm-2 col-form-label">Date of birth</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="First name" placeholder="First name"
                        value="<?php echo date("F d, Y", strtotime($row['dob']));
                        echo ' - ';
                        echo $row['age'] ?>"
                        readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="First name" class="col-sm-2 col-form-label">Gender</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="First name" placeholder="Gender"
                        value="<?php echo $row['gender']; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="Email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="Email" placeholder="Email"
                        value="<?php echo $row['email']; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <a type="button" class="btn bg-gradient-primary" href="#updateprofile" data-toggle="tab">Update
                        info</a>
                    </div>
                  </div>
                </div>


                <div class="tab-pane" id="updateprofile">
                  <form action="process_update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" value="<?php echo $row['user_Id']; ?>" name="user_Id">
                    <div class="form-group row">
                      <a class="col-sm-12 text-primary text-bold">Basic information</a>
                    </div>
                    <div class="form-group row">
                      <label for="First name" class="col-sm-2 col-form-label">First name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="First name" placeholder="First name"
                          value="<?php echo $row['firstname']; ?>" onkeyup="lettersOnly(this)" name="firstname"
                          required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="Middle name" class="col-sm-2 col-form-label">Middle name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="Middle name" placeholder="Middle name"
                          value="<?php echo $row['middlename']; ?>" onkeyup="lettersOnly(this)" name="middlename">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="Last name" class="col-sm-2 col-form-label">Last name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="Last name" placeholder="Last name"
                          value="<?php echo $row['lastname']; ?>" onkeyup="lettersOnly(this)" name="lastname" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="Suffix" class="col-sm-2 col-form-label">Suffix</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="Suffix" placeholder="Suffix"
                          value="<?php echo $row['suffix']; ?>" name="suffix">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="txtbirthdate" class="col-sm-2 col-form-label">Date of Birth</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" name="dob" placeholder="Date of birth" required
                          id="birthdate" onchange="calculateAge()" value="<?php echo $row['dob']; ?>">
                      </div>
                    </div>
                    <!--  <div class="form-group row">
                        <label for="txtage" class="col-sm-2 col-form-label">Age</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control bg-white" placeholder="Age" required id="txtage" name="age" readonly value="<? php// echo $row['age']; ?>">
                        </div>
                      </div> -->
                    <div class="form-group row">
                      <label for="email" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required
                          onkeydown="validation()" onkeyup="validation()" value="<?php echo $row['email']; ?>">
                        <small id="text" style="font-style: italic;"></small>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="Contact number" class="col-sm-2 col-form-label">Sex</label>
                      <div class="col-sm-10">
                        <div class="input-group">
                          <select class="form-control" name="gender" required>
                            <option selected disabled value="">Select sex</option>
                            <option value="Male" <?php if ($row['gender'] == 'Male') {
                              echo 'selected';
                            } ?>>Male</option>
                            <option value="Female" <?php if ($row['gender'] == 'Female') {
                              echo 'selected';
                            } ?>>Female
                            </option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="Contact number" class="col-sm-2 col-form-label">Image</label>
                      <div class="col-sm-5">
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="fileToUpload"
                              onchange="newgetImagePreview(event)">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                          </div>
                        </div>
                        <p class="help-block text-danger font-italic">Note: .png or .jpg files only up to 500KB max size
                        </p>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group" id="user_preview"></div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn bg-gradient-primary" id="update_admin"
                          name="update_profile_info">Submit</button>
                      </div>
                    </div>
                  </form>

                </div>


                <div class="tab-pane" id="accountsecurity">
                  <form action="process_update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" value="<?php echo $row['user_Id']; ?>" name="user_Id">
                    <div class="form-group row">
                      <label for="Old password" class="col-sm-2 col-form-label">Old password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="Old password" placeholder="Old password"
                          name="OldPassword" required minlength="8">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="new_password" class="col-sm-2 col-form-label">New password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Password" name="password" required
                          id="password" minlength="8">
                        <span id="password-message" class="text-bold"
                          style="font-style: italic;font-size: 12px;color: #e60000;"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="cpassword" class="col-sm-2 col-form-label">Confirm password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Confirm password" name="cpassword"
                          required id="cpassword" onkeyup="validate_password_confirm_password()" minlength="8">
                        <small id="wrong_pass_alert" class="text-bold"
                          style="font-style: italic;font-size: 12px;"></small>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn bg-gradient-primary" name="update_password_admin"
                          id="update_password_admin">Submit</button>
                      </div>
                    </div>
                  </form>
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

<?php include 'footer.php'; ?>


<script>

  function newgetImagePreview(event) {
    var image = URL.createObjectURL(event.target.files[0]);
    var imagediv = document.getElementById('user_preview');
    var newimg = document.createElement('img');
    imagediv.innerHTML = '';
    newimg.src = image;
    newimg.width = "100";
    newimg.height = "100";
    newimg.style['border-radius'] = "50%";
    newimg.style['display'] = "block";
    newimg.style['margin-left'] = "auto";
    newimg.style['margin-right'] = "auto";
    newimg.style['box-shadow'] = "rgba(100, 100, 111, 0.2) 0px 7px 29px 0px";
    imagediv.appendChild(newimg);
  }

</script>