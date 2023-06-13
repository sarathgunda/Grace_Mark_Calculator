<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel = "icon" href="images/logo.png" type = "image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="loginafter.css" />
    <title>Grace Mark</title>
  </head>
  <body>
    
    <nav>
        <a href="loginafter.php"><img src="images/gmclogo.png" alt="" width="300px"></a>
        
      <ul>
            <li class="user" style='left:69em'><span style="color:white">Welcome,<?php echo $_SESSION['name'] ?></span></li>
        <li>
          <img src="images/user (1).png" class="profile" />
          <ul>
            <li class="sub-item">
              <span class="material-icons-outlined"> grid_view </span>
              <p><a href="loginafter.php" style="color:black">Dashboard</a></p>
            </li>
            <li class="sub-item">
              <span class="material-icons-outlined"> logout </span>
              <p><a href="login.php" style="color:black">Logout</a></p>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <ul class="menu">
        <li class="menu-link"><a href="home.html" class="text-item">UPDATE</a></li>
        <li class="menu-link sub">
          <a href="viewdata\index.php" class="text-item">VIEW</a>
        </li>
  
        <!-- same dropdown elements for services section -->
  
        <li class="menu-link sub">
          <a href="#" class="text-item">REPORT</a>
        </li>
  
        <li class="menu-link"><a href="allocation.html" class="text-item">MARKS ALLOCATION</a></li>
  
      </ul>
      <div class="footer">
        <!--<p>ॐ Amriteshwaryai Namah</p>-->
        <ul id="socials">
            <li><a class="facebook" href="https://www.facebook.com/AmritaUniversity/"><i class="fa fa-facebook"></i></a></li>
            <li><a class="twitter" href="https://twitter.com/AMRITAedu?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor"><i class="fa fa-twitter"></i></a></li>
            <li><a class="google"href="https://www.amrita.edu/"><i class="fa fa-google-plus"></i></a></li>
            <li><a class="youtube"href="https://www.youtube.com/channel/UCVEeVDos5a4S9sMPK4jPUzA"><i class="fa fa-youtube"></i></a></li>
            <li><a class="instagram"href="https://www.instagram.com/amrita_university/?hl=en&__coig_restricted=1"><i class="fa fa-instagram"></i></a></li>
        </ul> 
    </div>
  </body>
</html>