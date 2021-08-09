<?php

spl_autoload_register(function ($path) {
  $root = $_SERVER['DOCUMENT_ROOT'];
  $file = join(DIRECTORY_SEPARATOR, [$root, 'src', "$path.php"]);
  require $file;
});
