<?php
include 'connect.php';
session_start();

// Rest of your code
$codetemp = $_POST['verifycode'];
$mail = $_SESSION['mail'];

$sql = "SELECT * FROM faculty WHERE otp='$codetemp' AND email='$mail'";
$result = mysqli_query($con, $sql);
$num = mysqli_num_rows($result);

if ($num == 1) {
    $_SESSION['e_message'] = "OTP verified successfully";
    unset($_SESSION['e_otp']); // Remove the 'e_otp' session variable
    // echo '<script>alert("OTP verified successfully")</script>';
    echo '<script>window.location = "otpsucc.php"</script>';
    exit;
} else {
    $_SESSION['e_otp'] = "Invalid OTP";
    // echo '<script>alert("Invalid OTP")</script>';
    echo '<script>window.location = "otp.php"</script>';
    exit;
}
?>
