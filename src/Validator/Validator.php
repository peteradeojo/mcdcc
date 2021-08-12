<?php

namespace Validator;

class Validator
{
  static function validateLogin()
  {
    if (@!$_SESSION['login']) {
      $script_name = explode('/', $_SERVER['SCRIPT_NAME']);
      $script_name = end($script_name);
      if ($script_name !== 'login.php') {
        header("Location: /login.php");
      }
      if ($script_name == 'logout.php') {
        return false;
      }
    } else {
      if (str_contains($_SERVER['SCRIPT_NAME'], '/api/')) {
        return false;
      }
      return true;
    }
  }

  static function redirectAuthorizedDomain(array $user)
  {
    $script_name = $_SERVER['SCRIPT_FILENAME'];
    $userdomain = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . strtolower($user['officeid']);
    $userdomain = str_replace('/', DIRECTORY_SEPARATOR, $userdomain);
    $script_name = str_replace('/', DIRECTORY_SEPARATOR, $script_name);
    // echo $script_name;
    // echo $userdomain;
    // exit();
    if (!str_starts_with($script_name, $userdomain)) {
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

  static function validateOptions($needle, array $haystack)
  {
    if (in_array(strtolower($needle), $haystack)) {
      return $needle;
    }
    return false;
  }

  /**
   * @param {string} string
   */
  static function validateName(string $string)
  {
    $string = Validator::sanitize($string);
    if (preg_match('/^[a-zA-Z -]{3,}$/', $string)) {
      return $string;
    }
    return false;
  }

  static function validateDate(string $date)
  {
    $date = Validator::sanitize($date);
    if (preg_match('/^((19|20)\d{2})-((0|1)\d)-((0|1|2|3)\d)$/', $date)) {
      return $date;
    }
    return false;
  }

  static function validatePhone(string $number)
  {
    $number = Validator::sanitize($number);
    if (preg_match('/^\d{11}$/', $number)) {
      return $number;
    }
    return false;
  }

  static function validateZipCode(string $code)
  {
    $code = Validator::sanitize($code);
    if (preg_match('/^\d{4,}$/', $code)) {
      return $code;
    }
    return false;
  }

  static function validatePatientNumber(string $cardnum)
  {
    $cardnum = Validator::sanitize($cardnum);
    if (preg_match('/^\S{3}-\d{7}$/', $cardnum)) {
      return $cardnum;
    }
    return false;
  }

  static function validateEmail(string $email)
  {
    $email = Validator::sanitize($email);
    if (preg_match('/^.+@.+\..+$/', $email)) {
      return $email;
    }
    return false;
  }

  static function sanitize($string)
  {
    return trim(htmlspecialchars(strip_tags($string)));
  }
}
