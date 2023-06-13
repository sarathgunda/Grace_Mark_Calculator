<?php
include "config.php";
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST["roll_number"];
  // $msg = addGraceMarks($conn, $id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>ADD GRACE</title>
</head>

<body>
<nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: black;color:white">
    STUDENTS FAILED IN SEC-<?php echo $_SESSION['sec']; ?>
</nav>

<div class="container">

  <table class="table table-hover text-center">
    <thead class="table-dark">
      <tr>
        <th scope="col">ROLL NUMBER</th>
        <th scope="col">NAME</th>
        <th scope="col">SECTION</th>
        <th scope="col">DSA</th>
        <th scope="col">POPL</th>
        <th scope="col">OS</th>
        <th scope="col">ML</th>
        <th scope="col">FODS</th>
        <th scope="col">SE</th>
        <th scope="col">Failed Subjects</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM marks WHERE section='{$_SESSION['sec']}'";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        // Check if the student has failed in any subject
        $failedSubjects = array();
        if ($row["dsa"] < 35) {
          $failedSubjects[] = "DSA";
        }
        if ($row["popl"] < 35) {
          $failedSubjects[] = "POPL";
        }
        if ($row["os"] < 35) {
          $failedSubjects[] = "OS";
        }
        if ($row["ml"] < 35) {
          $failedSubjects[] = "ML";
        }
        if ($row["fods"] < 35) {
          $failedSubjects[] = "FODS";
        }
        if ($row["se"] < 35) {
          $failedSubjects[] = "SE";
        }
     
      if (!empty($failedSubjects)) {
        ?>
      
        <tr>
          <td><?php echo $row["roll_number"] ?></td>
          <td><?php echo $row["name"] ?></td>
          <td><?php echo $row["section"] ?></td>
          <td><?php echo $row["dsa"] ?></td>
          <td><?php echo $row["popl"] ?></td>
          <td><?php echo $row["os"] ?></td>
          <td><?php echo $row["ml"] ?></td>
          <td><?php echo $row["fods"] ?></td>
          <td><?php echo $row["se"] ?></td>
          <td><?php echo implode(", ", $failedSubjects) ?></td>
          <td>
          </td>
        </tr>
      <?php
      }
      } // Closing brace for the while loop
      ?>
    </tbody>
  </table>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
