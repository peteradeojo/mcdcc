<?php

require '../init.php';

// loadSnippet('header.php');
require "../snippets/header.php";
?>
<div class="container">
  <h1>Waiting List</h1>

  <ul id="waitlist" class="list-group">
  </ul>
</div>
<?php
$scripts = ['/nur/main.js'];
require '../snippets/footer.php';
?>