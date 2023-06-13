<?php
session_start();
if (!isset($_SESSION['e_message'])) {
    header('location:login.html');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP VERIFICATION</title>
    <link rel="icon" href="images/logo.png" type="image/x-icon">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" type="text/css" href="1.css">
    
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
        <div class="wrapperotp" style="height: 500px">
            <div class="form-wrapper">
                <form id="passwordForm" method="post" action="passchange.php">
                <p id="passwordError" style="color:yellow;"></p>
                    <h2>Enter New Password</h2>
                    <div class="input-group">
                        <input type="password" name="newpass" required>
                        <label>Password</label>
                    </div>
                    <div class="input-group">
                        <input type="password" name="confirm_password" required>
                        <label>Confirm Password</label>
                    </div>
                    <button type="submit">Recover</button>
                    <div class="errorotpsucc">
                        <p class="errorotpsuccmsg"><?php echo $_SESSION['e_message'] ?></p>
                    </div>
                </form>
            </div>
        </div>
    <style>
        .errorotpsucc{
            display:flex;
            position: relative;
            width: 250px;
            height: 50px;
            background: #4CBB17;
            border: 1px solid rgba(255,255,255,.5);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px rgba(0,0,0,.5);
            justify-content: center;
            top: 20px;
            left: 13%;
    
}
.errorotpsuccmsg{
position: relative;
top: 20%;
color: black;
}
    </style>
    <script src="otsucc.js"></script>
</body>
</html>
