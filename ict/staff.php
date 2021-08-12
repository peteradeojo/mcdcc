<?php

require '../init.php';


if (@$_GET['id']) {
  if (!$_POST) {
    $id = $_GET['id'];
    $staff = $db->select('staff', null, "id='$id'")[0];
    require '../assets/snippets/header.php';
    require './onestaff.php';
    require '../assets/snippets/footer.php';
  } else {
    echo "POSTED";
  }
} else {
  $stylesheets = [];
  require '../assets/snippets/header.php';
?>

  <div class="container">
    <div class="d-flex mb-4">
      <div class="col-sm-8">
        <h1>Manage Staff</h1>
      </div>
      <div class="col-sm-4">
        <a href="/ict/newstaff.php" class="btn btn-success">New Staff</a>
      </div>
    </div>

    <table class="table datatable" id="staff-table">
      <thead>
        <th></th>
        <th>Title</th>
        <th>Name</th>
        <th>Position</th>
      </thead>
      <tbody></tbody>
    </table>
  </div>

<?php
}
$scripts = ['/ict/main.js'];
require '../assets/snippets/footer.php';
