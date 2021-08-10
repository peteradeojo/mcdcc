<?php

require '../init.php';
$stylesheets = ['//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css'];

require '../assets/snippets/header.php';

?>
<div class="container">
  <div class="row">
    <div class="s9">
      <h1>Patients</h1>
    </div>
    <div class="s3">
      <a href="/rec/addpatient.php" class="btn btn-dark">New Record</a>
    </div>

  </div>
  <table id="patients" class="table table-striped">
    <thead>
      <th></th>
      <th>Card Number</th>
      <th>Name</th>
      <th>Phone</th>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
<?php
$scripts = ['/rec/main.js'];
require_once '../assets/snippets/footer.php';
