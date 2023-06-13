<?php
    include 'connect.php';
    session_start();
    $_SESSION['flag']="false";
            @$id = $_POST['facid'];
		    @$pass = $_POST['facpass'];
            $sql="select * from faculty where facultyid='$id' AND password='$pass'";
            $result=mysqli_query($con,$sql);
            $num=mysqli_num_rows($result);
            if($num==1)
		    { 
                
               
                $data = $result->fetch_assoc();
                if($data['section']!=NULL){
                  $_SESSION['sec']=$data['section'];
                  $_SESSION['name']=$data['name'];
                  $_SESSION['id']=$data['facultyid'];
                  echo "  <script>
                  window.location = 'advisorlogin.php'
                    </script> ";
                }
                else{
                  $_SESSION['name']=$data['name'];
                  $_SESSION['id']=$data['facultyid'];
                  // echo '<script>alert("Login Successful")</script>';
                  echo "  <script>
                  window.location = 'loginafter.php'
                    </script> ";
                }
              
		     }
             else{
                // echo '<script>alert("Invalid Credentials")</script>';
                $_SESSION['status']="Invalid Credentials";
            $_SESSION['status_code']="error";
                echo "  <script>
                window.location = 'login.php'
                  </script> ";
             }
?>