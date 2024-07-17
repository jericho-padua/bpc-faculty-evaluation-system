<!-- CHANGE PASSWORD -->
<div class="modal fade" id="password<?php echo $row['user_Id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
       <div class="modal-header bg-light">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-lock"></i> Change password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa-solid fa-circle-xmark"></i></span>
        </button>
      </div>
      <div class="modal-body">
        <form action="process_update.php" method="POST">
           <input type="hidden" class="form-control" value="<?php echo $row['user_Id']; ?>" name="user_Id">
            <div class="form-group mb-3">
              <label for=""><b>Old password</b></label>
              <input type="password" class="form-control" placeholder="Old password" name="OldPassword" required minlength="8">
            </div>
            <div class="form-group mb-3">
              <label for=""><b>New password</b></label>
              <input type="password" class="form-control" name="password" placeholder="Password" id="password" required minlength="8" onkeypress="validate_password()">
              <small id="passLength"></small>
            </div>
            <div class="form-group mb-3">
              <label for=""><b>Confirm password</b></label>
              <input type="password" class="form-control" name="cpassword" placeholder="Retype password" id="cpassword" onkeyup="validate_password_confirm_password()" required minlength="8">
              <small id="wrong_pass_alert"></small>
            </div>
      </div>
      <div class="modal-footer alert-light">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-ban"></i> Cancel</button>
        <button type="submit" class="btn bg-gradient-primary" name="password_admin" id="new_create"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
      </div>
        </form>
    </div>
  </div>
</div>

<script>
  function validate_password_confirm_password() {
      var pass = document.getElementById('password').value;
      var confirm_pass = document.getElementById('cpassword').value;
      if (pass != confirm_pass) {
        document.getElementById('wrong_pass_alert').style.color = 'red';
        document.getElementById('wrong_pass_alert').innerHTML = 'X Password did not matched!';
        document.getElementById('create_admin').disabled = true;
        document.getElementById('create_admin').style.opacity = (0.4);
      } else {
        document.getElementById('wrong_pass_alert').style.color = 'green';
        document.getElementById('wrong_pass_alert').innerHTML = '✓ Password matched!';
        document.getElementById('create_admin').disabled = false;
        document.getElementById('create_admin').style.opacity = (1);
      }
    }

    function validate_password() {
       var pass = document.getElementById('password').value;
       var confirm_pass = document.getElementById('cpassword').value;
       var regex = /[a-zA-Z0-9]/g;
       var pass2 = pass.match(regex).length;

      if(pass2 < 8) {
        document.getElementById('passLength').style.color = 'red';
        document.getElementById('passLength').innerHTML = 'Password must be at least 8 characters.';
        document.getElementById('create_admin').disabled = true;
        document.getElementById('create_admin').style.opacity = (0.4);

      } else {
        document.getElementById('passLength').style.color = 'green';
        document.getElementById('passLength').innerHTML = '';
        document.getElementById('create_admin').disabled = false;
        document.getElementById('create_admin').style.opacity = (1);
      }
    }
</script>





<!-- VIEW PROFILE PHOTO -->
<div class="modal fade" id="viewphoto<?php echo $row['user_Id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
       <div class="modal-header bg-light">
        <h5 class="modal-title" id="exampleModalLabel">Administrator's photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa-solid fa-circle-xmark"></i></span>
        </button>
      </div>
      <div class="modal-body d-flex justify-content-center">
          <img src="../images-users/<?php echo $row['image']; ?>" alt="" width="200" height="200" class="img-circle" style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
      </div>
      <div class="modal-footer alert-light d-flex justify-content-center">
        <a href="../images-users/<?php echo $row['image']; ?>" type="button" class="btn bg-gradient-primary" download><i class="fa-solid fa-download"></i> Download</a>
      </div>
    </div>
  </div>
</div>


<!-- DELETE -->
<div class="modal fade" id="delete<?php echo $row['user_Id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
       <div class="modal-header bg-light">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-user-large"></i> Delete administrator</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fa-solid fa-circle-xmark"></i></span>
        </button>
      </div>
      <div class="modal-body">
        <form action="process_delete.php" method="POST">
          <input type="hidden" class="form-control" value="<?php echo $row['user_Id']; ?>" name="user_Id">
          <h6 class="text-center">Delete administrator record?</h6>
      </div>
      <div class="modal-footer alert-light">
        <button type="button" class="btn bg-secondary" data-dismiss="modal"><i class="fa-solid fa-ban"></i> Cancel</button>
        <button type="submit" class="btn bg-danger" name="delete_admin"><i class="fas fa-trash"></i> Delete</button>
      </div>
        </form>
    </div>
  </div>






