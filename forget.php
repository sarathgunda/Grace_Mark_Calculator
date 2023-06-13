<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer\src\Exception.php';
require 'phpmailer\src\PHPMailer.php';
require 'phpmailer\src\SMTP.php';


    include 'connect.php';
    session_start();
    $_SESSION['flag']="false";
    $_SESSION['e_message']="";
            @$eml = $_POST['useremail'];
            $sql="select * from faculty where email='$eml'";
            $result=mysqli_query($con,$sql);
            $num=mysqli_num_rows($result);
            if($num==1)
		    { 
                
                $_SESSION['mail']=$eml;
                $temp=rand(99999,11111);
                $sql1="update faculty set otp='$temp' where email='$eml'";
                $updateres=mysqli_query($con,$sql1);
                if($updateres){
                        $mail=new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host='smtp.gmail.com';
                        $mail->SMTPAuth=true;
                        $mail->Username='littu72002@gmail.com';
                        $mail->Password='fzzvfvoepglcakyp';
                        $mail->SMTPSecure='tls';
                        $mail->Port=587;
                        $mail->setFrom('littu72002@gmail.com');
                        $mail->addAddress($eml);
                        $mail->isHTML(true);
                        $mail->Subject = "Password Reset"; 
                        $mail->Body="Verification code: '$temp'";
                        $mail->send();
                        $_SESSION['e_message']="Verfication code has been sucessfully sent to your Email";
                        // echo
                        // "
                        // <script>
                        // alert('sent succsess');
                        // </script> 
                        // ";

                    
                }
                else{
                    echo '<script> alert("Failed while updating ")</script>';
                }
                echo "  <script>
                window.location = 'otp.php'
                  </script> ";
		     }
             else{

                
                $_SESSION['status']="Invalid Email";
                $_SESSION['status_code']="error";
                echo "  <script>
                window.location = 'login.php'
                  </script> ";
             }
?>