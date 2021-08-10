<?php

use Validator\Validator;

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

if (@$_GET['data'] === 'new') {
  $category = Validator::validateOptions($_GET['category'], ['per', 'anc', 'ped', 'fam']);
  if ($category) {
    $category = strtoupper($category);
    $lastNumber = $db->select('patients', 'max(cardnumber) as number', "cardnumber LIKE '$category-%'")[0];
    if ($lastNumber['number']) {
      [$cat, $number, $date] = analyseCardNumber($lastNumber['number']);
      echo json_encode(['data' => "$cat-$number$date"]);
    } else {
      echo json_encode(['data' => "$category-001" . date("my")]);
    }
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
