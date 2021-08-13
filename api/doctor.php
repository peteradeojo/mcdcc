<?php

require '../init.php';

switch ($_GET['data']) {
  case 'waitlist':
    $waitlist = $db->join(table1: 'appointments', joins: [['left', 'patients as p', 'appointments.patientid = p.cardnumber']]);
    $waitlist = array_map(function ($wait) {
      $wait['status'] = parseAppointmentStatus($wait['appointment_status']);
      return $wait;
    }, $waitlist);
    echo json_encode(['data' => $waitlist]);
    break;
}
