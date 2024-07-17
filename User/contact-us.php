<title>BPC Faculty Evaluation System | Contact us</title>
<?php include 'navbar.php'; ?>

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Contact us</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="profile.php">Home</a></li>
              <li class="breadcrumb-item active">Contact us</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-body row">
          <div class="col-5 text-center d-flex align-items-center justify-content-center">
            <div class="">
              <h2>Barangay Monitoring <strong>System</strong></h2>
              <p class="lead mb-5">Pasig City - Barangay 193<br>
                Phone: +1 234 56789012
              </p>
            </div>
          </div>
          <div class="col-7">
            <form action="process_save.php" method="POST">
              <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" id="inputName" class="form-control" name="name" />
              </div>
              <div class="form-group">
                <label for="inputEmail">E-Mail</label>
                <input type="email" id="inputEmail" class="form-control" name="email" />
              </div>
              <div class="form-group">
                <label for="inputSubject">Subject</label>
                <input type="text" id="inputSubject" class="form-control" name="subject" />
              </div>
              <div class="form-group">
                <label for="inputMessage">Message</label>
                <textarea id="inputMessage" class="form-control" rows="4" name="message"></textarea>
              </div>
              <?php if(isset($_SESSION['success'])) { ?> 
                <h6 class="alert bg-orange" role="alert"><span class="text-white"><?php echo $_SESSION['success']; ?></span></h6> 
              <?php unset($_SESSION['success']); } ?>
              <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Send message" name="sendEmail">
              </div>
            </form>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php include 'footer.php'; ?>

<script>
  $(document).ready(function() {
        setTimeout(function() {
            $('.alert').hide();
        } ,4000);
  });
</script>