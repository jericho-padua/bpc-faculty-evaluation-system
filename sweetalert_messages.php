<script src="sweetalert2.min.js"></script>

<!-- SUCCESS -->
<?php if(isset($_SESSION['message']) && isset($_SESSION['text']) && isset($_SESSION['status'])) { ?>

    <script>
      swal ({
        title: "<?php echo $_SESSION['message']; ?>",
        text:  "<?php echo $_SESSION['text']; ?>",
        icon:  "<?php echo $_SESSION['status']; ?>",
        confirmButtonColor: '#3085d6',
        confirmButtonText: "Okay",
        timer: 5000
      });

    </script>

<?php unset($_SESSION['message']); unset($_SESSION['text']); unset($_SESSION['status']); } ?>
