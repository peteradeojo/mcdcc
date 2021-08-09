<?php

namespace Validator;

class Validator
{
  static function validateLogin()
  {
    if (str_contains($_SERVER['SCRIPT_NAME'], '/api/')) {
      return false;
    }
    if (@!$_SESSION['login']) {
      $script_name = explode('/', $_SERVER['SCRIPT_NAME']);
      $script_name = end($script_name);
      if ($script_name !== 'login.php') {
        header("Location: /login.php");
      }
      if ($script_name == 'logout.php') {
        return;
      }
    } else {
      return true;
    }
  }

  static function redirectAuthorizedDomain(array $user)
  {
    $filename = $_SERVER['DOCUMENT_ROOT'] . '/' . $user['officeid'];
    if (!str_starts_with($_SERVER['SCRIPT_FILENAME'], $filename)) {
      header("Location: /{$user['officeid']}");
    }
  }

  static function validateUsername(string $str): string | false
  {
    $str = htmlspecialchars(trim($str));
    if (preg_match("/^[a-zA-Z0-9]{4,}$/", $str)) {
      return $str;
    }
    return false;
  }
  static function validatePassword(string $str): string | false
  {
    $str = htmlspecialchars(trim($str));
    if (preg_match("/^[a-zA-Z0-9_]{8,}$/", $str)) {
      return sha1($str);
    }
    return false;
  }
}
