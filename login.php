<title>BPC Faculty Evaluation System | Login</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-dark">
<style>
  .content-wrapper.bg-dark {
  background-image: url('images/bpc.jpg');
  background-size: cover;
</style>    
    <!-- Main content -->
    <br><br><br><br><br>
    <div class="content">
      <div class="container">
        <div class="row d-flex justify-content-center">

         
              <div class="col-lg-4 col-md-12 col-sm-12 col-12 bg-light card bg-white m-5">
                  <div class="card-header text-center justify-content-center d-flex ">
                    <div class="col-6 p-2">
                      <!-- <a href="login.php" class="h1"><b>Login</b></a> -->
                      <a href="login.php" class="h4">
                        <img src="images/bpc.ico" alt="logo" class="img-fluid shadow-sm img-circle">
                      </a>
                    </div>
                  </div>
                <div class="card-body  bg-white">
                  <b><p style="font-family: Verdana, sans-serif; font-size: 25px;"class="login-box-msg">LOGIN</p></b>
                  <form action="processes.php" method="post" id="quickForm">

                    

                    <div class="input-group">
                      <input type="email" class="form-control" placeholder="Email" name="email" id="email"  onkeydown="validation()" onkeyup="validation()" >
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>
                    </div>
                    <!-- FOR INVALID EMAIL -->
                    <div class="input-group mt-1 mb-2">
                      <small id="text" style="font-style: italic;"></small>
                    </div>
                    <div class="input-group mb-3">
                      <input type="password" class="form-control" placeholder="Password" id="password" name="password" minlength="8" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-8">
                        <div class="icheck-primary">
                          <input type="checkbox" id="remember" id="remember" onclick="myFunction()">
                          <label for="remember">
                            Show password
                          </label>
                        </div>
                      </div>
                      <div class="col-12">
                        <button type="submit" class="btn bg-gradient-success btn-block" name="login" id="login">Login</button>
                      </div>
                    </div>
                  </form>
                  <p>
                    <a href="forgot-password.php">Forgot password?</a>
                    <br>
                    No account? <a href="register.php" class="text-center">Register here!</a>
                  </p>
                </div>
              </div>
            <!-- </div>
              
          </div> -->

        </div>
      </div>
    </div>
  </div>

<?php include 'footer.php'; ?>
