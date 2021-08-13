<?php

use Validator\Validator;

require '../init.php';

/**
 * GET the number specified data
 */
if (@$_GET['return'] === 'count') {
  switch (@$_GET['data']) {
    case 'patients':
      $patients = $db->select('patients', 'count(id) as num')[0];
      echo json_encode(['data' => $patients['num']]);
      break;
    case 'treatments':
      $treatments = $db->select('treatments', 'count(cardnumber) as num')[0];
      echo json_encode(['data' => $treatments['num']]);
      break;
    case 'waitlisted':
      $today = date('Y-m-d');
      $count = $db->select('appointments', 'count(id) as num', "appointment_date >= '$today' and appointment_status <= '2'")[0];
      echo json_encode(['data' => $count]);
  }

  exit();
}

switch (@$_GET['data']) {
    /**
   * GET the next available card number
   */
  case 'new':
    $category = Validator::validateOptions($_GET['category'], ['per', 'anc', 'ped', 'fam', 'fer']);
    if ($category) {
      $category = strtoupper($category);
      $lastNumber = $db->select('patients', 'max(cardnumber) as number', "cardnumber LIKE '$category-%'")[0];
      if ($lastNumber['number']) {
        [$cat, $number, $date] = analyseCardNumber($lastNumber['number']);
        if ($date == date(('my'))) {
          $number++;
          if ($number < 10) $number = "00" . $number;
          else if ($number < 100) $number = "0" . $number;
        } else {
          $number = "001";
          $date = date('my');
        }
        echo json_encode(['data' => "$cat-$number$date"]);
      } else {
        echo json_encode(['data' => "$category-001" . date("my")]);
      }
    }
    exit();
    break;
    /**
     * GET a patients last 5 appointments
     */
  case 'appointments':
    if (!$_GET['id']) {
      http_response_code(404);
      echo json_encode(['error' => 'No Patient ID was supplied']);
    } else {
      try {
        $appointments = $db->select('appointments', 'patientid, appointment_date as date, appointment_status as status', "patientid='$_GET[id]'", ['date ASC', 'create_time DESC']);
        $apps = array_map(function ($appointent) {
          $appointent['acc_date'] = new DateTime($appointent['date']);
          switch ($appointent['status']) {
            case 0:
              $appointent['status_msg'] = 'Pending';
              break;
            case 1:
              $appointent['status_msg'] = 'Waitlisted';
              break;
            case 2:
              $appointent['status_msg'] = 'Vitals Taken';
              break;
            case 2:
              $appointent['status_msg'] = 'Currently seeing a doctor';
              break;
            case 4:
              $appointent['status_msg'] = 'Fulfilled';
              break;
          }
          return $appointent;
        }, $appointments);
        echo json_encode(['data' => $apps]);
      } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
      } finally {
        exit();
      }
    }
    break;
  case 'check-in':
    // echo json_encode($_POST);
    $id = Validator::validatePatientNumber($_POST['id']);
    $date = Validator::validateDate($_POST['date']);
    if ($id and $date) {
      try {
        //code...
        $appointment = $db->select('appointments', null, "patientid='$id' AND appointment_date='$date'");
        if (count($appointment) > 1) {
          for ($i = 1; $i < count($appointment); $i += 1) {
            $del_id = $appointment[$i]['id'];
            $db->delete('appointments', "id='$del_id'");
          }
        }

        $appointment = $appointment[0];
        $appointment['appointment_status'] = 1;
        $appointment['check_in_time'] = generateTime();
        $appointment['update_time'] = generateTime();
        $db->update('appointments', $appointment, "id='$appointment[id]'");
        echo json_encode(['data' => $appointment]);
      } catch (Exception $e) {
        // http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
      }
    } else {
      http_response_code(400);
      echo json_encode(['error' => 'Invalid Parameters supplied']);
    }
    break;
  case 'waitlist':
    try {
      //code...
      $today = date('Y-m-d');
      $waitlist = $db->join(table1: 'appointments', joins: [
        ['inner', 'patients as p', 'appointments.patientid = p.cardnumber'],
      ], where: "appointments.appointment_date >= '$today' and appointments.appointment_status <= '2'");
      $waitlist = array_map(function ($wait) {
        $wait['date'] = $wait['appointment_date'];
        $wait['status'] = parseAppointmentStatus($wait['appointment_status']);
        return $wait;
      }, $waitlist);

      echo json_encode(['data' => $waitlist]);
    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
    break;
  default:
    $patients = $db->join('patients', [['right', 'patient_details as pd', 'patients.cardnumber = pd.cardnumber']]);

    $patients = array_map(function ($patient) {
      $patient['name'] = generateName($patient['firstname'], $patient['lastname']);
      return $patient;
    }, $patients);

    header("Content-type: application/json");
    echo json_encode(['data' => $patients]);
}
