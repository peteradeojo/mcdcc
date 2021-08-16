<?php

use Validator\Validator;

require '../../../init.php';

if ($_POST['query']) {
  // echo json_encode($_POST);
  $query = Validator::sanitize($_POST['query']);
  try {
    $ret = $db->query($query);
    echo json_encode(['data' => $ret]);
  } catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
  }
}
