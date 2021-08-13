<?php

use Validator\Validator;

require '../init.php';

if ($_POST) {
  require './processvitals.php';
  exit();
}

if (!$_GET['patient']) {
  header("Location: /nur/waiting.php");
}
$patientid = Validator::validatePatientNumber($_GET['patient']);
if (!$patientid) {
  header("Location: /nur/waiting.php");
}

$patient = $db->select(table: 'patients', where: "cardnumber='$patientid'")[0];
@$patientsHistory = $db->select(table: 'history', where: "patientid='$patientid'")[0];
require '../snippets/header.php';

?>

<div class="container">
  <h1><?= "$patient[lastname] $patient[firstname]" ?>'s <small>vital signs</small></h1>
  <?php
  // print_r($patient);
  // echo "<br>";
  // print_r($patientsHistory);
  ?>
  <form <?=$patientsHistory ? "" : "action='/nur/vitals.php'" ?> method="POST">
    <div class="form-group col-md-6">
      <input type="text" name="patient" id="patientid" class="form-control" readonly value="<?= $patient['cardnumber'] ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="temp">Temperature (&deg;C)</label>
      <input type="number" name="temp" id="temp" class='form-control' step="0.1" value="<?= @$patientsHistory['temp'] ?>" required>
    </div>
    <div class="form-group col-md-6">
      <label for="weight">Weight (kg)</label>
      <input type="number" name="weight" id="weight" class='form-control' step="0.1" value="<?= @$patientsHistory['weight'] ?>" required>
    </div>
    <div class="form-group col-md-6">
      <label for="bp">Blood Pressure (mmHg)</label>
      <div class="row">
        <div class="col-sm-5">
          <input type="number" name="bp1" id="bp" class='form-control' value="<?= explode('/', @$patientsHistory['bp'])[0] ?>">
        </div>
        <div class="col-sm-2 text-center">
          <span class='h1'>/</span>
        </div>
        <div class="col-sm-5">
          <input type="number" name="bp2" id="bp2" class='form-control' value="<?= explode('/', @$patientsHistory['bp'])[1] ?>">
        </div>
      </div>
    </div>
    <div class="form-group col-md-6">
      <label for="height">Height (cm)</label>
      <input type="number" name="height" id="height" step="0.1" class='form-control' value="<?= @$patientsHistory['height'] ?>">
    </div>
    <?php
    if (!$patientsHistory) {
      echo <<<_
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        _;
    }
    ?>
  </form>
</div>
<?php
require '../snippets/footer.php';
