<?php
session_start();

define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']);

use Dotenv\Dotenv;
use Database\Database;
use Validator\Validator;

require DOC_ROOT . '/vendor/autoload.php';
require DOC_ROOT . '/src/autoload.php';
require DOC_ROOT . '/src/functions.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();
$today = date('Y-m-d');

@$user = $db->select('staff', null, "username='{$_SESSION['login']['user']}'")[0];
@$user['name'] = generateName($user);

if (Validator::validateLogin()) {
  Validator::redirectAuthorizedDomain($user);
}
