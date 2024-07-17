<title>BPC Faculty Evaluation System | Verify code</title>

<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content">
      <div class="container">
        <div class="row d-flex justify-content-center">
<?php 
    if(isset($_GET['user_Id']) && isset($_GET['email'])) {

    $user_Id = $_GET['user_Id'];
    $email   = $_GET['email'];
?>
    
        <div class="col-lg-4 mt-5">
          <div class="card card-outline card-primary mt-5">
            <div class="card-header text-center">
              <a href="#" class="h1"><b>Enter security code</b></a>
            </div>
            <div class="card-body">
              <p class="login-box-msg">Please check your email for a message with your code. Your code is 6 numbers long.</p>
              <form action="processes.php" method="post">

                <input type="hidden" class="form-control mb-3" value="<?php echo $user_Id; ?>" name="user_Id">
                <input type="hidden" class="form-control mb-3" value="<?php echo $email; ?>" name="email">

                <div class="input-group mb-3">   
                  <input type="number" class="form-control" placeholder="Enter verification code" name="code" minlength="6" maxlength="6" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group">
                  <p>We sent your code to: <b><?php echo $email; ?></b></p>
                </div> 
                <div class="row">
                  <div class="col-12">
                    <button type="submit" class="btn bg-gradient-primary btn-block"  name="verify_code">Continue</button>
                    <a href="sendcode.php?user_Id=<?php echo $user_Id; ?>" class="mt-1">Didn't get a code?</a>
                  </div>
                </div>
              </form>
              <p class="mt-3 mb-1">
                <a href="index.php">Login</a>
              </p>
            </div>
          </div>
        </div>

<?php } else { include '404.php'; } ?>

        </div>
      </div>
    </div>
  </div>
 

<?php include 'footer.php'; ?>

