<?php

require '../init.php';

$stylesheets = [];

require '../snippets/header.php';

?>
<div class="container">
  <h1>ICT</h1>
  <div class="row">
    <div class="col-sm-4 p-2">
      <div class="card">
        <div class="card-header">
          <h2>Staff</h2>
        </div>
        <div class="card-body">
          <p>Manage Staff</p>
          <a href="/ict/staff.php">Manage</a>
        </div>
      </div>
    </div>
    <div class="col-sm-4 p-2"></div>
    <div class="col-sm-4 p-2"></div>
  </div>
</div>
<?php

$scripts = [];
require '../snippets/footer.php';
