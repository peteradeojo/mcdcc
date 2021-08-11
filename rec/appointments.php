<?php

use Validator\Validator;

require '../init.php';

switch ($_GET['data']) {
  case 'new':
    $id = Validator::validatePatientNumber($_POST['id']);
    $date = Validator::validateDate($_POST['date']);
    if ($id and $date) {
      // echo "$date";
      if ($date < date('Y-m-d')) {
        // echo "Invalid date";
        flash('info', 'Invalid Date supplied. Please choose a date from today onward');
        header("Location: /rec/patients.php");
        exit();
      }
      try {
        $check = $db->select('appointments', null, "patientid='$id' and appointment_date='$date'")[0];
        if (!$check) {
          $db->insert('appointments', ['patientid' => "'$id'", 'appointment_date' => "'$date'"]);
        } else {
          flash('info', 'An appointment is already booked on this date for this patient');
        }
      } catch (Exception $e) {
        flash('info', $e->getMessage());
      } finally {
        header("Location: /rec/patient.php?id=$id");
      }
    } else {
      flash('info', 'Invalid Patient Card Number supplied');
      header("Location: /rec/patients.php");
      exit();
    }
}
