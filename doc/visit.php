<?php

use Validator\Validator;

require '../init.php';

if ($_POST) {
  exit();
}

if (!$_GET['patient']) {
  flash('info', 'No patient ID supplied');
  header("Location: /doc/waitlist.php");
}
$patient = Validator::validatePatientNumber($_GET['patient']);
if (!$patient) {
  flash('info', 'The patient ID is not valid');
  header("Location: /doc/waitlist.php");
}

$patient = $db->join(table1: 'appointments', joins: [['left', 'patients as p', 'appointments.patientid = p.cardnumber'], ['left', 'history as h', 'appointments.id= h.appointmentid']], where: "appointments.patientid = p.cardnumber and appointments.patientid = '$patient' and h.appointmentid = appointments.id", rows: 'appointments.id as appid, appointments.*, p.*, h.*')[0];

if (!$patient) header("Location: /doc/waitlist.php");

// flash('info', 'Please do not leave this page until the patient is done with their visit');
require '../snippets/header.php';
?>
<div class="container">
  <a href="/doc/waitlist.php">Back to waiting list</a>
  <div class="row">
    <div class="col-md-6">
      <h1><?= "$patient[lastname] $patient[firstname]" ?></h1>
      <form action="visit.php" method="post">
        <div class="form-group">
          <label for="description">Complaint/Description</label>
          <textarea name="description" id="description" cols="30" class="form-control"></textarea>
        </div>
        <?php
        $casenote = getPatientType($patient['cardnumber']);
        require "forms/$casenote.php";
        ?>
        <div class="form-group">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
    <div class="col-md-6 overflow-auto">
      <?php
      require "casenotes/$casenote.php";
      ?>
    </div>
  </div>
</div>
<?php
$scripts = ['https://cdnjs.cloudflare.com/ajax/libs/jquery.AreYouSure/1.9.0/jquery.are-you-sure.min.js', 'visit.js'];
require '../snippets/footer.php';
