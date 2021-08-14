<?php
// Some useful functions to have

function generateName(array $data = null)
{
  $data['middlename'] = @$data['middlename'] ? $data['middlename'] : null;
  return "$data[lastname] $data[firstname] $data[middlename]";
}


/**
 * A function to analyse and identify different portions of a patients card
 * number. resolve into separate parts
 */
function analyseCardNumber($number)
{
  $number = explode('-', $number);
  $cat = $number[0];
  $digits = $number[1];
  preg_match('/(\d{2,3})(\d{4})/', $digits, $analysed);
  $id = $analysed[1];
  $date = $analysed[2];
  // $id += 1;
  return [$cat, $id, $date];
}

/**
 * flash - function to set flash and retrieve variables
 */
function flash($mode, $data = null)
{
  if (!$data) {
    $return = @$_SESSION[$mode];
    unset($_SESSION[$mode]);
    return $return;
  } else {
    $_SESSION[$mode] = $data;
  }
}


/**
 * Generate time/date according to format
 */
function generateTime(string $format = 'Y-m-d H:i:s')
{
  return date($format);
}

// function loadSnippet(string $snippet) {
//   // require 
//   $file = $_SERVER['DOCUMENT_ROOT']. "/assets/snippets/$snippet";
//   $file = str_replace("/", DIRECTORY_SEPARATOR, $file);
//   $file = str_replace("\\", DIRECTORY_SEPARATOR, $file);
//   return require $file;
// }

function parseAppointmentStatus(int $status)
{
  $result = '';
  switch ($status) {
    case 0:
      $result = 'Pending';
      break;
    case 1:
      $result = 'Waitlisted';
      break;
    case 2:
      $result = 'Vitals Taken';
      break;
    case 2:
      $result = 'Currently seeing a doctor';
      break;
    case 4:
      $result = 'Fulfilled';
      break;
    case 9:
      $result = 'Unfulfilled';
      break;
    case 10:
      $result = 'Rescheduled';
      break;
  }
  return $result;
}

function getPatientType(string $patientid)
{
  $category = explode('-', $patientid);
  return strtolower($category[0]);
}


/**
 * load and display Vitals in a list
 */
function showVitals($visit)
{
  echo <<<_
    <div class="container">
      <h3>Vital Signs</h3>
      <ul class="list-group">
        <li class="list-group-item">Temperature: $visit->temp (&deg;C)</li>
        <li class="list-group-item">Weight: $visit->weight (kg)</li>
        <li class="list-group-item">Blood Pressure: $visit->bp (mmHg)</li>
        <li class="list-group-item">Pulse Rate: $visit->pulse_rate (bpm)</li>
        <li class="list-group-item">Height: $visit->height (cm)</li>
      </ul>
    </div>
  _;
}

function getPatientVisitData($filename)
{
  $visitFile = str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT'] . '/confidential/patient_visits/' . $filename);

  $visitData = json_decode(file_get_contents($visitFile));
  return $visitData;
}
