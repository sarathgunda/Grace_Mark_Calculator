<?php
include('connect.php');
if (isset($_POST['rollnumber']) && isset($_POST['activity'])) {
  $rollnumber = $_POST['rollnumber'];
  $activity = $_POST['activity'];

  // Prepare the DELETE statement
  $query = "DELETE FROM add_marks WHERE Roll_Number = '$rollnumber' AND Activity = '$activity'";
  $result = mysqli_query($con, $query);
if($result){
    echo'Data deleted succesffuly';

}
else{
    echo'Data not added succesffuly';
}
}
else{
    echo 'No data';
}
?>
