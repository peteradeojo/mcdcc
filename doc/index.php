<?php
require '../init.php';

$title = "Doctor";
require '../snippets/header.php';
?>

<div class="container">
  <h1><?= $user['name'] ?></h1>
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h3>Waiting List</h3>
        </div>
        <div class="card-body">
          <p class="display-1">
            <?= $db->select(table: 'appointments', rows: 'count(id) as num', where: "appointment_date='$today'")[0]['num']; ?>
          </p>
        </div>
        <div class="card-footer">
          <a href="/doc/waitlist.php">Attend to a patient</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h3>Admissions</h3>
        </div>
        <div class="card-body">
          <p class="display-1">
            <?= $db->select('admissions', rows: 'count(id) as num')[0]['num'] ?>
          </p>
        </div>
        <div class="card-footer">
          <a href="/doc/admissions.php">Manage your admissions</a>
        </div>
      </div>
    </div>
    <!-- <div class="col-md-4">
      <div class="card">
        <div class="card-header"></div>
        <div class="card-body"></div>
      </div>
    </div> -->
  </div>
</div>
<?php
require '../snippets/footer.php';
