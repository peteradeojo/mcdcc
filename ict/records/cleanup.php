<?php

require '../../init.php';

require '../../snippets/header.php';
?>
<div class="container">
  <?php
  if (!$_GET) {
    require 'database-list.php';
  } else {
    $database = $_GET['database'];
    if (@$_GET['table']) {
      $table = $_GET['table'];
      require 'table-view.php';
    } else {
      require 'database-view.php';
    }
  }
  ?>
</div>
<?php
$scripts = ['/ict/records/cleanup.js'];
require '../../snippets/footer.php';
