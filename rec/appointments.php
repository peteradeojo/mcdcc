<?php

require '../init.php';

require '../snippets/header.php';
?>
<div class="container">
  <h1>Appointments</h1>
</div>
<div class="container">
  <table id="appointments-table" class="table">
    <thead>
      <th>Patient</th>
      <th>Date</th>
      <th>Status</th>
      <th></th>
    </thead>
    <tbody>
      <?php
      $appointments = $db->join(table1: 'appointments', joins: [['left', 'patients as p', 'appointments.patientid = p.cardnumber']], where: "appointment_date");
      foreach ($appointments as $appointment) {
        $appointment['status'] = parseAppointmentStatus($appointment['appointment_status']);
        echo <<<_
            <tr>
              <td>$appointment[lastname] $appointment[firstname]</td>
              <td>$appointment[appointment_date]</td>
              <td>$appointment[status]</td>
              <td><a href="/rec/patient.php?id=$appointment[patientid]" class="btn btn-warning">View</a></td>
            </tr>
          _;
      }
      ?>
    </tbody>
  </table>
</div>
<?php
$scripts = ['/rec/main.js'];
require '../snippets/footer.php';
