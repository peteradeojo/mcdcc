<?php
// Some useful functions to have

function generateName($firstname, $lastname, $middlename = null)
{
  return "$lastname $firstname $middlename";
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
