<?php

use Validator\Validator;

if (!$_POST) {
  header("Location: /nur/waiting.php");
}
// print_r($_POST);
$patientid = Validator::validatePatientNumber($_POST['patient']);
$today = date('Y-m-d');
$appointment = $db->select(table: 'appointments', where: "patientid='$patientid' and appointment_date='$today'")[0];

if (!$appointment) {
  flash('info', "$patientid does not have an appointment booked for today. Please schedule an appointment");
  header("Location: /nur/waiting.php");
  exit();
}

// Restricting creation of visit file if patient does not have an appointment for the day
// print_r($appointment);

$temp = Validator::validateNumber($_POST['temp']);
$height = Validator::validateNumber($_POST['height']);
$weight = Validator::validateNumber($_POST['weight']);
$bp1 = Validator::validateNumber($_POST['bp1']);
$bp2 = Validator::validateNumber($_POST['bp2']);
$blood_pressure = "$bp1/$bp2";
$filename = bin2hex(random_bytes(24)) . ".json";
$data = ['patientid' => $patientid, 'height' => $weight, 'weight' => $weight, 'temp' => $temp, 'bp' => $blood_pressure, 'filename' => $filename];



// implementing file history creation
$files_dir = str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT'] . '/confidential/patient_visits/');
$csv_file = $_SERVER['DOCUMENT_ROOT'] . '/confidential/patient_visits/' . $filename;
$csv_file = str_replace("/", DIRECTORY_SEPARATOR, $csv_file);
if (!is_dir($files_dir)) {
  // echo "directory does not exist";
  mkdir($files_dir, recursive: true);
}

// Write information to CSV file
$fh = fopen($csv_file, 'a+');
if (fwrite($fh, json_encode($data))) {
  try {
    //code...
    // echo json_encode($data);
    $db->insert(table: 'history', rowval: $data);
    $appointment['appointment_status'] = 2;
    $db->update(table: 'appointments', data: $appointment, where: "id=$appointment[id]");
    flash('info', data: "Vitals signs registered successfully");
  } catch (Exception $e) {
    //throw $th;
    flash(mode: 'info', data: $e->getMessage());
  }
  header("Location: /nur/vitals.php?patient=$patientid");
  exit();
}

flash('info', 'Patient visit was not registered successfully. Please contact the IT administrator');
header("Location: /nur/vitals.php?patient=$patientid");
