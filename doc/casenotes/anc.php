<?php
require 'card-init.php';
?>
<div class="container">
  <h3>Antenatal Details</h3>
  <ul class="list-group">
    <li class="list-group-item">Last Menstruation: <?= @$visitData->lastMenstruationDate ? $visitData->lastMenstruationDate : 'Not documented' ?></li>
    <li class="list-group-item">Last Ultrasound: <?= @$visitData->lastUltrasound ? $visitData->lastUltrasound : 'Not documented' ?></li>
    <li class="list-group-item"></li>
    <li class="list-group-item"></li>
  </ul>
</div>