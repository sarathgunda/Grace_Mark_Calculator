<script src="script.js"></script>
<script src="signup.js"></script>
<script src="sweetalert.min.js"></script>

 <?php
if(isset($_SESSION['status']) && $_SESSION['status'] !='')
{
 ?>
<script>
swal ({
title: "<?php echo $_SESSION['status']; ?>",
icon: "<?php echo $_SESSION['status_code']; ?>",
button: "Ok!",
});
</script>
<?php
unset($_SESSION['status']);
}
?> 