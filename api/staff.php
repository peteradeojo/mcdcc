<?php

require '../init.php';

switch (@$_GET['data']) {
  case 'find':
    try {
      $username = @$_GET['username'];
      $id = @$_GET['id'];
      echo json_encode($db->select('staff', null, "username='$_GET[username]' or id='$id'"));
    } catch (Exception $e) {
      //throw $th;
      http_response_code(400);
      echo json_encode(['error' => $e->getMessage()]);
    }
    break;
  default:
    $staff = $db->select('staff', 'id, firstname, lastname, email, post, phone, title');
    $staff = array_map(function ($staff) {
      $staff['name'] = generateName($staff['firstname'], $staff['lastname']);
      return $staff;
    }, $staff);
    echo json_encode(['data' => $staff]);
}
