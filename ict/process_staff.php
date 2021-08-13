<?php

use Validator\Validator;

if ($_POST) {
  print_r($_POST);

  $staff['title'] = Validator::validateOptions($_POST['title'], ['mr.', 'mrs.', 'dr.', 'dr(mrs)']);
  $staff['firstname'] = Validator::validateName($_POST['firstname']);
  $staff['lastname'] = Validator::validateName($_POST['lastname']);
  $staff['middlename'] = Validator::validateName($_POST['middlename']);
  $staff['phone'] = Validator::validatePhone($_POST['phone']);
  $staff['email'] = Validator::validateEmail($_POST['email']);
  $staff['update_time'] = date('Y-m-d H:i:s');

  try {
    //code...
    $db->update(table: 'staff', data: $staff, where: "id='$staff[id]'");
    flash('info', "Staff records updated successfully");
  } catch (Exception $e) {
    flash('info', $e->getMessage());
  }

  print_r($staff);
} else {
  flash('info', 'That area is restricted');
}
header("Location: /ict/staff.php");
