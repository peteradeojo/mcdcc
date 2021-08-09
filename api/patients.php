<?php

require '../init.php';

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
  }

  exit();
}

$patients = $db->join('patients', [['right', 'patient_details as pd', 'patients.cardnumber = pd.cardnumber']]);

$patients = array_map(function ($patient) {
  $patient['name'] = generateName($patient['firstname'], $patient['lastname']);
  return $patient;
}, $patients);

header("Content-type: application/json");
echo json_encode(['data' => $patients]);
