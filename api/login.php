<?php

use Database\Database;
use Validator\Validator;

require '../init.php';

if ($_POST['username']) {
  $user = Validator::validateUsername($_POST['username']);
  $pass = Validator::validatePassword($_POST['password']);

  $db = new Database();

  $user = $db->select('staff', "username, password", "username='$user' and password='$pass'")[0];
  if ($user) {
    $_SESSION['login'] = ['status' => true, 'user' => $user['username']];
    header("Location: /");
  } else {
    header("Location: /login.php");
  }
}
