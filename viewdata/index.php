<?php
include('database_connection.php');

// Fetch country options from the database
$query = "SELECT DISTINCT activity FROM student";
$query2 = "SELECT DISTINCT category FROM student";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$statement2 = $connect->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();

// Generate HTML options for the country dropdown
$countryOptions = '';
foreach ($result as $row) {
  $countryOptions .= '<option value="' . $row['activity'] . '">' . $row['activity'] . '</option>';
}

$categoryOptions = '';
foreach ($result2 as $row) {
  $categoryOptions .= '<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>view</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<!-- <style>
  body{
    background-color:"#c05c8e";
  }
</style> -->
<body style="background-color: #DAF7A6">
<div class="container box">
  <h3 align="center">GRACE MARKS</h3>
  <br />
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <div class="form-group">
      <select name="filter_category" id="filter_category" class="form-control" required>
          <option value="">category</option>
          <?php echo $categoryOptions; ?>
        </select>
      </div>
      <div class="form-group">
        <select name="filter_country" id="filter_country" class="form-control" required>
          <option value="">activity</option>
          <?php echo $countryOptions; ?>
        </select>
      </div>
      <div class="form-group" align="center">
        <button type="button" name="filter" id="filter" class="btn btn-info">Filter</button>
        <button type="button" name="reset" id="reset" class="btn btn-default">Reset</button>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>
  <div class="table-responsive">
    <table id="customer_data" class="table table-bordered table-striped">
      <thead>
        <tr>
          
          <th width="20%">student_rollnumber</th>
          <th width="10%">student_name</th>
          <th width="15%">category</th>
          <th width="15%">activity</th>
          <th width="15%">marks</th>
        </tr>
      </thead>
    </table>
    <br />
    <br />
    <br />
  </div>
</div>

<script type="text/javascript" language="javascript">
  $(document).ready(function() {
    var dataTable = $('#customer_data').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        url: "fetch.php",
        type: "POST",
        data: function(d) {
          d.filter_category = $('#filter_category').val();
          d.filter_country = $('#filter_country').val();
        }
      },
      "initComplete": function() {
        var api = this.api();
        $('#customer_data_filter input')
          .off('.DT')
          .on('input.DT', function() {
            api.search(this.value).draw();
          });
      }
    });

    $('#filter').click(function() {
      dataTable.draw();
    });

    $('#reset').click(function() {
      $('#filter_category').val('');
      $('#filter_country').val('');
      dataTable.draw();
    });
  });
</script>
</body>
</html>
