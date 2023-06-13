<?php

include 'connect.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $facid=$_POST['fid'];
    $facname=$_POST['fname'];
    $facemail=$_POST['fmail'];
    $fapass=$_POST['fpass'];
    $temp=0;
    $sql="select * from faculty where email='$facemail' ";
    $sql2="select * from faculty where facultyid='$facid'";
    $num1=mysqli_num_rows(mysqli_query($con,$sql));
    $num2=mysqli_num_rows(mysqli_query($con,$sql2));
    if($num2==1 && $num1==1){
        $_SESSION['status']="Account already exists with Faculty Id and Email";
        $_SESSION['status_code']="error";
        // echo '<script>alert("Account not 2  created")</script>' ;
        echo "  <script>
        window.location = 'login.php'
          </script> "; 
    }
    else if($num1==1){
        $_SESSION['status']="Account already exists with Email Id";
        $_SESSION['status_code']="error";
        // echo '<script>alert("Account not  created")</script>' ;
        echo "  <script>
        window.location = 'login.php'
          </script> ";

    }
    else if($num2==1){
        $_SESSION['status']="Account already exists with Faculty Id";
        $_SESSION['status_code']="error";
        // echo '<script>alert("Account not  created")</script>' ;
        echo "  <script>
        window.location = 'login.php'
          </script> "; 
    }
    
    else{
        $query = "INSERT INTO faculty (facultyid,name,email,password,otp) VALUES ('$facid', '$facname','$facemail','$fapass','$temp')";
        $result = mysqli_query($con, $query);
        if( $result){
            $_SESSION['status']="Account Created Successfully";
            $_SESSION['status_code']="success";
            // echo '<script>alert("Account created")</script>' ;
            header('location:login.php');

        }
        else{
            echo '<script>alert("DB ERROR")</script>' ;
        }

    }
}
else{
    echo '<script>alert("Form not submitted")</script>' ;
}
?>