<?php
include('connect.php');

if (isset($_POST['rollnumber']) && isset($_POST['activity']) && isset($_POST['Name']) && isset($_POST['category']) && isset($_POST['Marks'])) {
  $rollnumber = $_POST['rollnumber'];
  $activity = $_POST['activity'];
  $name = $_POST['Name'];
  $category = $_POST['category'];
  $marks = $_POST['Marks'];

  // Prepare the UPDATE statement
  $query = "UPDATE add_marks SET Name='$name', Category='$category', Activity='$activity', Marks='$marks' WHERE Roll_Number='$rollnumber'";
  $result = mysqli_query($con, $query);

  if ($result) {
    echo 'Data updated successfully';
  } else {
    echo 'Data not updated successfully';
  }
} else {
  echo 'Invalid data';
}
?>
