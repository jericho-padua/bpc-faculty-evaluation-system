<title>BPC Faculty Evaluation System | Forgot password</title>
<?php include 'navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row d-flex justify-content-center">


          <div class="col-lg-4 mt-5">
            <div class="card card-outline card-primary mt-5">
              <div class="card-header text-center">
                <a href="#" class="h1"><b>Find your account</b></a>
              </div>
              <div class="card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                <form action="processes.php" method="post">
                  <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email" name="email"  id="email" onkeydown="validation()" onkeyup="validation()" required>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <!-- FOR INVALID EMAIL -->
                  <div class="input-group mt-1 mb-3">
                    <small id="text" style="font-style: italic;"></small>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <button type="submit" class="btn bg-gradient-primary btn-block"  name="search" id="search">Search</button>
                    </div>
                  </div>
                </form>
                <p class="mt-3 mb-1">
                  <a href="login.php">Login</a>
                </p>
              </div>
            </div>
          </div>

          
        </div>
      </div>
    </div>
  </div>
 

<?php include 'footer.php'; ?>

<script>
   function validation() {
    var email = document.getElementById("email").value;
    var pattern =/.+@(gmail)\.com$/;
    // var pattern =/.+@(gmail|yahoo)\.com$/;

    if(email.match(pattern)) {
        document.getElementById('text').style.color = 'green';
        document.getElementById('text').innerHTML = '';
        document.getElementById('search').disabled = false;
        document.getElementById('search').style.opacity = (1);
    } 
    else {
        document.getElementById('text').style.color = 'red';
        document.getElementById('text').innerHTML = 'Domain must be @gmail.com';
        document.getElementById('search').disabled = true;
        document.getElementById('search').style.opacity = (0.4);
        
    }
  }
</script>