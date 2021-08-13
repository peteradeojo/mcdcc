<?php

use Validator\Validator;

require '../init.php';


$stylesheets = [];
require '../snippets/header.php';


?>

<div class="container">
  <div class="row">
    <div class="s4 card">
      <a href="/rec/patients.php">
        <div class="card-body">
          <h3>Patients</h3>
          <div>
            <h1 id="patients"></h1>
          </div>
        </div>
      </a>
    </div>
    <div class="s4 card">
      <a href="/rec/treatments.php">
        <div class="card-body">
          <h3>Treatments</h3>
          <div>
            <h1 id="treatments"></h1>
          </div>
        </div>
      </a>
    </div>
    <div class="s4 card">
      <a href="/rec/appointments.php">
        <div class="card-body">
          <h3>Appointments</h3>
          <div>
            <h1 id="appointments"><?= $db->select(table: 'appointments', rows: 'count(id) as num', where: "appointment_date >= '$today'")[0]['num'] ?></h1>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>


<?php

$scripts = ['/rec/main.js'];
require '../snippets/footer.php';
