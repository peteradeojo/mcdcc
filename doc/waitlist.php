<?php

require '../init.php';

$title = "Waitlist";
require '../snippets/header.php';
?>
<div class="container">
  <h1>Waitlist</h1>
</div>
<div class="container">
  <table id="waitlist-table" class="table datatable">
    <thead>
      <tr>
        <th>Patient</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $waitlist = $db->join('appointments', [['inner', 'patients as p', 'appointments.patientid = p.cardnumber'], ['right', 'history as h', 'h.patientid=appointments.patientid']], where: "appointments.appointment_date = '$today'");
      $waitlist = array_map(function ($wait) {
        $wait['status'] = parseAppointmentStatus($wait['appointment_status']);
        $wait['name'] = generateName($wait);
        return $wait;
      }, $waitlist);

      foreach ($waitlist as $wait) {
        echo "<tr>
          <td>$wait[name]</td>
          <td>$wait[status]</td>
          <td class='text-center'>";
        if ($wait['appointment_status'] == '2') {
          echo "<a href='/doc/visit.php?patient=$wait[cardnumber]' class='btn btn-primary'>Begin Visit</a>";
        }
        echo "</td>
        </tr>";
      }
      ?>
    </tbody>
  </table>
</div>
<?php
$scripts = ['waitlist.js'];
require '../snippets/footer.php';
