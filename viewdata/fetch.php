<?php
include('database_connection.php');



$column = array('student_rollnumber', 'student_name', 'category', 'activity', 'marks');

$query = "SELECT * FROM student WHERE 1=1";

if (isset($_POST['filter_category']) && $_POST['filter_category'] != '') {
  $query .= " AND category = '" . $_POST['filter_category'] . "'";
}

if (isset($_POST['filter_country']) && $_POST['filter_country'] != '') {
  $query .= " AND activity = '" . $_POST['filter_country'] . "'";
}

if (isset($_POST['search']) && $_POST['search']['value'] != '') {
  $search_value = $_POST['search']['value'];
  $query .= " AND (student_rollnumber LIKE '%" . $search_value . "%'
                OR student_name LIKE '%" . $search_value . "%'  
                 OR category LIKE '%" . $search_value . "%' 
                
                 OR activity LIKE '%" . $search_value . "%' 
                 OR marks LIKE '%" . $search_value . "%')";
}

$limit = '';

if ($_POST["length"] != -1) {
  $limit = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$query .= ' ' . $limit;

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$result = $statement->fetchAll();


$data = array();

foreach ($result as $row) {
  $sub_array = array();
  $sub_array[] = $row['student_rollnumber'];
  $sub_array[] = $row['student_name'];

  $sub_array[] = $row['category'];
  $sub_array[] = $row['activity'];
  $sub_array[] = $row['marks'];
  $data[] = $sub_array;
}

function count_all_data($connect)
{
  $query = "SELECT * FROM student";
  $statement = $connect->prepare($query);
  $statement->execute();
  return $statement->rowCount();
}

$output = array(
  "draw" => intval($_POST["draw"]),
  "recordsTotal" => count_all_data($connect),
  "recordsFiltered" => $number_filter_row,
  "data" => $data
);

echo json_encode($output);
?>
