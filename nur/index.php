<?php

require '../init.php';

require '../snippets/header.php';
?>
<div class="container">
  <h1>Dashboard</h1>
  <div class="bg-primary p-1 rounded rounded-lg my-3 col-md-6 text-center m-auto">
    <a href="/nur/waiting.php" class="text-white my-0">You have
      <span id="waitlist-count">0</span> patient(s) in the waiting area.
    </a>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-4">
      <div class="card">
        <div class="card-header">
          <h3>Admissions</h3>
        </div>
        <a href="/nur/admissions.php" class="text-decoration-none">
          <div class="card-body">
            <p class="display-1"><span id="admissions-count" class="text-dark">0</span></p>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>
<?php
$scripts = ['/nur/main.js'];
require '../snippets/footer.php';
