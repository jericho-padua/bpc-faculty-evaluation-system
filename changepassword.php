<title>BPC Faculty Evaluation System | Change password</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row d-flex justify-content-center">
  <?php 
      if(isset($_GET['user_Id'])) {
      $user_Id = $_GET['user_Id'];
  ?>

          <div class="col-lg-4 mt-5">
            <div class="card card-outline card-primary mt-4">
              <div class="card-header text-center">
                <a href="#" class="h1"><b>Create new password</b></a>
              </div>
              <div class="card-body">
                <p class="login-box-msg">Please create new password.</p>
                <form action="processes.php" method="post">

                  <input type="hidden" class="form-control" name="user_Id" value="<?php echo $user_Id; ?>">

                  <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="New password" name="password" id="mynewpassword" minlength="8">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Confirm new password" name="cpassword" id="cpassword" onkeyup="validate_password()" minlength="8">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <small id="wrong_pass_alert"></small>

                  <div class="icheck-primary mt-3">
                    <input type="checkbox" id="remember" onclick="myFunction()">
                    <label for="remember">
                      Show password
                    </label>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button class="btn btn-block bg-gradient-primary" type="submit" name="changepassword" id="changepassword">Change password</button>
                    </div>
                  </div>
                </form>

                <p class="mt-3 mb-1">
                  <a href="login.php">Login</a>
                </p>
              </div>
            </div>
          </div>

  <?php } else { include '404.php'; } ?>

        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include 'footer.php'; ?>

<script>
  // SHOW/HIDE PASSWORDS
  function myFunction() {
    var x = document.getElementById("mynewpassword");
    var y = document.getElementById("cpassword");
    if (x.type === "password" || y.type === "password") {
      x.type = "text";
      y.type = "text";
    } else {
      x.type = "password";
      y.type = "password";
    }
 }

// VALIDATE - MATCHED OR NOT MATCHED PASSWORDS
function validate_password() {
    var pass = document.getElementById('mynewpassword').value;
    var confirm_pass = document.getElementById('cpassword').value;
    if(pass == "") {
      confirm_pass.disabled = true;
    } else if (pass != confirm_pass) {
      document.getElementById('wrong_pass_alert').style.color = 'red';
      document.getElementById('wrong_pass_alert').innerHTML = 'X Password did not matched!';
      document.getElementById('changepassword').disabled = true;
      document.getElementById('changepassword').style.opacity = (0.4);
    } else {
      document.getElementById('wrong_pass_alert').style.color = 'green';
      document.getElementById('wrong_pass_alert').style.display = 'none';
      document.getElementById('changepassword').disabled = false;
      document.getElementById('changepassword').style.opacity = (1);
    }
}
</script>
