<?php
session_start();

if (!isset($_SESSION['e_otp'])) {
    $_SESSION['e_otp'] = '';
}

$eOTP = $_SESSION['e_otp']; // Store e_otp value in a variable

// Clear e_otp after storing it in a variable
$_SESSION['e_otp'] = '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enter OTP</title>
  <link rel="stylesheet" href="1.css">
  <link rel="icon" href="images/logo.png" type="image/x-icon">
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <style>
    .error-container {
                    display: <?php echo ($eOTP !== '') ? 'flex' : 'none'; ?>;
                    position: relative;
                    width: 250px;
                    height: 50px;
                    background: #E62020;
                    border: 1px solid rgba(255,255,255,.5);
                    backdrop-filter: blur(20px);
                    box-shadow: 0 0 30px rgba(0,0,0,.5);
                    justify-content: center;
                    top: 20px;
                    left: 13%;
                    
    }
    
    .error-message{
            position: relative;
                    top: 20%;
                    color: black;
      
      
    }
  </style>
</head>

<body>
  <section class="main">
    <header>
      <img src="images/logor.png" height="150px" width="500px">
    </header>
    <video src="images/final.mp4" muted loop autoplay></video>
    <div class="text">
      <h1>GRACE MARK</h1><br>
      <h3>CALCULATOR</h3>
      <p>Amrita Grace Mark Calculator is a tool designed to assist educators in calculating the final grades of their students. The calculator typically has several operations, including adding and updating student scores, as well as the ability to calculate grades based on predetermined grading criteria
      </p>
    </div>
    <div class="wrapperotp" style="width:400px">
      <div class="frgt">
        <form action="otpcheck.php" method="post">
          <p style="color: yellow;"><?php echo $_SESSION['e_message']; ?></p>
          <h2>Enter OTP</h2>
          <div class="input-group">
            <input type="number" required name="verifycode">
            <label for="">Otp</label>
          </div>
          <button type="submit">Verify</button>
          <div class="error-container">
            <p class="error-message"><?php echo $eOTP; ?></p>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>

</html>
