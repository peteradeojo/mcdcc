<?php

require '../init.php';

// loadSnippet('header.php');
require "../assets/snippets/header.php";
?>
<div class="container">
  <h1>Waiting List</h1>

  <ul id="waitlist" class="list-group">
    <?php
    $today = date('Y-m-d');
    try {
      //code...
      $waitlist = $db->join(table1: 'appointments', joins: [['inner', 'patients as p', 'appointments.patientid = p.cardnumber']], where: "appointments.appointment_date >= '$today' or appointments.appointment_status = '1'");
      // print_r($waitlist);
      foreach ($waitlist as $patient) {
        echo <<<_
        <li class='appointment list-group-item'>
          <p><span class="label">Patient: </span>$patient[lastname] $patient[firstname]</p>
          <p><span class="label">Date: </span>$patient[appointment_date]</p>
        </li>
        _;
      }
    } catch (Exception $e) {
      //throw $th;
      echo $e->getMessage();
    }
    ?>
  </ul>
</div>
<?php
// $scripts = ['/'];
require '../assets/snippets/footer.php';
?>